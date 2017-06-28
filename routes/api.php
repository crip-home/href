<?php

Route::get('href/title', 'Api\\HrefController@title');
Route::get('href/list/{parent}', 'Api\\HrefController@index');
Route::resource('href', 'Api\\HrefController', ['only' => [
    'store', 'show', 'update', 'destroy'
]]);

Route::resource('category', 'Api\\CategoryController', ['only' => [
    'index', 'store', 'show', 'update'
]]);
