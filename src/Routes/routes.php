<?php

    /*
    |--------------------------------------------------------------------------
    | Hadron
    |--------------------------------------------------------------------------
    */

    Route::group(['prefix' => 'quarx', 'middleware' => ['web', 'auth', 'quarx']], function(){

        /*
        |--------------------------------------------------------------------------
        | Products
        |--------------------------------------------------------------------------
        */
        Route::resource('products', 'ProductController');
        Route::post('products/search', 'ProductController@search');
        Route::post('products/variants/{id}', 'ProductVariantController@variants');
        Route::group(['middleware' => 'isAjax'], function() {
            Route::post('products/variant/save', 'ProductVariantController@saveVariant');
            Route::post('products/variant/delete', 'ProductVariantController@deleteVariant');
        });
        Route::get('products/{id}/delete', [
            'as' => 'quarx.products.delete',
            'uses' => 'ProductController@destroy',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Transactions
        |--------------------------------------------------------------------------
        */
        Route::resource('transactions', 'TransactionController');
        Route::post('transactions/search', 'TransactionController@search');
        Route::post('transactions/refund', 'TransactionController@refund');
        Route::get('transactions/{id}/delete', [
            'as' => 'quarx.transactions.delete',
            'uses' => 'TransactionController@destroy',
        ]);
    });

