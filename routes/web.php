<?php

use App\Http\Controllers\PublicTaskController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(function () {

Route::get('/', [TaskController::class, 'index'])->name('home');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});
Route::middleware('auth')->group(function () {
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');

    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

    Route::post('/tasks/{task}/share', [TaskController::class, 'share'])->name('tasks.share');

    Route::get('/public/task/{token}', [PublicTaskController::class, 'show'])->name('tasks.public');

});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
