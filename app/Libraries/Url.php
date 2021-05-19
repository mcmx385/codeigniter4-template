<?php

namespace App\Libraries;

class URL
{
    public function head($location)
    {
        header("location: $location");
        exit;
    }
    public function getBase()
    {
        return $_SERVER['SERVER_NAME'];
    }
    public function getPrev()
    {
        return $_SERVER['HTTP_REFERER'];
    }
    public function goPrev()
    {
        $this->head($this->getPrev());
    }
}
