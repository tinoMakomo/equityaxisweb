<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\Admin\AdController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserTypeController;
use App\Http\Controllers\Admin\SubscriberController;

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

Route::get('terms-and-conditions', [FrontController::class, 'terms'])->name('terms');
Route::get('privacy-policy', [FrontController::class, 'privacy'])->name('privacy');
Route::get('cookies-policy', [FrontController::class, 'cookies'])->name('cookies');
Route::get('disclaimer', [FrontController::class, 'disclaimer'])->name('disclaimer');
Route::get('contact', [FrontController::class, 'contact'])->name('contact');
Route::post('contact', [FrontController::class, 'contactSubmit'])->name('contact');
Route::get('contact/success', [FrontController::class, 'contactSuccess'])->name('contact.success');

Route::get('/services', [FrontController::class, 'services'])->name('services');
Route::get('/about-us', [FrontController::class, 'aboutUs'])->name('about-us');
Route::get('/careers', [FrontController::class, 'careers'])->name('careers');
Route::get('/help-centre', [FrontController::class, 'helpCentre'])->name('help-centre');

Route::get('/login', [AdminController::class, 'login'])->name('login');
Route::post('/login', [AdminController::class, 'authenticate'])->name('login');

Route::get('/', [FrontController::class, 'index'])->name('index');
Route::get('/category/{id}/{category?}', [FrontController::class, 'category'])->name('category');
Route::get('/author/{id}/{author?}', [FrontController::class, 'author'])->name('author');
Route::get('/tag/{tag}', [FrontController::class, 'tag'])->name('tag');
Route::any('/subscribe', [FrontController::class, 'subscribe'])->name('subscribe');
Route::post('/subscribe/add', [FrontController::class, 'subscribeAdd'])->name('subscribe.add');
Route::get('/subscribe/success', [FrontController::class, 'subscribeSuccess'])->name('subscribe.success');
Route::get('/unsubscribe/{email}', [FrontController::class, 'unsubscribe'])->name('unsubscribe');
Route::get('/search', [FrontController::class, 'search'])->name('search');
Route::get('/post/{id}/{year?}/{month?}/{slug?}', [FrontController::class, 'post'])->name('post');
Route::get('/p/{id}', [FrontController::class, 'post'])->name('short');

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/logout', [AdminController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin_dashboard');
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin_profile');
    Route::post('/profile/update', [AdminController::class, 'updateProfile'])->name('admin_profile.update');

    Route::get('/preferences', [AdminController::class, 'preferences'])->name('admin_preferences');
    Route::post('/preferences/update', [AdminController::class, 'updatePreferences'])->name('admin_preferences.update');

    Route::get('/change/password', [AdminController::class, 'changePassword'])->name('admin.change_password');
    Route::get('/user/change/password/{id}', [UserController::class, 'changeUserPassword'])->name('admin.change_user_password');
    Route::post('/update/password', [AdminController::class, 'updatePassword'])->name('admin.update_password');
    Route::post('/user/update/password/{id}', [UserController::class, 'updateUserPassword'])->name('admin.update_user_password');

    Route::resources([
        'admin_posts' => PostController::class,
    ]);

    Route::get('/admin_posts/trash/index', [PostController::class, 'trash'])->name('admin_posts.trash.index');
    Route::post('/admin_posts/restore/{id}', [PostController::class, 'restore'])->name('admin_posts.restore');
    Route::post('/admin_posts/force_delete/{id}', [PostController::class, 'forceDelete'])->name('admin_posts.force_delete');



    Route::middleware(['isEditorOrAdmin'])->group(function () {
        Route::resources([
            'admin_categories' => CategoryController::class,
        ]);
    });

    Route::middleware(['isAdmin'])->group(function () {
        Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
        Route::resources([
            'admin_users' => UserController::class,
            'admin_subscribers' => SubscriberController::class,
            'admin_user_types' => UserTypeController::class,
            'admin_ads' => AdController::class,
        ]);
    });
});


