<?php

    /*
    |--------------------------------------------------------------------------
    | Commerce Routes
    |--------------------------------------------------------------------------
    */

    Route::group(['namespace' => 'Commerce', 'middleware' => ['web']], function () {

        Route::get('', 'StoreController@index')->name('commerce.home');

        Route::group(['prefix' => config('commerce.store_url_prefix'), 'as' => 'commerce'], function () {
            Route::get('cart/contents', 'CartController@getContents')->name('.cart.contents');
            Route::get('cart/empty', 'CartController@emptyCart')->name('.cart.empty');
            Route::group(['middleware' => ['isAjax']], function () {
                Route::get('cart', 'CartController@cart')->name('.cart');
                Route::get('cart/count', 'CartController@cartCount')->name('.cart.count');
                Route::get('cart/change-count', 'CartController@changeCartCount')->name('.cart.change-count');
                Route::get('cart/add', 'CartController@addToCart')->name('.cart.add');
                Route::get('cart/remove', 'CartController@removeFromCart')->name('.cart.remove');
            });

            Route::group(['middleware' => ['cms-analytics']], function () {
                Route::get('', 'StoreController@index')->name('.home');
                Route::get('products', 'ProductController@all')->name('.products');
                Route::get('product/{url}', 'ProductController@show')->name('.product');
                Route::get('plans', 'PlanController@all')->name('.plans');
                Route::get('plan/{name}', 'PlanController@show')->name('.plan');
                Route::post('subscribe/{id}', 'SubscriptionController@subscribe')->name('.subscribe');
                Route::group(['middleware' => 'auth'], function () {
                    Route::group(['prefix' => 'account'], function () {
                        Route::get('settings', 'ProfileController@customerSettings')->name('.account.settings');
                        Route::get('profile', 'ProfileController@customerProfile')->name('.account.profile');
                        Route::get('coupon', 'ProfileController@addCoupon')->name('.account.profile.coupon');
                        Route::post('coupon', 'ProfileController@submitCoupon')->name('.account.profile.coupon');
                        Route::post('profile/update', 'ProfileController@customerProfileUpdate')->name('.account.profile.update');

                        Route::get('card', 'CardController@getCard')->name('.account.card');
                        Route::post('card', 'CardController@setCard')->name('.account.card');
                        Route::get('card-change', 'CardController@changeCard')->name('.account.card-change');
                        Route::post('card-change', 'CardController@setCard')->name('.account.card-change');

                        Route::get('favorites', 'ProductController@favorites')->name('.account.favorites');
                        Route::get('purchases', 'PurchaseController@allPurchases')->name('.account.purchases');
                        Route::get('purchase/{id}', 'PurchaseController@getPurchase')->name('.account.purchase');
                        Route::get('purchase/{id}/refund-request', 'PurchaseController@requestRefund')->name('.account.purchase.refund-request');
                        Route::get('orders', 'OrderController@allOrders')->name('.account.orders');
                        Route::get('order/{id}', 'OrderController@getOrder')->name('.account.order');
                        Route::get('order/{id}/cancel', 'OrderController@cancelOrder')->name('.account.order.cancel');
                        Route::get('subscriptions', 'SubscriptionController@allSubscriptions')->name('.account.subscriptions');
                        Route::get('subscription/{id}', 'SubscriptionController@getSubscription')->name('.account.subscription');
                        Route::post('subscription/{name}/cancel', 'SubscriptionController@cancelSubscription')->name('.account.subscription.cancel');
                    });
                    Route::post('calculate/shipping', 'CheckoutController@reCalculateShipping')->name('.calculate.shipping');
                    Route::get('checkout', 'CheckoutController@confirm')->name('.checkout');
                    Route::get('payment', 'CheckoutController@payment')->name('.payment');
                    Route::post('coupon', 'CheckoutController@addCoupon')->name('.coupon');
                    Route::get('coupon/remove', 'CheckoutController@removeCoupon')->name('.coupon.remove');
                    Route::post('process', 'CheckoutController@process')->name('.process');
                    Route::post('process/last-card', 'CheckoutController@processWithLastCard')->name('.process.last-card');
                    Route::get('complete', 'CheckoutController@complete')->name('.purchase.complete');
                    Route::get('failed', 'CheckoutController@failed')->name('.purchase.failed');

                    Route::group(['prefix' => 'favorites', 'middleware' => ['isAjax']], function () {
                        Route::get('/', 'FavoriteController@all')->name('.favorites');
                        Route::get('add/{productId}', 'FavoriteController@add')->name('.favorites.add');
                        Route::get('remove/{productId}', 'FavoriteController@remove')->name('.favorites.remove');
                    });
                });
            });
        });
    });
