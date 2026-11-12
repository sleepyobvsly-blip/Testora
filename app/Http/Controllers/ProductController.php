<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the seller's products.
     */
    public function index()
    {
        $products = Product::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('pages.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        return view('pages.products.create');
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Product::create([
            ...$validated,
            'user_id' => Auth::id(),
            'status' => 'draft',
            'upload_fee' => 150.00,
            'payment_status' => 'pending',
            'paid_at' => null,
        ]);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product created successfully! You can publish it after confirming the upload fee.');
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        abort_unless($product->user_id === Auth::id(), 403);

        return view('pages.products.show', compact('product'));
    }

    /**
     * Show the form for editing a product.
     */
    public function edit(Product $product)
    {
        abort_unless($product->user_id === Auth::id(), 403);

        return view('pages.products.edit', compact('product'));
    }

    /**
     * Update product details without allowing direct status changes.
     */
    public function update(Request $request, Product $product)
    {
        abort_unless($product->user_id === Auth::id(), 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Show simulated publishing payment confirmation.
     */
    public function showPayment(Product $product)
    {
        abort_unless($product->user_id === Auth::id(), 403);

        if ($product->status !== 'draft') {
            return redirect()
                ->route('products.index')
                ->with('error', 'Only draft products can be published.');
        }

        if ($product->payment_status === 'paid_simulated') {
            return redirect()
                ->route('products.index')
                ->with('info', 'This product has already been paid for.');
        }

        return view('pages.products.payment', compact('product'));
    }

    /**
     * Confirm simulated publishing payment.
     */
    public function confirmPayment(Request $request, Product $product)
    {
        abort_unless($product->user_id === Auth::id(), 403);

        if ($product->status !== 'draft') {
            return redirect()
                ->route('products.index')
                ->with('error', 'This product cannot be published.');
        }

        if ($product->payment_status === 'paid_simulated') {
            return redirect()
                ->route('products.index')
                ->with('info', 'This product has already been paid for.');
        }

        $product->update([
            'payment_status' => 'paid_simulated',
            'paid_at' => now(),
            'status' => 'collecting',
        ]);

        return redirect()
            ->route('products.index')
            ->with('success', 'Simulated payment confirmed! Your product is now collecting feedback.');
    }


    /**
     * Mark a collecting product as completed.
     */
    public function complete(Product $product)
    {
        abort_unless($product->user_id === Auth::id(), 403);

        if ($product->status !== 'collecting') {
            return redirect()
                ->route('products.show', $product)
                ->with('error', 'Only collecting products can be completed.');
        }

        if ($product->payment_status !== 'paid_simulated' &&
            $product->payment_status !== 'paid') {
            return redirect()
                ->route('products.show', $product)
                ->with('error', 'This product has not completed its publishing payment.');
        }

        $product->update([
            'status' => 'completed',
        ]);

        return redirect()
            ->route('products.show', $product)
            ->with('success', 'Product testing has been completed successfully!');
    }


    public function reopen(Product $product)
    {
        abort_unless($product->user_id === Auth::id(), 403);

        if ($product->status !== 'completed') {
            return redirect()
                ->route('products.show', $product)
                ->with('error', 'Only completed products can be reopened.');
        }

        if (
            $product->payment_status !== 'paid_simulated' &&
            $product->payment_status !== 'paid'
        ) {
            return redirect()
                ->route('products.show', $product)
                ->with('error', 'This product has not completed its publishing payment.');
        }

        $product->update([
            'status' => 'collecting',
        ]);

        return redirect()
            ->route('products.show', $product)
            ->with('success', 'Product testing has been reopened successfully!');
    }


    /**
     * Delete the specified product.
     */
    public function destroy(Product $product)
    {
        abort_unless($product->user_id === Auth::id(), 403);

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Product deleted successfully!');
    }
}
