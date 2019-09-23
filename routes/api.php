<?php

use Illuminate\Http\Request;

Route::group(['prefix' => 'authentication'], function() {

    Route::post('register', 'Api\Auth\AuthController@register');
    Route::post('login', 'Api\Auth\AuthController@login');
    Route::post('logout', 'Api\Auth\AuthController@logout');

});

Route::group(['prefix' => 'profile'], function() {

    Route::post('avatar', 'Api\Auth\ProfileController@update_avatar');
    Route::post('info', 'Api\Auth\ProfileController@update_profile');
    Route::post('email', 'Api\Auth\ProfileController@update_email');
    Route::post('password', 'Api\Auth\ProfileController@update_password');
    Route::post('credential', 'Api\Auth\ProfileController@identification');

});

Route::group(['prefix' => 'vehicle'], function() {

    Route::get('all', 'Api\Admin\VehicleController@all');
    Route::post('search', 'Api\Admin\VehicleController@search');
    Route::post('create', 'Api\Admin\VehicleController@create');
    Route::get('read/{id}', 'Api\Admin\VehicleController@read');
    Route::post('update', 'Api\Admin\VehicleController@update');
    Route::post('delete/{id}', 'Api\Admin\VehicleController@delete');

});

Route::group(['prefix' => 'users'], function() {

    Route::get('all', 'Api\Admin\UsersController@all');
    Route::get('/read/{id}', 'Api\Admin\UsersController@read');
    Route::post('/update', 'Api\Admin\UsersController@update_status');


});

Route::group(['prefix' => 'reservation'], function() {

    Route::get('search', 'Api\Admin\ReservationController@search');
    Route::post('vehicle/check', 'Api\Admin\ReservationController@vehicle_by_date');
    Route::post('near/date', 'Api\Admin\ReservationController@near_date_reservation');
    Route::get('all', 'Api\Admin\ReservationController@all');
    Route::post('create', 'Api\Admin\ReservationController@create');
    Route::get('read/{id}', 'Api\Admin\ReservationController@read');
    Route::post('update/status', 'Api\Admin\ReservationController@update_status_reservation');
    Route::get('vehicle/date/{id}/{key}', 'Api\Admin\ReservationController@get_vehicle_reservations');
    Route::post('update/date', 'Api\Admin\ReservationController@update_dates');
    Route::post('update/vehicle', 'Api\Admin\ReservationController@update_vehicle');
    Route::post('update/walkin', 'Api\Admin\ReservationController@update_walkin');

});

Route::group(['prefix' => 'repair'], function() {

    Route::get('all', 'Api\Admin\RepairController@all');
    Route::post('create', 'Api\Admin\RepairController@create');
    Route::post('/update', 'Api\Admin\RepairController@update_status');


});
