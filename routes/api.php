<?php

use Illuminate\Support\Facades\Route;


Route::post('product/', 'Api\ProductController@store');
Route::delete('product/voucher/{productId}/{voucherId}/', 'Api\ProductController@deleteVoucher');
Route::get('product/voucher/{productId}/{voucherId}/', 'Api\ProductController@addVoucher');
Route::get('product/buy/{id}/', 'Api\ProductController@buy');
