<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

//Auth::routes();
// Authentication Routes...
Route::get('f-login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('f-login', 'Auth\LoginController@login');
Route::post('f-logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
//Route::get('f-register', 'Auth\RegisterController@showRegistrationForm')->name('register');
//Route::post('f-register', 'Auth\RegisterController@register');

// Password Reset Routes...
/*Route::get('f-password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('f-password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('f-password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('f-password/reset', 'Auth\ResetPasswordController@reset');*/



Route::group(['middleware' => ['auth']], function () {

    Route::get('admin/home', 'HomeController@index')->name('home');

    Route::resource('users', 'UserController');
    Route::post('users/delete', 'UserController@destroy');

    Route::resource('gardens', 'GardenController');
    Route::post('gardens/delete', 'GardenController@destroy');
    Route::get('gardens/uploads/{id}', 'GardenController@uploads');
    Route::post('gardens/uploads/store', 'GardenController@imagesStore');
    Route::get('gardens/uploads/gardens-getServerImages/{id}', 'GardenController@getServerImages');
    Route::post('gardens/uploads/delete', 'GardenController@deleteUpload');
    

    Route::resource('contact', 'ContactController');

});
