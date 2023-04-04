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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'shop', 'as' => 'product.'], function() {
    Route::get('index', 'ProductController@index')->name('index');
    Route::get('c/{taxonomyName}/{taxon}', 'ProductController@index')->name('category');
    Route::get('p/{slug}', 'ProductController@show')->name('show');
});

Route::group(['prefix' => 'cart', 'as' => 'cart.'], function() {
    Route::get('show', 'CartController@show')->name('show');
    Route::post('add/{product}', 'CartController@add')->name('add');
    Route::post('adv/{masterProductVariant}', 'CartController@addVariant')->name('add-variant');
    Route::post('update/{cart_item}', 'CartController@update')->name('update');
    Route::post('remove/{cart_item}', 'CartController@remove')->name('remove');
});

Route::group(['prefix' => 'checkout', 'as' => 'checkout.'], function() {
    Route::get('show', 'CheckoutController@show')->name('show');
    Route::post('submit', 'CheckoutController@submit')->name('submit');
});

Route::group(['prefix' => 'payment/eup', 'as' => 'payment.euplatesc.return.'], function() {
    Route::post('frontend', 'EuplatescReturnController@frontend')->name('frontend');
    Route::post('silent', 'EuplatescReturnController@silent')->name('silent');
});

Route::group(['prefix' => 'payment/netopia', 'as' => 'payment.netopia.'], function() {
    Route::post('confirm', 'NetopiaReturnController@confirm')->name('confirm');
    Route::get('return', 'NetopiaReturnController@return')->name('return');
});

Route::group(['prefix' => 'payment/paypal', 'as' => 'payment.paypal.'], function() {
    Route::get('return', 'PaypalReturnController@return')->name('return');
    Route::get('cancel', 'PaypalReturnController@cancel')->name('cancel');
    Route::any('webhook', 'PaypalReturnController@webhook')->name('webhook');
});

Route::group(['prefix' => 'payment/simplepay', 'as' => 'payment.simplepay.'], function() {
    Route::get('return', 'SimplepayReturnController@return')->name('return');
    Route::post('silent', 'SimplepayReturnController@silent')->name('silent');
});

Route::group(['prefix' => 'payment/mollie', 'as' => 'payment.mollie.'], function() {
    Route::get('{paymentId}/return', 'MollieController@return')->name('return');
    Route::post('webhook', 'MollieController@webhook')->name('webhook');
});

Route::group(['prefix' => 'payment/adyen', 'as' => 'payment.adyen.'], function() {
    Route::post('{paymentId}/submit', 'AdyenController@submit')->name('submit');
    Route::post('webhook', 'AdyenController@webhook')->name('webhook');
});

Route::group(['prefix' => 'payment/braintree', 'as' => 'payment.braintree.'], function() {
    Route::post('{paymentId}/submit', 'BraintreeController@submit')->name('submit');
});

Route::group(['prefix' => 'payment/stripe', 'as' => 'payment.stripe.'], function() {
    Route::post('webhook', 'StripeReturnController@webhook');
});
