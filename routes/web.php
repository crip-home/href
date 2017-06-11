<?php

// Hrefs root
Route::get('/', 'HrefController@index')->name('home');

// Admin panel root enter of SPA
Route::get('/admin', 'AdminController@index')->name('admin');
