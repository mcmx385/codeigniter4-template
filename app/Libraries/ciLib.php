<?php

namespace App\Libraries;

class ciLib
{
    public function loadController($url, $params)
    {
        print_r($params);
        $function_array = explode("/", $url);
        $count = count($function_array);
        if ($count == 2) :
            $controller_name = $function_array[0];
            $function_name = $function_array[1];
        else :
            $new_function_array = array_slice($function_array, 0, $count - 1);
            $controller_name = implode('\\', $new_function_array);
            $function_name = $function_array[$count-1];
        endif;
        require_once(APPPATH . "controllers\\$controller_name.php");
        $classname = "App\Controllers\\" . $controller_name;
        $objectname = $controller_name . "c";
        $this->$objectname = new $classname;
        return $this->$objectname->{$function_name}($params);
    }

    public function baseurl()
    {
        $fcpath = explode("\\", FCPATH);
        $baseurl = array_slice($fcpath, 0, -2);
        $baseurl = implode("\\", $baseurl);
        return $baseurl;
    }
}
