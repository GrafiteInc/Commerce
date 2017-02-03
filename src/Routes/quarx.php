<?php

    /*
    |--------------------------------------------------------------------------
    | Quazar
    |--------------------------------------------------------------------------
    */

    Route::group(['prefix' => 'quarx', 'middleware' => ['web', 'auth', 'quarx']], function () {

        /*
        |--------------------------------------------------------------------------
        | Products
        |--------------------------------------------------------------------------
        */
        Route::resource('products', 'ProductController', ['as' => 'quarx', 'except' => ['show']]);
        Route::post('products/search', 'ProductController@search');

        Route::post('products/variants/{id}', 'ProductVariantController@variants');
        Route::post('products/download/{id}', 'ProductController@updateAlternativeData');
        Route::post('products/dimensions/{id}', 'ProductController@updateAlternativeData');
        Route::post('products/discounts/{id}', 'ProductController@updateAlternativeData');

        Route::group(['middleware' => 'isAjax'], function () {
            Route::post('products/variant/save', 'ProductVariantController@saveVariant');
            Route::post('products/variant/delete', 'ProductVariantController@deleteVariant');
        });
        Route::get('products/{id}/delete', [
            'as' => 'quarx.products.delete',
            'uses' => 'ProductController@destroy',
        ]);

        Route::get('commerce-analytics', 'AnalyticsController@dashboard');

        /*
        |--------------------------------------------------------------------------
        | Plan Routes
        |--------------------------------------------------------------------------
        */
        Route::resource('plans', 'PlanController', ['except' => ['show'], 'as' => 'quarx']);
        Route::post('plans/search', 'PlanController@search');
        Route::get('plans/{id}/state-change/{state}', 'PlanController@stateChange');
        Route::delete('plans/{id}/cancel-subscription/{user}', 'PlanController@cancelSubscription');

        /*
        |--------------------------------------------------------------------------
        | Transactions
        |--------------------------------------------------------------------------
        */
        Route::resource('transactions', 'TransactionController', ['as' => 'quarx', 'except' => ['create', 'store', 'show', 'destroy']]);
        Route::post('transactions/search', 'TransactionController@search');
        Route::post('transactions/refund', 'TransactionController@refund');

        /*
        |--------------------------------------------------------------------------
        | Transactions
        |--------------------------------------------------------------------------
        */
        Route::resource('orders', 'OrderController', ['as' => 'quarx', 'except' => ['create', 'store', 'show', 'destroy']]);
        Route::post('orders/search', 'OrderController@search');
        Route::post('orders/cancel', 'OrderController@cancel');
    });
