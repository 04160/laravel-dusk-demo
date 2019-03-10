<?php

Route::get('/', function () {
    return view('welcome');
});

$controller = 'Controller';

Route::middleware('auth')->group(function () use ($controller) {
    Route::get('/list', "$controller@listView");
    Route::post('/value/', "$controller@createValue");
    Route::put('/value/{value_id}', "$controller@editValue");
    Route::delete('/value/{value_id}', "$controller@deleteValue");
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
