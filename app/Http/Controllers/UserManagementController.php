<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::role('tester')
            ->with('assignedProjects')
            ->latest()
            ->get();

        return view('pages.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('pages.users.create', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'project_ids' => 'required|array|min:1',
            'project_ids.*' => 'required|exists:projects,id',
        ]);

        // Verify that selected projects belong to this Admin
        $projects = Project::where('user_id', Auth::id())
            ->whereIn('id', $validated['project_ids'])
            ->get();

        if ($projects->count() !== count($validated['project_ids'])) {
            return back()
                ->withErrors(['project_ids' => 'One or more selected projects are invalid.'])
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

        // Assign the selected projects
        $tester->assignedProjects()->sync($projects->pluck('id'));

        // Return the temporary credentials to the Admin once
        return redirect()
            ->route('users.index')
            ->with('success', 'Tester account created successfully!')
            ->with('temporary_credentials', [
                'name' => $tester->name,
                'email' => $tester->email,
                'password' => $temporaryPassword,
            ]);
    }

    // Show the project assignment form for an existing Tester
public function editAssignments(User $user)
{
    // Only allow managing Tester accounts
    abort_unless($user->hasRole('tester'), 404);

    // Get projects owned by the logged-in Admin
    $projects = Project::where('user_id', Auth::id())
        ->latest()
        ->get();

    // Get the IDs of projects already assigned to this Tester
    $assignedProjectIds = $user->assignedProjects()
        ->pluck('projects.id')
        ->toArray();

    return view('pages.users.assignments', compact(
        'user',
        'projects',
        'assignedProjectIds'
    ));
}


// Save the Tester's project assignments
public function updateAssignments(Request $request, User $user)
{
    // Only allow managing Tester accounts
    abort_unless($user->hasRole('tester'), 404);

    $validated = $request->validate([
        'project_ids' => 'nullable|array',
        'project_ids.*' => 'required|exists:projects,id',
    ]);

    // Verify that all selected projects belong to this Admin
    $projects = Project::where('user_id', Auth::id())
        ->whereIn('id', $validated['project_ids'] ?? [])
        ->get();

    if ($projects->count() !== count($validated['project_ids'] ?? [])) {
        return back()
            ->withErrors(['project_ids' => 'One or more selected projects are invalid.'])
            ->withInput();
    }

    // Replace the Tester's project assignments
    $user->assignedProjects()->sync($projects->pluck('id'));

    return redirect()
        ->route('users.index')
        ->with('success', 'Tester project assignments updated successfully!');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
