<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', [FrontendController::class, 'index'])->name('index');
Route::get('/courses', [FrontendController::class, 'courseList'])->name('index.course.list');
Route::get('/courses/{course:slug}', [FrontendController::class, 'courseDetail'])->name('index.course.detail');

Route::get('/cat/{category:slug}', [FrontendController::class, 'category'])->name('index.category');

Route::get('profile', [FrontendController::class, 'profile']);

Auth::routes([
    'reset' => false,
    'verify' => false,
]);

Route::group(['middleware' => ['auth']], function () {
    Route::resource('cart', CartController::class)->only(['index', 'store', 'destroy']);

    Route::resource('transaction', TransactionController::class)->only(['index', 'store']);

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/setting/profile', [SettingController::class, 'profile'])->name('setting.profile');
    Route::post('/setting/profile', [SettingController::class, 'profileUpdate'])->name('setting.profile.update');

    Route::resource('category', CategoryController::class);
    Route::resource('subcategory', SubCategoryController::class);
    Route::resource('course', CourseController::class);
    Route::resource('user', UserController::class);
});
