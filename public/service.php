<?php
//执行service入口文件
//demo php service.php Log
// Autoload 自动载入
require '../vendor/autoload.php';
require '../app/Libs/helpers.php';

//设置错误级别
define('WEBPATH', dirname(__DIR__));
setenv();
$class = 'App\Services\\' . $argv[1];
$instance = new $class();
return call_user_func_array(array($instance, 'run'), []);