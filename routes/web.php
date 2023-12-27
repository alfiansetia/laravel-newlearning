<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KeyController;
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


Auth::routes([
    'reset' => false,
    'verify' => false,
]);

Route::group(['middleware' => ['auth']], function () {
    Route::get('/courses-open/{course:slug}', [FrontendController::class, 'courseOpen'])->name('index.course.open');

    Route::group(['middleware' => ['is.user']], function () {

        Route::get('/list-chat/{chat}', [FrontendController::class, 'chatDetail'])->name('index.chat.detail');
        Route::post('/list-chat/{chat}', [FrontendController::class, 'saveChat'])->name('index.chat.save');
        Route::get('/list-chat', [FrontendController::class, 'chat'])->name('index.chat');
        Route::get('/profile', [FrontendController::class, 'profile'])->name('index.profile');
        Route::post('/profile', [FrontendController::class, 'profileUpdate'])->name('index.profile.update');
        Route::resource('cart', CartController::class)->only(['index', 'store', 'destroy']);

        Route::post('rate-course/{course}', [FrontendController::class, 'rate'])->name('index.save.review');
        Route::post('transaction-key/{course}', [FrontendController::class, 'withKey'])->name('index.save.transaction.key');
        Route::post('save-transaction/', [FrontendController::class, 'saveTransaction'])->name('index.save.transaction');
        Route::post('save-answer/{course}', [FrontendController::class, 'saveAnswer'])->name('index.save.answer');
        Route::post('save-progres/', [FrontendController::class, 'saveProgres'])->name('index.save.progres');
    });

    Route::group(['middleware' => ['is.admin']], function () {

        Route::get('/home', [HomeController::class, 'index'])->name('home');

        Route::get('/setting/profile', [SettingController::class, 'profile'])->name('setting.profile');
        Route::post('/setting/profile', [SettingController::class, 'profileUpdate'])->name('setting.profile.update');

        Route::resource('category', CategoryController::class);
        Route::resource('subcategory', SubCategoryController::class);
        Route::resource('course', CourseController::class);
        Route::resource('user', UserController::class);
        Route::resource('key', KeyController::class);
        Route::resource('transaction', TransactionController::class)->only(['index', 'show', 'destroy']);
        Route::resource('content', ContentController::class);
    });
});
