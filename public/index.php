<?php
// Autoload 自动载入
require '../vendor/autoload.php';
require '../app/Libs/helpers.php';

error_reporting(E_ALL);                     //设置错误级别
define('WEBPATH', dirname(__DIR__));

$app = \App\Controllers\Container::getInstance();
$app->singleton('log', \Jeanku\Util\Log::class);
$app->singleton('config', \Jeanku\Util\Config::class);
$app->singleton('request', \Jeanku\Util\Request::class);
$app->singleton('response', \Symfony\Component\HttpFoundation\JsonResponse::class);
$app->instance('route', System\Route::instance());

$route = $app->make('route');
require WEBPATH . '/config/routes.php';

$response = $route->end();
$response->send();
