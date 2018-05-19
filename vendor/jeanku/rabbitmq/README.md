## Install

Via Composer

``` bash
 composer require jeanku/rabbitmq:dev-master
```


# initialization
add config in .env file as follow,and make sure we can get the config with the method env():
``` bash
.env file config:
RABBITMQ_HOST=127.0.0.1             #rabbitmq host
RABBITMQ_USERNAME=rabbitmq          #rabbitmq user
RABBITMQ_PASSWORD=123456            #rabbitmq password
RABBITMQ_PORT=5672                  #rabbit port
```


# usage
# step 1: create your Class;
``` bash
<?php
 
 use Jeanku\Rabbitmq\Queue;
 
 /**
  * demo
  * @desc more description
  * @date 2018-04-02
  */
 class Demo extends Queue
 {
     //exchange name
     protected $exchange = 'demo';          //please overwrite the exchange depend on your business
     //queue name
     protected $queue = 'email';            //please overwrite the $queue depend on your business
     //route key
     protected $route = 'email';            //please overwrite the $route depend on your business
     //default direct
     protected $type = AMQP_EX_TYPE_DIRECT;
     //空队列等待时间 默认10秒
     protected $wait = 10;
     //多消费者任务均衡分配 默认一个
     protected $prefetch = 1;
 
     /**
      * your business code, consume the queue data function
      * @param string $mge require the message you get from queue
      * @return array
      */
     public function handle($msg) {
         //todo
     }
 }
 ```

# step 2: push message:
``` bash
Demo::push('log message');
```
 
# step 3: consume queue
 ``` bash
   php Demo.php 
 ```

 
	


 
