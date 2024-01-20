<?php
use Illuminate\Http\Request;

//Auth routes
Route::get('masterbox',[App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('masterbox',[App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
Route::prefix('masterbox/password')->group(function(){
    Route::get('confirm',[App\Http\Controllers\Auth\ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
    Route::post('confirm',[App\Http\Controllers\Auth\ConfirmPasswordController::class, 'confirm']);
    Route::post('email',[App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('reset',[App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('reset',[App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');
    Route::post('reset/{token}',[App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');

});

// GET|HEAD   register ......................................... register › Auth\RegisterController@showRegistrationForm
// POST       register ................................................................ Auth\RegisterController@register
// GET|HEAD   sanctum/csrf-cookie .......................................... Laravel\Sanctum › CsrfCookieController@show

Route::get('/auth/logout',function(Request $request){
    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/');
});
