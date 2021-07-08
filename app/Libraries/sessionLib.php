<?php

namespace App\Libraries;

class sessionLib
{
    public function ifActive()
    {
        return session_status() === PHP_SESSION_ACTIVE;
    }
    public function issetSessionList($list)
    {
        $isset = true;
        foreach ($list as $item) :
            if (!isset($_SESSION[$item])) :
                $isset = false;
            endif;
        endforeach;
        return $isset;
    }
    public function isEmptySessionList($list)
    {
        $isempty = false;
        foreach ($list as $item) :
            if (empty($_SESSION[$item])) :
                $isempty = true;
            endif;
        endforeach;
        return $isempty;
    }
    public function issetCookieList($list)
    {
        $isset = true;
        foreach ($list as $item) :
            if (!isset($_COOKIE[$item])) :
                $isset = false;
            endif;
        endforeach;
        return $isset;
    }
    public function isEmptyCookieList($list)
    {
        $isempty = false;
        foreach ($list as $item) :
            if (empty($_COOKIE[$item])) :
                $isempty = true;
            endif;
        endforeach;
        return $isempty;
    }

    public function setSessionList($list)
    {
        foreach ($list as $key => $value) :
            $_SESSION[$key] = $value;
        endforeach;
    }

    public function setCookie($name, $value, $time = 99999999, $directory = "/")
    {
        setcookie($name, $value, time() + $time, $directory);
    }
    public function removeCookie($name, $directory = "/")
    {
        setcookie($name, "", time() - 3600, $directory);
    }
}
