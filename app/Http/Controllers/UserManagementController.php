<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserManagementController extends Controller
{
    /**
     * Display a listing of tester accounts.
     */
    public function index()
    {
        $users = User::role('tester')
            ->with('assignedProducts')
            ->latest()
            ->get();

        return view('pages.users.index', compact('users'));
    }

    /**
     * Show the form for creating a tester account.
     */
    public function create()
    {
        $products = Product::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('pages.users.create', compact('products'));
    }

    /**
     * Create a tester account and assign products.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'product_ids' => 'required|array|min:1',
            'product_ids.*' => 'required|exists:products,id',
        ]);

        // Verify selected products belong to this Admin
        $products = Product::where('user_id', Auth::id())
            ->whereIn('id', $validated['product_ids'])
            ->get();

        if ($products->count() !== count($validated['product_ids'])) {
            return back()
                ->withErrors([
                    'product_ids' => 'One or more selected products are invalid.'
                ])
                ->withInput();
        }

        // Generate a temporary password
        $temporaryPassword = Str::password(16);

        // Create the Tester account
        $tester = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($temporaryPassword),
            'is_active' => true,
            'must_change_password' => true,
        ]);

        // Assign the Tester role
        $tester->assignRole('tester');

        // Assign selected products
        $tester->assignedProducts()->sync($products->pluck('id'));

        // Return temporary credentials to Admin
        return redirect()
            ->route('users.index')
            ->with('success', 'Tester account created successfully!')
            ->with('temporary_credentials', [
                'name' => $tester->name,
                'email' => $tester->email,
                'password' => $temporaryPassword,
            ]);
    }

    /**
     * Show product assignments for an existing Tester.
     */
    public function editAssignments(User $user)
    {
        // Only allow managing Tester accounts
        abort_unless($user->hasRole('tester'), 404);

        // Get products owned by the logged-in Admin
        $products = Product::where('user_id', Auth::id())
            ->latest()
            ->get();

        // Get products already assigned to this Tester
        $assignedProductIds = $user->assignedProducts()
            ->where('products.user_id', Auth::id())
            ->pluck('products.id')
            ->toArray();

        return view('pages.users.assignments', compact(
            'user',
            'products',
            'assignedProductIds'
        ));
    }

    /**
     * Update the Tester's product assignments.
     */
    public function updateAssignments(Request $request, User $user)
    {
        // Only allow managing Tester accounts
        abort_unless($user->hasRole('tester'), 404);

        $validated = $request->validate([
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'required|exists:products,id',
        ]);

        // Verify selected products belong to this Admin
        $products = Product::where('user_id', Auth::id())
            ->whereIn('id', $validated['product_ids'] ?? [])
            ->get();

        if ($products->count() !== count($validated['product_ids'] ?? [])) {
            return back()
                ->withErrors([
                    'product_ids' => 'One or more selected products are invalid.'
                ])
                ->withInput();
        }

        // Replace the Tester's product assignments
        $user->assignedProducts()->sync($products->pluck('id'));

        return redirect()
            ->route('users.index')
            ->with('success', 'Tester product assignments updated successfully!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
