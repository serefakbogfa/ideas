<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/ideas{idea}', [IdeaController::class, 'show'])->name('ideas.show');

Route::get('/ideas{idea}/edit', [IdeaController::class, 'edit'])->name('ideas.edit');

Route::put('/ideas{idea}', [IdeaController::class, 'update'])->name('ideas.update');



Route::post('/idea', [IdeaController::class, 'store'])->name('idea.store');


Route::delete('/ideas/{idea}', [IdeaController::class, 'destroy'])->name('ideas.destroy');

Route::post('/idea/{idea}/comments', [CommentController::class, 'store'])->name('idea.comments.store');



Route::get('/terms', function () {
    return view('ideas.show');
});
