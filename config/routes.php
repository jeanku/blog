<?php

$route->any('/aaa', function() {
    echo 'Hello World';
});

$route->any('/bbb', function() {
    return [123,444];
});


$route->any('/ccc', function() {
    echo 'Hello ccc';
});


$route->any('/home', 'App\Controllers\HomeController@home');
$route->any('/menu/lists', 'App\Controllers\MenuController@lists');