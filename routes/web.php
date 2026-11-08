<?php

use App\Http\Controllers\TesterProjectController;
use App\Http\Controllers\PasswordChangeController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\Feedback;
use App\Models\ProjectAnalysis;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {

    $user = Auth::user();
    $userId = Auth::id();

    // TESTER DASHBOARD
    if ($user->hasRole('tester')) {

        // Get projects assigned to the Tester
        $projects = $user->assignedProjects()
            ->withCount('feedback')
            ->latest()
            ->get();

        // Get feedback submitted by the Tester
        $feedback = Feedback::where('user_id', $userId);

        $recentInsights = ProjectAnalysis::whereHas('project', function ($query) use ($userId) {
    $query->whereHas('testers', function ($testerQuery) use ($userId) {
        $testerQuery->where('users.id', $userId);
            });
        })
            ->with('project')
            ->latest()
            ->take(3)
            ->get();

    }

    // ADMIN DASHBOARD
    elseif ($user->hasRole('admin')) {

        // Get projects owned by the Admin
        $projects = Project::where('user_id', $userId)
            ->withCount('feedback')
            ->latest()
            ->get();

        // Get feedback belonging to the Admin's projects
        $feedback = Feedback::whereHas('project', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        });

        $recentInsights = ProjectAnalysis::whereHas('project', function ($query) use ($userId) {
    $query->where('user_id', $userId);
        })
            ->with('project')
            ->latest()
            ->take(3)
            ->get();

    } else {
        abort(403);
    }

    // Dashboard statistics
    $totalProjects = $projects->count();

    $totalFeedback = (clone $feedback)->count();

    $analyzedFeedback = (clone $feedback)
        ->whereNotNull('sentiment')
        ->count();

    // Sentiment breakdown
    $sentimentCounts = (clone $feedback)
        ->selectRaw('sentiment, COUNT(*) as total')
        ->whereNotNull('sentiment')
        ->groupBy('sentiment')
        ->pluck('total', 'sentiment');

    return view('dashboard', compact(
        'projects',
        'totalProjects',
        'totalFeedback',
        'analyzedFeedback',
        'sentimentCounts',
        'recentInsights'
    ));

})->middleware(['auth', 'password.changed'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // Forced password change
    Route::get('/force-change-password', [PasswordChangeController::class, 'edit'])
        ->name('password.force-change');

    Route::post('/force-change-password', [PasswordChangeController::class, 'update'])
        ->name('password.force-update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'password.changed'])->group(function () {

    // Admin-only routes
    Route::middleware('role:admin')->group(function () {

        // Project Management
        Route::resource('projects', ProjectController::class);

        // User Management
        Route::resource('users', UserManagementController::class)
            ->only(['index', 'create', 'store']);

        // AI Analysis
        Route::get('/analysis', [AnalysisController::class, 'index'])
            ->name('analysis.index');

        Route::post('/analysis/{project}', [AnalysisController::class, 'store'])
            ->name('analysis.store');

            // Manage Tester Project Assignments
        Route::get('/users/{user}/assignments', [UserManagementController::class, 'editAssignments'])
            ->name('users.assignments');

        Route::put('/users/{user}/assignments', [UserManagementController::class, 'updateAssignments'])
            ->name('users.assignments.update');
            
    });

    // Tester Project Routes
    Route::get('/my-projects', [TesterProjectController::class, 'index'])
        ->name('tester.projects.index');

    Route::get('/my-projects/{id}', [TesterProjectController::class, 'show'])
        ->name('tester.projects.show');

    // Feedback Responses
    Route::resource('feedback', FeedbackController::class);

    // Settings
    Route::get('/settings', function () {
        return view('pages.settings.index');
    })->name('settings.index');

});



require __DIR__.'/auth.php';
