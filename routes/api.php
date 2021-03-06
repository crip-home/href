<?php

Route::post('login', 'Api\\LoginController@login');

Route::get('tag/all/{pageId}', 'Api\\HrefController@tags');
Route::get('href/title', 'Api\\HrefController@title');
Route::get('href/exists', 'Api\\HrefController@exists');
Route::post('href/create', 'Api\\HrefController@create');
Route::get('href/list/{parent}', 'Api\\HrefController@list');
Route::resource('href', 'Api\\HrefController', ['only' => [
    'store', 'show', 'update', 'destroy', 'index'
]]);

Route::get('category/guess/{pageId}', 'Api\\CategoryController@guess');
Route::resource('category', 'Api\\CategoryController', ['only' => [
    'index', 'store', 'show', 'update'
]]);
