<?php

Route::get('tag/all/{pageId}', 'Api\\HrefController@tags');
Route::get('href/title', 'Api\\HrefController@title');
Route::get('href/list/{parent}', 'Api\\HrefController@index');
Route::resource('href', 'Api\\HrefController', ['only' => [
    'store', 'show', 'update', 'destroy'
]]);

Route::get('category/guess/{pageId}', 'Api\\CategoryController@guess');
Route::resource('category', 'Api\\CategoryController', ['only' => [
    'index', 'store', 'show', 'update'
]]);
