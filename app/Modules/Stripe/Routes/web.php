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
    Route::get('/', 'StripeTestController@index')->name('stripe.index');

    Route::get('/elements', 'StripeTestController@stripeElements')->name('stripe.elements');
    Route::get('/3d-secure-2', 'StripeTestController@stripe3DSecure2')->name('stripe.3d-secure-2');

    Route::get('/success', 'StripeController@success')->name('stripe.success');
    Route::get('/cancel', 'StripeController@cancel')->name('stripe.cancel');

    Route::get('/connect-account', 'StripeController@connectAccount')->name('stripe.connect.accouunt');
    Route::get('/connect-callback', 'StripeController@connectCallback')->name('stripe.connect.callback');

    Route::get('/payment-intent', 'StripeController@paymentIntent')->name('stripe.payment.intent');

});
