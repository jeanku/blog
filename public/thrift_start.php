<?php
require '../vendor/autoload.php';

error_reporting(E_ALL);

require_once dirname(__DIR__).'/app/Util/lib/ClassLoader/ThriftClassLoader.php';
use App\Util\lib\ClassLoader\ThriftClassLoader;

$GEN_DIR = dirname(__DIR__) .'/app/Thrift';
$loader = new ThriftClassLoader();
$loader->registerNamespace('Thrift',__DIR__.'/app/Util/lib');
$loader->registerDefinition('HelloThrift',$GEN_DIR);
$loader->register();

if (php_sapi_name() == 'cli') {
    ini_set('display_errors',"stderr");
}

use App\Util\lib\Protocol\TBinaryProtocol;
use App\Util\lib\Transport\TPhpStream;
use App\Util\lib\Transport\TBufferedTransport;

class HelloHandler implements \App\Thrift\HelloThrift\HelloServiceIf {

    public function sayHello($username)
    {
        return 123;
        return "Hello ".$username;
    }
}

header('Content-Type','application/x-thrift');
if (php_sapi_name() == 'cli') {
    echo PHP_EOL;
}


    $handler = new HelloHandler();
$processor = new \App\Thrift\HelloThrift\HelloServiceProcessor($handler);

$transport = new TBufferedTransport(new TPhpStream(TPhpStream::MODE_R | TPhpStream::MODE_W));
$protocol = new TBinaryProtocol($transport,true,true);

$transport->open();
$processor->process($protocol,$protocol);
$transport->close();