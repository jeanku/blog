<?php
// Autoload 自动载入
require '../vendor/autoload.php';
require '../app/Libs/helpers.php';

error_reporting(E_ALL);                     //设置错误级别
define('WEBPATH', dirname(__DIR__));


$app = \App\Controllers\Container::getInstance();
$app->singleton('log', \App\Util\Log::class);
$app->singleton('response', \App\Util\Response::class);
$app->singleton('request', \App\Util\Request::class);
$app->singleton('route', \App\Util\Log::class);

$log = $container->make('log');

echo "<pre>";
print_r(env('RABBITMQ_HOST'));
print_r($log1 === $log);
exit;



//\Jeanku\Database\DatabaseManager::make(WEBPATH . '/config/'. ENV . '/database.php');


$app            = System\App::instance();
$app->request   = System\Request::instance();
$app->route     = System\Route::instance($app->request);

$route          = $app->route;

$route->any('/aaa', function() {
    echo 'Hello World';
});

$route->end();

