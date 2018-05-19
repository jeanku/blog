<?php
namespace App\Controllers;

use App\Modules\Menu;
use Request;
use Log;

/**
 * Menu class
 * @desc more description
 * @author jeanku
 * @date 2018-05-19
 */
class MenuController extends BaseController
{

    /**
     * lists function
     * @date 2018-05-19
     * @return Response
     */
    public function lists()
    {
        return $this->success(Menu::lists(Request::all(), Request::input('page', 1), Request::input('size', 10)));
    }

    /**
     * add function
     * @date 2018-05-19
     * @return Response
     */
    public function add()
    {
        $filed = [
            'id'=>'sometime|int|min:0',                                                             //??ID
            'name'=>'sometime|string|length:[0,30]',                                                //????
            'parent_id'=>'sometime|int|min:0',                                                      //???ID
            'url'=>'sometime|string|length:[0,100]',                                                //????
            'key'=>'sometime|string|length:[0,50]',                                                 //??key
            'type'=>'sometime|int|min:0',                                                           //???? 0:?? 1:?? 2:??
            'icon'=>'sometime|string|length:[0,25]',                                                //????
            'status'=>'sometime|int|min:0',                                                         //????:1:?? 0:??
            'create_time'=>'sometime|int|min:0',                                                    //????
            'update_time'=>'sometime|int|min:0',                                                    //????
        ];
        $param = self::validate($filed, Request::all());
        return $this->success(Menu::add($param));
    }


    /**
     * update function
     * @date 2018-05-19
     * @return Response
     */
    public function update()
    {
        $filed = [
            'id'=>'sometime|int|min:0',                                                             //??ID
            'name'=>'sometime|string|length:[0,30]',                                                //????
            'parent_id'=>'sometime|int|min:0',                                                      //???ID
            'url'=>'sometime|string|length:[0,100]',                                                //????
            'key'=>'sometime|string|length:[0,50]',                                                 //??key
            'type'=>'sometime|int|min:0',                                                           //???? 0:?? 1:?? 2:??
            'icon'=>'sometime|string|length:[0,25]',                                                //????
            'status'=>'sometime|int|min:0',                                                         //????:1:?? 0:??
            'create_time'=>'sometime|int|min:0',                                                    //????
            'update_time'=>'sometime|int|min:0',                                                    //????
        ];
        $param = self::validate($filed, Request::all());
        return $this->success(Menu::update($param));
    }


    /**
     * show function
     * @date 2018-05-19
     * @return Response
     */
    public function show()
    {
        $filed = [
            'id' => 'require|int|min:0'
        ];
        $param = self::validate($filed, Request::all());
        return $this->success(Menu::show($param));
    }


    /**
     * del function
     * @date 2018-05-19
     * @return Response
     */
    public function del()
    {
        $filed = [
            'id' => 'require|int|min:0'
        ];
        $param = self::validate($filed, Request::all());
        return $this->success(Menu::del($param));
    }

}