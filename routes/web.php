<?php

Route::get('/', function () {
    return view('welcome');
});

$controller = 'Controller';

Route::middleware('auth')->group(function () use ($controller) {
    Route::group([
        'as' => 'values.'
    ], function () use ($controller) {
        Route::get('/list', "$controller@listView")->name('list');
        Route::post('/value/', "$controller@createValue")->name('create');
        Route::post('/value/{value_id}/update', "$controller@editValue")->name('update');
        Route::post('/value/{value_id}/delete', "$controller@deleteValue")->name('delete');
    });
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
