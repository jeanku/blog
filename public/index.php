<?php
// Autoload 自动载入
require '../vendor/autoload.php';
require '../app/Libs/helpers.php';

//设置错误级别
error_reporting(E_ALL);
define('WEBPATH', dirname(__DIR__));

$app = require_once WEBPATH .'/bootstrap/app.php';
Route::handle();



