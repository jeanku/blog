<?php

$app = \Jeanku\Util\Container::getInstance();

$app->instance('app', $app);
$app->singleton('log', \App\Services\Log::class);           //rabbitmq日志
$app->singleton('config', \Jeanku\Util\Config::class);
$app->singleton('request', \Jeanku\Util\Request::class);
$app->singleton('response', \Symfony\Component\HttpFoundation\JsonResponse::class);
$app->singleton('exceptionHandle', \App\Exceptions\HandleExceptions::class);
$app->instance('redis', \Jeanku\Util\Redis::class);
$app->instance('route', $route = System\Route::instance());

//处理Exception Error
$app->make('exceptionHandle')->bootstrap();

$config = config('app');
foreach ($config['aliases'] as $key => $val) {
    class_alias($val, $key);
}
ini_set('date.timezone',$config['timezone']);

return $app;
