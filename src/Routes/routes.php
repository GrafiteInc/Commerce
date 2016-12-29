<?php

    /*
    |--------------------------------------------------------------------------
    | Hadron
    |--------------------------------------------------------------------------
    */

    Route::group(['prefix' => 'quarx', 'middleware' => ['web', 'auth', 'quarx']], function () {

        /*
        |--------------------------------------------------------------------------
        | Products
        |--------------------------------------------------------------------------
        */
        Route::resource('products', 'ProductController', ['as' => 'quarx']);
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

        /*
        |--------------------------------------------------------------------------
        | Plan Routes
        |--------------------------------------------------------------------------
        */
        Route::resource('plans', 'PlanController', ['except' => ['show'], 'as' => 'quarx']);
        Route::post('plans/search', 'PlanController@search');
        Route::get('plans/{id}/state-change/{state}', 'PlanController@stateChange');

        /*
        |--------------------------------------------------------------------------
        | Transactions
        |--------------------------------------------------------------------------
        */
        Route::resource('transactions', 'TransactionController', ['as' => 'quarx']);
        Route::post('transactions/search', 'TransactionController@search');
        Route::post('transactions/refund', 'TransactionController@refund');

        /*
        |--------------------------------------------------------------------------
        | Transactions
        |--------------------------------------------------------------------------
        */
        Route::resource('orders', 'OrderController', ['as' => 'quarx']);
        Route::post('orders/search', 'OrderController@search');
        Route::post('orders/cancel', 'OrderController@cancel');
    });
