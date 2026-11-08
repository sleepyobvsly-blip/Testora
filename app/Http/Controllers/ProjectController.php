<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $projects = Project::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('pages.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Project::create([
            ...$validated,
            'user_id' => Auth::id(),
            'status' => 'draft',
        ]);

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
{
    abort_unless($project->user_id === Auth::id(), 403);

    return view('pages.projects.show', compact('project'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        abort_unless($project->user_id === Auth::id(), 403);

        return view('pages.projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
         abort_unless($project->user_id === Auth::id(), 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:draft,collecting,completed',
        ]);

        $project->update($validated);

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        abort_unless($project->user_id === Auth::id(), 403);

        $project->delete();

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project deleted successfully!');
    }
}
