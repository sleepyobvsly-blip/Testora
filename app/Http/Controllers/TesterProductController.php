<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TesterProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Auth::user()
            ->assignedProducts()
            ->withCount('feedback')
            ->withExists([
                'feedback as has_my_feedback' => function ($query) {
                    $query->where('user_id', Auth::id());
                }
            ])
            ->latest()
            ->get();

        return view('pages.tester.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Auth::user()
            ->assignedProducts()
            ->withCount('feedback')
            ->findOrFail($id);

        $myFeedback = $product->feedback()
            ->where('user_id', Auth::id())
            ->first();

        return view('pages.tester.products.show', compact(
            'product',
            'myFeedback'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
