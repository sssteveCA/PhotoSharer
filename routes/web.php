<?php

use App\Http\Controllers\admin\CommentAdminController;
use App\Http\Controllers\admin\PhotoAdminController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImageFetchController;
use App\Http\Controllers\PhotoController;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Interfaces\Constants as C;

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
Route::get('/photo_resource/{name}/{file}',ImageFetchController::class);

Route::middleware(['auth','verified'])->group(function(){
    Route::get('/dashboard',[DashboardController::class,'show'])->name('dashboard');
    Route::withoutMiddleware([VerifyCsrfToken::class])->group(function(){
        Route::apiResource('comments',CommentController::class)->only(['update','destroy']);
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

Route::get('/fallback', function(){
    if(session()->has('redirect') && session()->get('redirect') == '1'){
        session()->forget('redirect');
        return response()->view('fallback',[
            C::KEY_MESSAGE => "La risorsa richiesta non esiste oppure non disponi delle autorizzazioni necessarie"
        ],400);
    }
    else{
        return redirect('/');
    }
})->name('fallback');


Route::fallback(function(){
    session()->put('redirect','1');
    return redirect('/fallback');
});
