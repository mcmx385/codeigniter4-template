<?php

namespace App\Libraries;

class urlLib
{
    public function header($location)
    {
        header("location: $location");
        exit;
    }
    public function redirect($location)
    {
        header('HTTP/1.1 307 Temporary Redirect');
        header("location: $location");
        exit;
    }
    public function prevUrl()
    {
        return $_SERVER['HTTP_REFERER'];
    }
    public function currentUrl()
    {
        return $_SERVER["REQUEST_URI"];
    }
    public function headPrevUrl()
    {
        $this->header($this->prevUrl());
    }
    public function noVarUrl($url)
    {
        return strtok($url, '?');
    }
    public function noVarPrevUrl()
    {
        return $this->noVarUrl($this->prevUrl());
    }
    public function POSTOrPrev($PostName)
    {
        if (isset($_POST[$PostName])) :
            return $_POST[$PostName];
        else :
            return $this->prevUrl();
        endif;
    }
    public function urlRemoveLast($url)
    {
        $url = explode("/", $url);
        array_pop($url);
        $url = implode("/", $url);
        return $url;
    }
    public function headUrl($location, $variables = [])
    {
        if (isset($variables["status"])) :
            $variables["status"] = urlencode($variables["status"]);
        endif;
        $variables = array_filter($variables);
        if (count($variables) > 0) :
            $location = strtok($location, "?");
            $location .= "?";
            $count = 0;
            foreach ($variables as $key => $value) :
                if ($count == 0) :
                    $location .= "$key=$value";
                else :
                    $location .= "&$key=$value";
                endif;
                $count += 1;
            endforeach;
        endif;
        $this->header($location);
    }
    function changeUrlParam($url, $parameter, $parameterValue)
    {
        $url = parse_url($url);
        parse_str($url["query"], $parameters);
        unset($parameters[$parameter]);
        $parameters[$parameter] = $parameterValue;
        return  $url["path"] . "?" . http_build_query($parameters);
    }
}
