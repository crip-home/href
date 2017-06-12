<?php

Auth::routes();

// Hrefs root
Route::get('/', 'HrefController@index')->name('index');
Route::get('/home', 'HomeController@index')->name('home');

// Admin panel root enter of SPA
Route::get('/admin', 'AdminController@index')->name('admin');

