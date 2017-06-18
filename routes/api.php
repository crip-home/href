<?php

Route::get('href/list/{parent}', 'Api\\HrefController@index');
Route::resource('href', 'Api\\HrefController', ['only' => [
    'store', 'show', 'update', 'destroy'
]]);

Route::resource('category', 'Api\\CategoryController');
