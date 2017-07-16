<?php

Auth::routes();

// Hrefs root
Route::get('/', 'HrefController@index')->name('index');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/about', 'HomeController@about')->name('about');

// Admin panel root enter of SPA
Route::get('/admin', 'AdminController@index')->name('admin');

