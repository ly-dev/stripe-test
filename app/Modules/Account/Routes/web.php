<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your module. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
 */

Route::group(['prefix' => 'account'], function () {
    Route::get('/change-password', 'PersonalAccountController@changePasswordForm')->name('account.change-password');
    Route::post('/change-password', 'PersonalAccountController@changePasswordProcess');
});

Route::group(['prefix' => 'manage-account'], function () {
    Route::get('/', 'ManageAccountController@index')->name('manage-account.index');
    Route::get('/grid', 'ManageAccountController@grid')->name('manage-account.grid');
    Route::get('/view/{id?}', 'ManageAccountController@view')->name('manage-account.view');
    Route::post('/view/{id?}', 'ManageAccountController@process');
    Route::delete('/delete/{id}', 'ManageAccountController@delete')->name('manage-account.delete');
});
