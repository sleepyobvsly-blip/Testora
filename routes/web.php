
<?php

use App\Http\Controllers\TesterProductController;
use App\Http\Controllers\PasswordChangeController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Feedback;
use App\Models\ProductAnalysis;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {

    $user = Auth::user();
    $userId = Auth::id();

    // TESTER DASHBOARD
    if ($user->hasRole('tester')) {

        // Get products assigned to the Tester
        $products = $user->assignedProducts()
            ->withCount('feedback')
            ->latest()
            ->get();

        // Get feedback submitted by the Tester
        $feedback = Feedback::where('user_id', $userId);

        $recentInsights = ProductAnalysis::whereHas('product', function ($query) use ($userId) {
            $query->whereHas('testers', function ($testerQuery) use ($userId) {
                $testerQuery->where('users.id', $userId);
            });
        })
            ->with('product')
            ->latest()
            ->take(3)
            ->get();

    }

    // ADMIN DASHBOARD
    elseif ($user->hasRole('admin')) {

        // Get products owned by the Admin
        $products = Product::where('user_id', $userId)
            ->withCount('feedback')
            ->latest()
            ->get();

        // Get feedback belonging to the Admin's products
        $feedback = Feedback::whereHas('product', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        });

        $recentInsights = ProductAnalysis::whereHas('product', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
            ->with('product')
            ->latest()
            ->take(3)
            ->get();

    } else {
        abort(403);
    }

    // Dashboard statistics
    $totalProducts = $products->count();

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
        'products',
        'totalProducts',
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

        // Product Management
        Route::resource('products', ProductController::class);


        // Product Publishing Payment
        Route::get('/products/{product}/payment', [ProductController::class, 'showPayment'])
            ->name('products.payment');

        Route::post('/products/{product}/payment/confirm', [ProductController::class, 'confirmPayment'])
            ->name('products.payment.confirm');

        // Product Testing Completion
        Route::patch('/products/{product}/complete', [ProductController::class, 'complete'])
            ->name('products.complete');

        Route::patch('/products/{product}/reopen', [ProductController::class, 'reopen'])
            ->name('products.reopen');


        // User Management
        Route::resource('users', UserManagementController::class)
            ->only(['index', 'create', 'store']);

        // AI Analysis
        Route::get('/analysis', [AnalysisController::class, 'index'])
            ->name('analysis.index');

        Route::post('/analysis/{product}', [AnalysisController::class, 'store'])
            ->name('analysis.store');

        // Manage Tester Product Assignments
        Route::get('/users/{user}/assignments', [UserManagementController::class, 'editAssignments'])
            ->name('users.assignments');

        Route::put('/users/{user}/assignments', [UserManagementController::class, 'updateAssignments'])
            ->name('users.assignments.update');

    });

    // Tester Product Routes
    Route::get('/my-products', [TesterProductController::class, 'index'])
        ->name('tester.products.index');

    Route::get('/my-products/{id}', [TesterProductController::class, 'show'])
        ->name('tester.products.show');

    // Feedback Responses
    Route::resource('feedback', FeedbackController::class);

    // Settings
    Route::get('/settings', function () {
        return view('pages.settings.index');
    })->name('settings.index');

});


require __DIR__.'/auth.php';
