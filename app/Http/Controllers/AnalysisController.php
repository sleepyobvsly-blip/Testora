<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectAnalysis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AnalysisController extends Controller
{
    
   
    
    public function index(Request $request)
    {
        // Retrieve the user's projects
        $projects = Project::where('user_id', Auth::id())
            ->withCount('feedback')
            ->latest()
            ->get();

        // Find the selected project, if provided
        $selectedProject = null;

        if ($request->filled('project_id')) {
            $selectedProject = Project::where('user_id', Auth::id())
                ->findOrFail($request->project_id);
        }

        // If no project was selected, use the latest analyzed project
        if (!$selectedProject) {
            $latestAnalysis = ProjectAnalysis::whereHas('project', function ($query) {
                $query->where('user_id', Auth::id());
            })
                ->latest()
                ->first();

            $selectedProject = $latestAnalysis?->project;
        }

        // If there is still no selected project, use the first available project
        if (!$selectedProject) {
            $selectedProject = $projects->first();
        }

        // Retrieve the latest analysis for the selected project
        $latestAnalysis = $selectedProject
            ? $selectedProject->analyses()->latest()->first()
            : null;

        // Get sentiment counts
        $sentimentCounts = collect([
            'positive' => 0,
            'neutral' => 0,
            'negative' => 0,
        ]);

        if ($selectedProject) {
            $counts = $selectedProject->feedback()
                ->selectRaw('sentiment, COUNT(*) as total')
                ->whereNotNull('sentiment')
                ->groupBy('sentiment')
                ->pluck('total', 'sentiment');

            $sentimentCounts = collect([
                'positive' => $counts->get('positive', 0),
                'neutral' => $counts->get('neutral', 0),
                'negative' => $counts->get('negative', 0),
            ]);
        }

        // Calculate analyzed feedback and percentages
        $totalAnalyzed = $sentimentCounts->sum();

        $sentimentPercentages = collect([
            'positive' => $totalAnalyzed > 0
                ? round(($sentimentCounts['positive'] / $totalAnalyzed) * 100)
                : 0,

            'neutral' => $totalAnalyzed > 0
                ? round(($sentimentCounts['neutral'] / $totalAnalyzed) * 100)
                : 0,

            'negative' => $totalAnalyzed > 0
                ? round(($sentimentCounts['negative'] / $totalAnalyzed) * 100)
                : 0,
        ]);

        return view('pages.analysis.index', compact(
            'projects',
            'selectedProject',
            'latestAnalysis',
            'sentimentCounts',
            'sentimentPercentages',
            'totalAnalyzed'
        ));
    }




    public function store(Request $request, Project $project)
    {
        // Verify project ownership
        abort_unless($project->user_id === Auth::id(), 403);

        // Retrieve feedback for this project
        $feedback = $project->feedback()
            ->whereNotNull('sentiment')
            ->get();

        if ($feedback->count() < 2) {
            return redirect()
                ->route('analysis.index')
                ->with('error', 'At least two analyzed feedback responses are needed.');
        }

        // Send feedback to the Python summarization API
        try {
            $response = Http::timeout(180)->post(
                'http://127.0.0.1:8001/summarize',
                [
                    'feedback' => $feedback->pluck('feedback_text')->all(),
                ]
            );

            if (!$response->successful()) {
                return redirect()
                    ->route('analysis.index')
                    ->with('error', 'The AI service could not generate a summary.');
            }

            $summary = $response->json('summary');

            if (!$summary) {
                return redirect()
                    ->route('analysis.index')
                    ->with('error', 'The AI service returned an empty summary.');
            }

            // Save the generated analysis
           $analysis = ProjectAnalysis::create([
                'project_id' => $project->id,
                'total_feedback' => $feedback->count(),
                'summary' => $summary,
            ]);

            return redirect()
                ->route('analysis.index')
                ->with('success', 'AI analysis completed successfully!')
                ->with('analysis_id', $analysis->id);

        } catch (\Illuminate\Http\Client\ConnectionException $e) {

            report($e);

            return redirect()
                ->route('analysis.index')
                ->with('error', 'Cannot connect to the Python AI service. Make sure it is running.');
        }
    }
}