<?php
namespace App\Controllers;

use App\Modules\Menu;
use App\Util\Response;
//use App\Util\Request;
use Jeanku\Facades\Config;


class HomeController implements HelloWorldIf
{


    public function sayHello($name)
    {
        return [$name];
    }
}