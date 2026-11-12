<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasRole('tester')) {
            // Testers can only see their own feedback
            $feedback = Feedback::where('user_id', Auth::id())
                ->with('product')
                ->latest()
                ->get();
        } else {
            // Admins can see feedback from their own products
            $feedback = Feedback::whereHas('product', function ($query) {
                $query->where('user_id', Auth::id());
            })
                ->with('product', 'user')
                ->latest()
                ->get();
        }

        return view('pages.feedback.index', compact('feedback'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        abort_unless(Auth::user()->hasRole('tester'), 403);

        $products = Auth::user()
            ->assignedProducts()
            ->where('status', 'collecting')
            ->latest()
            ->get();

        $existingFeedback = null;

        if ($request->filled('product_id')) {
            $product = $products->firstWhere(
                'id',
                $request->product_id
            );

            if ($product) {
                $existingFeedback = Feedback::where('product_id', $product->id)
                    ->where('user_id', Auth::id())
                    ->first();
            }
        }

        return view('pages.feedback.create', compact(
            'products',
            'existingFeedback'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Only Testers can submit feedback
        abort_unless(Auth::user()->hasRole('tester'), 403);

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'feedback_text' => 'required|string|min:3',
        ]);

        // Verify that the product is assigned to this Tester
        $product = Auth::user()
            ->assignedProducts()
            ->where('status', 'collecting')
            ->findOrFail($validated['product_id']);

        // Prevent duplicate feedback submissions
        $existingFeedback = Feedback::where('product_id', $product->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingFeedback) {
            return redirect()
                ->route('feedback.edit', $existingFeedback)
                ->with('info', 'You have already submitted feedback for this product. You can edit your existing feedback.');
        }

        // Save feedback
        $feedback = Feedback::create([
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'feedback_text' => $validated['feedback_text'],
            'sentiment' => null,
        ]);

        // Analyze sentiment using Python
        try {
            $response = Http::timeout(60)->post(
                'http://127.0.0.1:8001/analyze',
                [
                    'text' => $feedback->feedback_text,
                ]
            );

            if ($response->successful()) {
                $sentiment = $response->json('sentiment');

                if (in_array($sentiment, ['positive', 'neutral', 'negative'])) {
                    $feedback->update([
                        'sentiment' => $sentiment,
                    ]);
                }
            }
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            report($e);
        }

        return redirect()
            ->route('feedback.index')
            ->with('success', 'Feedback submitted successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Feedback $feedback)
    {
        $this->authorizeFeedback($feedback);

        return view('pages.feedback.show', compact('feedback'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Feedback $feedback)
    {
        $this->authorizeFeedback($feedback);

        // Testers can only edit feedback from collecting products
        if (Auth::user()->hasRole('tester')) {
            abort_unless(
                $feedback->product->status === 'collecting',
                403
            );
        }

        return view('pages.feedback.edit', compact('feedback'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Feedback $feedback)
    {
        $this->authorizeFeedback($feedback);

        // Testers cannot update feedback from completed products
        if (Auth::user()->hasRole('tester')) {
            abort_unless(
                $feedback->product->status === 'collecting',
                403
            );
        }

        $validated = $request->validate([
            'feedback_text' => 'required|string|min:3',
        ]);

        // Update the existing feedback
        $feedback->update([
            'feedback_text' => $validated['feedback_text'],
            'sentiment' => null,
        ]);

        // Reanalyze the updated feedback
        try {
            $response = Http::timeout(60)->post(
                'http://127.0.0.1:8001/analyze',
                [
                    'text' => $feedback->feedback_text,
                ]
            );

            if ($response->successful()) {
                $sentiment = $response->json('sentiment');

                if (in_array($sentiment, ['positive', 'neutral', 'negative'])) {
                    $feedback->update([
                        'sentiment' => $sentiment,
                    ]);
                }
            }
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            report($e);
        }

        return redirect()
            ->route('feedback.index')
            ->with('success', 'Feedback updated and reanalyzed successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Feedback $feedback)
    {
        $this->authorizeFeedback($feedback);

        // Prevent testers from deleting feedback on completed products
        if (Auth::user()->hasRole('tester')) {
            abort_unless(
                $feedback->product->status === 'collecting',
                403
            );
        }

        $feedback->delete();

        return redirect()
            ->route('feedback.index')
            ->with('success', 'Feedback deleted successfully!');
    }

    private function authorizeFeedback(Feedback $feedback): void
    {
        // Testers can only access their own feedback
        if (Auth::user()->hasRole('tester')) {
            abort_unless(
                (int) $feedback->user_id === (int) Auth::id(),
                403
            );

            return;
        }

        // Admins can only access feedback from their own products
        abort_unless(
            Auth::user()->hasRole('admin') &&
            $feedback->product()->where('user_id', Auth::id())->exists(),
            403
        );
    }
}
