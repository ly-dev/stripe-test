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

Route::group(['prefix' => 'stripe'], function () {
    Route::get('/', 'StripeController@index')->name('stripe.index');

    Route::get('/elements', 'StripeController@stripeElements')->name('stripe.elements');
    Route::get('/payment-request-button', 'StripeController@stripePaymentRequestButton')->name('stripe.payment-request-button');
    
    Route::get('/connect-account', 'StripeController@connectAccount')->name('stripe.connect.accouunt');
    Route::get('/connect-callback', 'StripeController@connectCallback')->name('stripe.connect.callback');
    Route::get('/payment-intent', 'StripeController@paymentIntent')->name('stripe.payment.intent');

});
