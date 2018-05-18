<?php
namespace App\Controllers;

use App\Modules\Menu;
use App\Util\Response;
//use App\Util\Request;
use Jeanku\Facades\Config;


class HomeController extends BaseController
{


    public function home()
    {
//        $param = Request::all();
//        Log::info('fffff');
        $data = Config::get('database');
        echo "<pre>";
        print_r($data);
        exit;
        return true;
    }
}