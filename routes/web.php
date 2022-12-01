<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
});

Route::get('/login_with_google', [RegisteredUserController::class, 'redirectToProvider']);
Route::get('/googleCallBack', [RegisteredUserController::class, 'handlecallback']);
Route::post('/add-friend/{madeFriendId}/{madeByFriendId}', [RegisteredUserController::class, 'makefriend']);
Route::post('/accept-friend-request/{friendId}', [RegisteredUserController::class, 'acceptfriendrequest']);
Route::post('/refuse-friend-request/{friendId}', [RegisteredUserController::class, 'refusefriendrequest']);

Route::get('/post', [PostController::class, 'create'])->name('create-post');
Route::post('/store-post/{id}', [PostController::class, 'store']);
Route::post('/share-post/{userId}/{postId}', [PostController::class, 'sharePost']);
Route::post('/make-reply/{postId}/{userId}', [PostController::class, 'reply']);
Route::get('/like-unlike-post/{postId}/{userId}', [PostController::class, 'likeUnlike']);

Route::get('/dashboard', [PostController::class, 'home'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});



require __DIR__.'/auth.php';
