<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->isPed()) {
            return redirect()->route('ped.dashboard');
        } else {
            return redirect()->route('mtra.dashboard');
        }
    }
    return redirect()->route('login');
});

// Test route untuk debugging
Route::get('/test', [App\Http\Controllers\TestController::class, 'testProject']);

// Test route untuk mtra/7 tanpa auth
Route::get('/test-mtra/{id}', [App\Http\Controllers\MtraProjectController::class, 'show']);

// Test CSRF token route
Route::get('/test-csrf', function() {
    return response()->json([
        'csrf_token' => csrf_token(),
        'session_id' => session()->getId(),
        'message' => 'CSRF token is working'
    ]);
});

// Test POST route to verify CSRF protection
Route::post('/test-csrf-post', function() {
    return response()->json([
        'message' => 'CSRF token is working for POST requests',
        'session_id' => session()->getId()
    ]);
});

// Debug route untuk test approval
Route::get('/debug-approve/{id}', function($id) {
    $project = App\Models\MtraProject::find($id);
    if (!$project) return 'Project not found';
    
    $project->ped_approved = true;
    $project->ped_reviewed_at = now();
    $project->ped_notes = 'Test approval via debug route';
    $project->status = 'berjalan';
    $project->save();
    
    return 'Project ' . $id . ' approved via debug route. Status: ' . ($project->ped_approved ? 'true' : 'false');
});

// Debug route untuk check project ownership
Route::get('/debug-projects', function() {
    $projects = App\Models\MtraProject::with('user')->get();
    $output = '<h2>Project Ownership Check</h2>';
    
    if (auth()->check()) {
        $user = auth()->user();
        $output .= '<p>Current user: ' . $user->name . ' (ID: ' . $user->id . ')</p>';
    } else {
        $output .= '<p>Current user: Not logged in</p>';
    }
    
    $output .= '<table border="1" style="border-collapse: collapse; width: 100%;">';
    $output .= '<tr><th>ID</th><th>Nomor Kontrak</th><th>User ID</th><th>User Name</th><th>PED Approved</th><th>Status</th></tr>';
    
    foreach ($projects as $project) {
        $output .= '<tr>';
        $output .= '<td>' . $project->id . '</td>';
        $output .= '<td>' . $project->nomor_kontrak . '</td>';
        $output .= '<td>' . ($project->user_id ?? 'NULL') . '</td>';
        $output .= '<td>' . ($project->user ? $project->user->name : 'NULL') . '</td>';
        $output .= '<td>' . ($project->ped_approved ? 'true' : 'false') . '</td>';
        $output .= '<td>' . $project->status . '</td>';
        $output .= '</tr>';
    }
    $output .= '</table>';
    
    // Fix orphaned projects (projects without user_id)
    if (auth()->check()) {
        $orphanedProjects = App\Models\MtraProject::whereNull('user_id')->get();
        if ($orphanedProjects->count() > 0) {
            $output .= '<h3>Fixing orphaned projects...</h3>';
            foreach ($orphanedProjects as $project) {
                $project->user_id = auth()->id();
                $project->save();
                $output .= '<p>Fixed project ' . $project->id . ' - assigned to user ' . auth()->id() . '</p>';
            }
        }
    }
    
    return $output;
});

// Simple debug route
Route::get('/debug-simple', function() {
    $user = auth()->user();
    $projects = App\Models\MtraProject::all();
    
    $output = '<h2>Simple Debug Info</h2>';
    
    if ($user) {
        $output .= '<p><strong>Current User:</strong> ' . $user->name . ' (ID: ' . $user->id . ', Role: ' . $user->role . ')</p>';
    } else {
        $output .= '<p><strong>Current User:</strong> Not logged in</p>';
    }
    
    $output .= '<p><strong>Total Projects:</strong> ' . $projects->count() . '</p>';
    
    $output .= '<h3>Projects:</h3>';
    foreach ($projects as $project) {
        $output .= '<p>ID: ' . $project->id . ' | Contract: ' . $project->nomor_kontrak . ' | User ID: ' . ($project->user_id ?? 'NULL') . ' | PED Approved: ' . ($project->ped_approved ? 'Yes' : 'No') . '</p>';
    }
    
    return $output;
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// MTRA Routes
Route::get('/mtra/dashboard', [App\Http\Controllers\QeDashboardController::class, 'index'])->middleware(['auth'])->name('mtra.dashboard');
Route::resource('mtra', App\Http\Controllers\MtraProjectController::class)->middleware(['auth'])->except(['edit', 'update']);
Route::delete('/mtra/photo/{photoId}', [App\Http\Controllers\MtraProjectController::class, 'deletePhoto'])->middleware(['auth'])->name('mtra.photo.delete');

// PED Routes
Route::prefix('ped')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\PedController::class, 'dashboard'])->name('ped.dashboard');
    Route::get('/', [App\Http\Controllers\PedController::class, 'index'])->name('ped.index');
    Route::get('/notifications', [App\Http\Controllers\PedController::class, 'notifications'])->name('ped.notifications');
    Route::get('/{project}', [App\Http\Controllers\PedController::class, 'show'])->name('ped.show');
    Route::post('/{project}/approve', [App\Http\Controllers\PedController::class, 'approve'])->name('ped.approve');
    Route::post('/{project}/reject', [App\Http\Controllers\PedController::class, 'reject'])->name('ped.reject');
});

// PED Approval Routes (Alternative)
Route::post('/ped-approve/{project}', [App\Http\Controllers\PedController::class, 'approve'])->middleware(['auth'])->name('ped.approve.alt');
Route::post('/ped-reject/{project}', [App\Http\Controllers\PedController::class, 'reject'])->middleware(['auth'])->name('ped.reject.alt');

require __DIR__.'/auth.php';
