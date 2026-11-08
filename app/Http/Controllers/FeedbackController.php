<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Project;
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
            ->with('project')
            ->latest()
            ->get();
    } else {
        // Admins can see feedback from their own projects
        $feedback = Feedback::whereHas('project', function ($query) {
            $query->where('user_id', Auth::id());
        })
            ->with('project', 'user')
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

    $projects = Auth::user()
        ->assignedProjects()
        ->where('status', 'collecting')
        ->latest()
        ->get();

    $existingFeedback = null;

    if ($request->filled('project_id')) {
        $project = $projects->firstWhere(
            'id',
            $request->project_id
        );

        if ($project) {
            $existingFeedback = Feedback::where('project_id', $project->id)
                ->where('user_id', Auth::id())
                ->first();
        }
    }

    return view('pages.feedback.create', compact(
        'projects',
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
        'project_id' => 'required|exists:projects,id',
        'feedback_text' => 'required|string|min:3',
    ]);

    // Verify that the project is assigned to this Tester
    $project = Auth::user()
        ->assignedProjects()
        ->where('status', 'collecting')
        ->findOrFail($validated['project_id']);

    // Prevent duplicate feedback submissions
    $existingFeedback = Feedback::where('project_id', $project->id)
        ->where('user_id', Auth::id())
        ->first();

    if ($existingFeedback) {
        return redirect()
            ->route('feedback.edit', $existingFeedback)
            ->with('info', 'You have already submitted feedback for this project. You can edit your existing feedback.');
    }

    // Save feedback
    $feedback = Feedback::create([
        'project_id' => $project->id,
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

    // Testers can only edit feedback from collecting projects
    if (Auth::user()->hasRole('tester')) {
        abort_unless(
            $feedback->project->status === 'collecting',
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

    // Testers cannot update feedback from completed projects
    if (Auth::user()->hasRole('tester')) {
        abort_unless(
            $feedback->project->status === 'collecting',
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

    // Admins can only access feedback from their own projects
    abort_unless(
        Auth::user()->hasRole('admin') &&
        $feedback->project()->where('user_id', Auth::id())->exists(),
        403
    );
}
    
}
