<?php

    /*
    |--------------------------------------------------------------------------
    | Hadron Routes
    |--------------------------------------------------------------------------
    */

    Route::group(['namespace' => 'App\Http\Controllers\Hadron', 'middleware' => ['web']], function() {

        Route::group(['prefix' => 'store'], function() {
            Route::get('', 'StoreController@index');
            Route::get('products', 'ProductController@all');
            Route::get('product/{url}', 'ProductController@show');
            Route::get('cart/contents', 'CartController@getContents');
            Route::get('cart/empty', 'CartController@emptyCart');
            Route::group(['middleware' => 'isAjax'], function() {
                Route::get('cart/count', 'CartController@cartCount');
                Route::get('cart/change-count', 'CartController@changeCartCount');
                Route::get('cart/add', 'CartController@addToCart');
                Route::get('cart/remove', 'CartController@removeFromCart');
            });
            Route::group(['middleware' => 'auth'], function() {
                Route::group(['prefix' => 'account'], function() {
                    Route::get('profile', 'ProfileController@customerProfile');
                    Route::post('profile/update', 'ProfileController@customerProfileUpdate');
                    Route::get('purchases', 'PurchaseController@allPurchases');
                    Route::get('purchases/{id}', 'PurchaseController@getPurchase');
                    Route::get('orders', 'OrderController@allOrders');
                    Route::get('orders/{id}', 'OrderController@getOrder');
                    Route::get('orders/{id}/cancel', 'OrderController@cancelOrder');
                    Route::get('subscriptions', 'SubscriptionController@allSubscriptions');
                    Route::get('subscriptions/{id}', 'SubscriptionController@getSubscription');
                });
                Route::get('checkout', 'CheckoutController@confirm');
                Route::get('payment', 'CheckoutController@payment');
                Route::post('process', 'CheckoutController@process');
                Route::post('process/last-card', 'CheckoutController@processWithLastCard');
                Route::get('complete', 'CheckoutController@complete');
                Route::get('failed', 'CheckoutController@failed');
            });
        });

    });