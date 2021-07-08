<?php

namespace App\Libraries;

use Endroid\QrCode\QrCode;

class stringLib
{
    public function removeLastDirURL($url)
    {
        $info = parse_url($url);
        $info["path"] = dirname($info["path"]);

        $new_url = "";
        if (!empty($info["scheme"])) {
            $new_url .= $info["scheme"] . "://";
        }
        $new_url .= $info["host"] . $info["path"];
        if (!empty($info["query"])) $new_url .= "?" . $info["query"];
        if (!empty($info["fragment"])) $new_url .= "#" . $info["fragment"];
        return $new_url;
    }
    public function removeLastDirFileURL($path)
    {
        $position = strrpos($path, "\\");
        echo $position;
        $path = str_split($path);
        $path = array_slice($path, 0, $position);
        $path = implode($path);
        return $path;
    }

    public function capWord($word)
    {
        return ucfirst($word);
    }
    public function sepSentence($delimiter, $sentence)
    {
        return explode($delimiter, $sentence);
    }

    public function sepNCap($delimiter, $string)
    {
        $sentence = "";
        $cap_next = true;
        $total = strlen($string);
        $count = 0;
        while ($count < $total) {
            if ($string[$count] == $delimiter) {
                $sentence .= " ";
                $cap_next = true;
            } elseif ($cap_next) {
                $sentence .= ucfirst($string[$count]);
                $cap_next = false;
            } else {
                $sentence .= $string[$count];
            }
            $count += 1;
        }
        return $sentence;
    }

    public function chopExtension($string)
    {
        return substr($string, 0, strrpos($string, '.'));
    }
    public function is_serialized($string)
    {
        $result = @unserialize($string);
        if ($result !== false) {
            return true;
        } else {
            return false;
        }
    }
    public function is_json($string)
    {
        $result = json_decode($string);
        if (json_last_error() === JSON_ERROR_NONE) {
            return true;
        }
        return false;
    }
    public function make_json($string)
    {
        if ($this->is_json($string)) :
            return $string;
        else :
            return json_encode($string);
        endif;
    }
    public function rm_json($string)
    {
        if (!$this->is_json($string)) :
            return $string;
        else :
            return json_decode($string);
        endif;
    }
    public function make_serialized($string)
    {
        if ($this->is_serialized($string)) :
            return $string;
        else :
            return serialize($string);
        endif;
    }
    public function rm_serialized($string)
    {
        if (!$this->is_serialized($string)) :
            return $string;
        else :
            return unserialize($string);
        endif;
    }
    public function txt2qr($string)
    {
        $qrCode = new QrCode($string);
        header('Content-Type: ' . $qrCode->getContentType());
        $dataUri = $qrCode->writeDataUri();
        return $dataUri;
    }
    public function eng2chi($string)
    {
        return $this->translate($string, 'zh-TW');
    }
    function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+|\=-;:{}';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    function generateRandomNumber($length = 10)
    {
        $max = "";
        for ($i = 0; $i < $length; $i++) {
            $max .= "9";
        }
        $max = (int) $max;
        return mt_rand(0, $max);
    }
    public function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}
