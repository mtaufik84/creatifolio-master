<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\ProjectToolController;
use App\Http\Controllers\ProjectScreenshotController;

Route::get('/', [FrontController::class, 'index'])->name('front.index');
Route::get('/details', [FrontController::class, 'details'])->name('front.details');
Route::get('/book', [FrontController::class, 'book'])->name('front.book');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/admin/projects', [ProjectController::class, 'index'])->name('admin.projects.index');
    Route::get('/admin/tools', [ToolController::class, 'index'])->name('admin.tools.index');

    // Group route untuk admin
    Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('projects', ProjectController::class);
        Route::resource('tools', ToolController::class);
        Route::resource('project_tools', ProjectToolController::class);

        // Memastikan parameter project dikirimkan ke route

        Route::get('/projects/{project}/assign-tool', [ProjectToolController::class, 'create'])
        ->name('project.assign.tool');
        Route::post('/tools/assign/save/{project}', [ProjectToolController::class, 'store'])
        ->name('project.assign.tool.store');

        Route::get("/tools/assign/{project}", [ProjectToolController::class, "create"])
            ->name('admin.project.assign.tool');
        
        Route::post("/tools/assign/save/{project}", [ProjectToolController::class, "store"])
            ->name('admin.project.assign.tool.store');
            
        Route::resource('project_screenshots', ProjectScreenshotController::class);
        Route::get("/screenshot/{project}", [ProjectScreenshotController::class, "create"])
            ->name('admin.project_screenshots.create');
        Route::post("/screenshots/save/{project}", [ProjectScreenshotController::class, "store"])
            ->name('admin.project_screenshots.store');
    });
});

require __DIR__.'/auth.php';