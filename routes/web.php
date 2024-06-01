<?php

use App\Models\Posting;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\PostingController;
use App\Http\Controllers\NotificationController;

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

// Auth
Route::get('/register', [AuthController::class, 'register'])->name('registerPage');
Route::post('/register', [AuthController::class, 'store'])->name('register');
Route::get('/login', [AuthController::class, 'login'])->name('loginPage');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// isi Navbar

// Profile
Route::get('/MyProfile', [UserController::class, 'profile'])->name('MyProfile')->middleware('authentication');
Route::post('/MyProfile', [UserController::class, 'konfirmasiPassword'])->name('konfirmasiPassword');
Route::get('/detailProfile/{id}', [UserController::class, 'showProfile'])->name('detailProfile');
Route::get('/editProfile', [UserController::class, 'edit'])->name('editPage');
Route::post('/update-profile', [UserController::class, 'updateProfile'])->name('updateProfile');

// Beranda
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('halamanForyou');
    }
    $postings = Posting::all(); 
    $latestUsers = User::orderBy('created_at', 'desc')->take(3)->get(); 
    return view('dashboard.beranda.index', compact('postings', 'latestUsers')); 
})->name('halamanBeranda');

// Rute halaman beranda untuk pengguna yang sudah login
Route::middleware('auth')->group(function () {
    Route::get('/home', [BerandaController::class, 'foryou'])->name('halamanForyou');
    Route::get('/home2', [BerandaController::class, 'following'])->name('halamanFollowing');
});

// Explore
Route::get('/explorePeople', [SearchController::class, 'search'])->name('searchUsers');

// Notifikasi
Route::get('/myNotifikasi', [NotificationController::class, 'notif'])->name('notifikasi');

// Posting
Route::get('/formPost', [PostingController::class, 'addPostingan'])->name('tambahPostingan');
Route::post('/store', [PostingController::class, 'storePostingan'])->name('tambahPostinganStore');
Route::get('/seePost/{id}', [PostingController::class, 'showDetail'])->name('seePost');
Route::middleware('auth')->group(function () {
    Route::post('/post/{id}/like', [PostingController::class, 'like'])->name('postLike');
    Route::post('/post/{id}/comment', [PostingController::class, 'comment'])->name('postComment');
    Route::post('/comment/{id}/like', [PostingController::class, 'likeComment'])->name('likeComment');
    Route::post('/comment/{id}/hapus', [PostingController::class, 'hapus'])->name('hapusComment');
    Route::post('/comment/reply/{commentId}', [PostingController::class, 'reply'])->name('replyComment');
    Route::post('/reply/{id}/hapus', [PostingController::class, 'hapusReply'])->name('hapusReply');
    Route::get('/bookmarks', [PostingController::class, 'showBookmarks'])->name('showBookmarks'); 
    Route::post('/post/{id}/bookmark', [PostingController::class, 'bookmark'])->name('postBookmark');
});

// Follow
Route::post('/follow/{id}', [UserController::class, 'follow'])->name('followUser')->middleware('authentication');
Route::post('/unfollow/{id}', [UserController::class, 'unfollow'])->name('unfollowUser')->middleware('authentication');
