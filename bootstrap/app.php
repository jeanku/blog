<?php

$app = \Jeanku\Util\Container::getInstance();

$app->instance('app', $app);
$app->singleton('log', \Jeanku\Util\Log::class);
$app->singleton('config', \Jeanku\Util\Config::class);
$app->singleton('request', \Jeanku\Util\Request::class);
$app->singleton('response', \Symfony\Component\HttpFoundation\JsonResponse::class);
$app->instance('route', $route = System\Route::instance());

$config = config('app', 'aliases');
foreach ($config as $key => $val) {
    class_alias($val, $key);
}

return $app;
