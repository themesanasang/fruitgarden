<?php


Route::get('/', function () {
    return redirect('home');
});
Route::get('/home', 'HomeController@index');


Route::get('/view/garden', 'ViewController@view_garden_all');
Route::get('/view/garden/{slug}', 'ViewController@view_garden_slug');
Route::get('/view/event', 'ViewController@view_event_all');
Route::get('/view/event/{slug}', 'ViewController@view_event_slug');
Route::get('/view/hotel', 'ViewController@view_hotel_all');
Route::get('/view/hotel/{slug}', 'ViewController@view_hotel_slug');
Route::get('/view/restaurants', 'ViewController@view_restaurants_all');
Route::get('/view/restaurants/{slug}', 'ViewController@view_restaurants_slug');
Route::get('/view/contact', 'ViewController@view_contact');



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
    Route::get('/reset_password', function () {
        return view('admin.users.reset_password');
    });
    Route::post('password/reset', 'UserController@reset_password');
    Route::post('users/delete', 'UserController@destroy');



    Route::resource('gardens', 'GardenController');
    Route::post('gardens/delete', 'GardenController@destroy');
    Route::get('gardens/uploads/{id}', 'GardenController@uploads');
    Route::post('gardens/uploads/store', 'GardenController@imagesStore');
    Route::get('gardens/uploads/gardens-getServerImages/{id}', 'GardenController@getServerImages');
    Route::post('gardens/uploads/delete', 'GardenController@deleteUpload');



    Route::get('calendars/full_calendar', 'CalendarController@full_calendar');
    Route::post('calendars/delete', 'CalendarController@destroy');
    Route::resource('calendars', 'CalendarController');



    Route::resource('events', 'EventController');
    Route::post('events/delete', 'EventController@destroy');
    Route::get('events/uploads/{id}', 'EventController@uploads');
    Route::post('events/uploads/store', 'EventController@imagesStore');
    Route::get('events/uploads/events-getServerImages/{id}', 'EventController@getServerImages');
    Route::post('events/uploads/delete', 'EventController@deleteUpload');



    Route::resource('hotels', 'HotelController');
    Route::post('hotels/delete', 'HotelController@destroy');
    Route::get('hotels/uploads/{id}', 'HotelController@uploads');
    Route::post('hotels/uploads/store', 'HotelController@imagesStore');
    Route::get('hotels/uploads/hotels-getServerImages/{id}', 'HotelController@getServerImages');
    Route::post('hotels/uploads/delete', 'HotelController@deleteUpload');



    Route::resource('restaurants', 'RsrController');
    Route::post('restaurants/delete', 'RsrController@destroy');
    Route::get('restaurants/uploads/{id}', 'RsrController@uploads');
    Route::post('restaurants/uploads/store', 'RsrController@imagesStore');
    Route::get('restaurants/uploads/restaurants-getServerImages/{id}', 'RsrController@getServerImages');
    Route::post('restaurants/uploads/delete', 'RsrController@deleteUpload');
    


    Route::resource('contact', 'ContactController');

});
