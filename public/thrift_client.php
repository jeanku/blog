<?php

require '../vendor/autoload.php';

error_reporting(E_ALL);

require_once dirname(__DIR__).'/app/Util/lib/ClassLoader/ThriftClassLoader.php';
use App\Util\lib\ClassLoader\ThriftClassLoader;

$GEN_DIR = dirname(__DIR__) .'/app/Thrift/gen-php';
$loader = new ThriftClassLoader();
$loader->registerNamespace('Thrift',__DIR__.'/app/Util/lib');
$loader->registerDefinition('HelloThrift',$GEN_DIR);
$loader->register();

use App\Util\lib\Protocol\TBinaryProtocol;
use App\Util\lib\Transport\TSocket;
use App\Util\lib\Transport\THttpClient;
use App\Util\lib\Transport\TBufferedTransport;
use App\Util\lib\Exception\TException;


try {
    if (array_search('--http',$argv)) {
        $socket = new THttpClient('localhost',8080,'/thrift_start.php');
    } else {
        $socket = new TSocket('localhost',9090);
    }

    $transport = new TBufferedTransport($socket,1024,1024);
    $protocol  = new TBinaryProtocol($transport);
    $client = new \App\Thrift\HelloThrift\HelloServiceClient($protocol);

    $transport->open();

    echo $client->sayHello(" World! ");

    $transport->close();
} catch (\Exception $e) {
    print 'TException:'.$e->getMessage().PHP_EOL;
}