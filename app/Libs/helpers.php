<?php

if (! function_exists('dd')) {
    function dd() {
        array_map(function ($x) {var_dump($x);}, func_get_args());die(1);
    }
}

if (! function_exists('distance')) {
    /**
     *求两个已知经纬度之间的距离,单位为米
     *@param lng1,lng2 经度
     *@param lat1,lat2 纬度
     *@return float 距离，单位米
     *@author www.phpernote.com
     **/
    function distance($lat1, $lng1, $lat2, $lng2){
        //将角度转为狐度
        $radLat1=deg2rad($lat1);            //deg2rad()函数将角度转换为弧度
        $radLat2=deg2rad($lat2);
        $radLng1=deg2rad($lng1);
        $radLng2=deg2rad($lng2);
        $a=$radLat1-$radLat2;
        $b=$radLng1-$radLng2;
        $s=2*asin(sqrt(pow(sin($a/2),2)+cos($radLat1)*cos($radLat2)*pow(sin($b/2),2)))*6378.137*1000;
        return (intval(($s)) * 100) / 100;
    }
}


if (!function_exists('config'))
{
    /**
     * get config from config file
     * @param  string $file require file name
     * @param  string $key sometime key name
     * @demo1 config('database')
     * @demo2 config('database', 'default')
     * @demo3 config('dev/database', 'default')
     * @return mixed
     */
    function config($file, $key = null)
    {
        $path = WEBPATH .'/config/' . $file . '.php';
        if (is_file($path) && is_readable($path)) {
            $config = require($path);
        }
        if ($key) {
            return isset($config[$key]) ? $config[$key] : null;
        } else {
            return isset($config) ? $config : null;
        }
    }
}

if (!function_exists('env'))
{
    /**
     * get env config.
     * @param string $key config key
     * @return mixed
     */
    function env($key, $default = null)
    {
        return getenv($key) ? : $default;
    }
}

if (! function_exists('app')) {
    /**
     * Get the available container instance.
     * @param  string  $make
     * @param  array   $parameters
     * @return Container
     */
    function app($make = null, $parameters = [])
    {
        if (is_null($make)) {
            return \Jeanku\Util\Container::getInstance();
        }
        return \Jeanku\Util\Container::getInstance()->make($make, $parameters);
    }
}

if (! function_exists('setenv')) {
    /**
     * Set env.
     * @return void
     */
    function setenv()
    {
        $path = WEBPATH . DIRECTORY_SEPARATOR . '.env';
        if (is_file($path) && is_readable($path)) {
            $file = file_get_contents($path);
            preg_match_all('/[A-Z|_]+=[\w\.-_]+/', $file, $column);
            foreach ($column[0] as $enval) {
                putenv($enval);
            }
        }
    }
}