<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'Main\IndexController@index')->name('index');
