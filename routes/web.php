<?php


use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\IdeaLikeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;


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
// 

Route::get('lang/{lang}', function ($lang) {
    app()->setLocale($lang);
    session()->put('locale', $lang);
    
    return redirect()->route('dashboard');
})->name('lang');


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('', [DashboardController::class, 'index'])->name('dashboard-home');

Route::resource('ideas', IdeaController::class)->except(['index', 'create', 'show'])->middleware('auth');
Route::resource('ideas', IdeaController::class)->only(['show']);

Route::resource('ideas.comments', CommentController::class)->only(['store'])->middleware('auth');

Route::resource('users', UserController::class)->only('show');
Route::resource('users', UserController::class)->only('update', 'edit')->middleware('auth');

Route::get('profile', [UserController::class, 'profile'])->middleware('auth')->name('profile');

Route::post('users/{user}/follow', [FollowerController::class, 'follow'])->middleware('auth')->name('users.follow');
Route::post('users/{user}/unfollow', [FollowerController::class, 'unfollow'])->middleware('auth')->name('users.unfollow');

Route::post('ideas/{idea}/like', [IdeaLikeController::class, 'like'])->middleware('auth')->name('ideas.like');
Route::post('ideas/{idea}/unlike', [IdeaLikeController::class, 'unlike'])->middleware('auth')->name('ideas.unlike');

Route::get('/feed', FeedController::class)->name('feed')->middleware('auth')->name('feed');

Route::get('/terms', function () {
    return view('terms');
});

Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin.dashboard')->middleware(['auth','can:admin , idea.edit , idea.delete']);

Route::get('/redis-test', function () {
    try {
        Redis::set('test', 'Hello Redis!');
        $value = Redis::get('test');
        return "Redis Test: " . $value;
    } catch (\Exception $e) {
        return "Redis Error: " . $e->getMessage();
    }
});


