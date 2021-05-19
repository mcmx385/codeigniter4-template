<?php

namespace App\Libraries;

class ArrObj
{
    public function arrCol($arr, $col)
    {
        $list = [];
        foreach ($arr as $item) :
            $item = (array) $item;
            array_push($list, $item[$col]);
        endforeach;
        return $list;
    }
}
