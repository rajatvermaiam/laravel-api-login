<?php

use Illuminate\Http\Request;

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
Route::post('/register', 'Api\AuthController@create');
Route::get('email/verify/{id}', 'Api\AuthController@verify')->name('verificationapi.verify');
Route::get('email/resend', 'Api\AuthController@resend')->name('verificationapi.resend');
Route::post('/login', 'Api\AuthController@login');

Route::post('/password/reset', 'Api\AuthController@resetPassword');
Route::get('find/{token}', 'Api\AuthController@find');
Route::post('/reset', 'Api\AuthController@reset');




Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
