<?php

app('route')->any('/aaa', function() {
    echo 'Hello World';
});

app('route')->any('/bbb', function() {
    return [123,444];
});


app('route')->any('/ccc', function() {
    echo 'Hello ccc';
});


Route::any('/home', 'App\Controllers\HomeController@home');
Route::any('/menu/lists', 'App\Controllers\MenuController@lists');