<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => ['web'], 'namespace' => 'Worker\Cashier\Controllers'], function () {
    // PayPal Subscription
    Route::get('/cashier/paypal-subscription/{subscription_id}/transaction-pending', 'PaypalSubscriptionController@transactionPending');
    Route::get('/cashier/paypal-subscription/{subscription_id}/change-plan/pending', 'PaypalSubscriptionController@ChangePlanpending');
    Route::get('/cashier/paypal-subscription/payment-redirect', 'PaypalSubscriptionController@paymentRedirect');
    Route::post('/cashier/paypal-subscription/{subscription_id}/cancel-now', 'PaypalSubscriptionController@cancelNow');
    Route::match(['get', 'post'], '/cashier/paypal-subscription/{subscription_id}/change-plan', 'PaypalSubscriptionController@changePlan');
    Route::match(['get', 'post'], '/cashier/paypal-subscription/{subscription_id}/renew', 'PaypalSubscriptionController@renew');
    Route::get('/cashier/paypal-subscription/{subscription_id}/pending', 'PaypalSubscriptionController@pending');
    Route::post('/cashier/paypal-subscription/{subscription_id}/checkout', 'PaypalSubscriptionController@checkout');
    Route::get('/cashier/paypal-subscription/{subscription_id}/checkout', 'PaypalSubscriptionController@checkout');

    // PayPal
    Route::match(['get', 'post'], '/cashier/paypal/{invoice_uid}/checkout', 'PaypalController@checkout');
    Route::match(['get', 'post'], '/cashier/paypal/connect', 'PaypalController@connect');

    // Braintree
    Route::match(['get', 'post'], '/cashier/braintree/{invoice_uid}/checkout', 'BraintreeController@checkout');
    Route::match(['get', 'post'], '/cashier/braintree/connect', 'BraintreeController@connect');
    
    // Coinpayments
    Route::match(['get', 'post'], '/cashier/coinpayments/{invoice_uid}/checkout', 'CoinpaymentsController@checkout');
    Route::match(['get', 'post'], '/cashier/coinpayments/connect', 'CoinpaymentsController@connect');
    
    // Direct
    Route::post('/cashier/direct/{invoice_uid}/claim', 'DirectController@claim');
    Route::get('/cashier/direct/{invoice_uid}/checkout', 'DirectController@checkout');
    Route::get('/cashier/direct/connect', 'DirectController@connect');
    
    // Stripe
    Route::match(['get', 'post'], '/cashier/stripe/{invoice_uid}/checkout', 'StripeController@checkout');
    Route::match(['get', 'post'], '/cashier/stripe/connect', 'StripeController@connect');
    
    // Razorpay
    Route::match(['get', 'post'], '/cashier/razorpay/{invoice_uid}/checkout', 'RazorpayController@checkout');
    Route::match(['get', 'post'], '/cashier/razorpay/connect', 'RazorpayController@connect');

    // Paystack
    Route::post('/cashier/paystack/{invoice_uid}/charge', 'PaystackController@charge');
    Route::match(['get', 'post'], '/cashier/paystack/{invoice_uid}/checkout', 'PaystackController@checkout');
    Route::match(['get', 'post'], '/cashier/paystack/connect', 'PaystackController@connect');
});