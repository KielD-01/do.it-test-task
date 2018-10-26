<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('guest')->group(function () {
    Route::post('sign-in', 'Api\\UserController@signIn')->name('user.sign_in');
    Route::post('sign-up', 'Api\\UserController@signUp')->name('user.sign_up');
});

Route::middleware('auth:api')->group(function () {
    Route::post('github/emails/send', 'Api\\ServiceController@sendEmailsToGitHubUsers')->name('github.send.emails');
});
