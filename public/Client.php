<?php

require '../vendor/autoload.php';

error_reporting(E_ALL);

use Jeanku\Thrift\ClassLoader\ThriftClassLoader;

//$GEN_DIR = dirname(__DIR__) .'/app/Thrift/gen-php';
//$loader = new ThriftClassLoader();
//$loader->registerNamespace('Thrift',__DIR__.'/app/Util/lib');
//$loader->registerDefinition('HelloThrift',$GEN_DIR);
//$loader->register();

use Jeanku\Thrift\Protocol\TBinaryProtocol;
use Jeanku\Thrift\Transport\TSocket;
use Jeanku\Thrift\Transport\THttpClient;
use Jeanku\Thrift\Transport\TBufferedTransport;


try {
    if (array_search('--http',$argv)) {
        $socket = new THttpClient('localhost',8080,'/Server.php');
    } else {
        $socket = new TSocket('localhost',9090);
    }

    $transport = new TBufferedTransport($socket,1024,1024);
    $protocol  = new TBinaryProtocol($transport);
    $client = new \App\Thrift\HelloThrift\HelloServiceClient($protocol);

    $transport->open();

    $res = $client->sayHello(" World! ");
    echo "<pre>";
    print_r($res);
    $transport->close();
    exit;


} catch (\Exception $e) {
    print 'TException:'.$e->getMessage().PHP_EOL;
}