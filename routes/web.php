<?php

use App\Http\Controllers\admin\CommentAdminController;
use App\Http\Controllers\admin\PhotoAdminController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PhotoController;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
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

Route::get('/', [PhotoController::class,'index']);

Route::resource('photos', PhotoController::class)->except([
    'index'
]);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth','verified'])->group(function(){
    Route::get('/dashboard',[DashboardController::class,'show']);
    Route::withoutMiddleware([VerifyCsrfToken::class])->group(function(){
        Route::apiResource('comments',CommentController::class)->only(['update','destroy'])->middleware('comment.ownership');
        Route::group(['prefix' => 'admin', 'middleware' => ['admin.check']],function(){
            Route::apiResource('comments',CommentAdminController::class)->only(['update','destroy']);
            Route::apiResource('photos',PhotoAdminController::class)->only(['update','destroy']);
        });
    });
    
});

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::permanentRedirect('/home','/');
