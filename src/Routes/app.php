<?php

    Route::group(['prefix' => 'store', 'namespace' => 'App', 'middleware' => ['web']], function () {
        Route::get('cart/contents', 'CartController@getContents');
        Route::get('cart/empty', 'CartController@emptyCart');
        Route::get('cart/count', 'CartController@cartCount');
        Route::get('cart/change-count', 'CartController@changeCartCount');
        Route::get('cart/add', 'CartController@addToCart');
        Route::get('cart/remove', 'CartController@removeFromCart');

        Route::group(['middleware' => ['quarx-analytics']], function () {
            Route::get('', 'StoreController@index');
            Route::get('products', 'ProductController@all');
            Route::get('product/{url}', 'ProductController@show');
            Route::get('plan/{id}', 'PlanController@show');
            Route::post('subscribe/{id}', 'SubscriptionController@subscribe');
            Route::group(['middleware' => 'auth'], function () {
                Route::group(['prefix' => 'account'], function () {
                    Route::get('settings', 'ProfileController@customerSettings');
                    Route::get('profile', 'ProfileController@customerProfile');
                    Route::post('profile/update', 'ProfileController@customerProfileUpdate');

                    Route::get('card', 'CardController@getCard');
                    Route::post('card', 'CardController@setCard');
                    Route::get('card-change', 'CardController@changeCard');
                    Route::post('card-change', 'CardController@setCard');

                    Route::get('purchases', 'PurchaseController@allPurchases');
                    Route::get('purchases/{id}', 'PurchaseController@getPurchase');
                    Route::get('purchases/{id}/refund-request', 'PurchaseController@requestRefund');
                    Route::get('orders', 'OrderController@allOrders');
                    Route::get('orders/{id}', 'OrderController@getOrder');
                    Route::get('orders/{id}/cancel', 'OrderController@cancelOrder');
                    Route::get('subscriptions', 'SubscriptionController@allSubscriptions');
                    Route::get('subscriptions/{id}', 'SubscriptionController@getSubscription');
                    Route::post('subscriptions/{name}/cancel', 'SubscriptionController@cancelSubscription');
                });
                Route::post('calculate/shipping', 'CheckoutController@reCalculateShipping');
                Route::get('checkout', 'CheckoutController@confirm');
                Route::get('payment', 'CheckoutController@payment');
                Route::post('process', 'CheckoutController@process');
                Route::post('process/last-card', 'CheckoutController@processWithLastCard');
                Route::get('complete', 'CheckoutController@complete');
                Route::get('failed', 'CheckoutController@failed');
            });
        });
    });
