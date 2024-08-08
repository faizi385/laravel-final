<?php

use App\Exports\AllPostsExport;
use App\Exports\UserPostsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ReservationController;

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

// Welcome page (Public)
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Dashboard (Authenticated and Verified Users)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes (Authenticated)
Route::middleware('auth')->group(function () {
    // Resource routes for posts
    Route::resource('posts', PostController::class);
    
    // Additional Post Routes
    Route::post('posts/{post}/like', [PostController::class, 'like'])->name('posts.like');
    Route::post('posts/{post}/unlike', [PostController::class, 'unlike'])->name('posts.unlike');
    Route::post('posts/{post}/comments', [PostController::class, 'storeComment'])->name('posts.comments.store');
    Route::post('/posts/import', [PostController::class, 'import'])->name('posts.import');
    Route::get('/feed', [PostController::class, 'feed'])->name('posts.feed');
    Route::get('/my-posts', [PostController::class, 'myPosts'])->name('posts.myPosts');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Export posts route for authenticated users
    Route::get('/export-posts', function () {
        return Excel::download(new UserPostsExport, 'my_posts.xlsx');
    })->name('posts.export');

    // Routes for Superadmins (Admin Role)
    Route::middleware(['role:superadmin'])->group(function () {
        Route::post('posts/{post}/approve', [PostController::class, 'approve'])->name('posts.approve');
        Route::post('posts/{post}/unapprove', [PostController::class, 'unapprove'])->name('posts.unapprove');
        Route::post('posts/{post}/activate', [PostController::class, 'activate'])->name('posts.activate');
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('admin/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('admin/users/data', [UserController::class, 'getUsersData'])->name('admin.users.data');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::resource('users', UserController::class);

        // Export all posts route for superadmins
        Route::get('/export-all-posts', function () {
            return Excel::download(new AllPostsExport, 'all_posts.xlsx');
        })->name('posts.export.all');
    });
});

// Reservation API Route
Route::post('/api/reservations', [ReservationController::class, 'store'])->name('reservations.store');

require __DIR__.'/api.php';
require __DIR__.'/auth.php';

