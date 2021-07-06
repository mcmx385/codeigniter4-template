<?php

namespace App\Models;

use CodeIgniter\Model;

class Translate extends Model
{
    public function __construct()
    {
        $this->dbL = new \App\Libraries\dbLib();
        $this->db = $this->dbL->db;
        $this->dtL = new \App\Libraries\datetimeLib();
        $this->varL = new \App\Libraries\varLib();
    }
    public function get($collection, $original)
    {
        return $this->dbL->whereRows("translates", ["collection" => $collection, "original" => $original]);
    }
    public function getWord($collection, $original)
    {
        if (empty($original) || $original == "") :
            return "";
        else :
            $new_word = $original;
            $word_list = preg_split('/[_ ]/', $original);
            // print_r($word_list);
            $translated = $this->get($collection, $new_word);

            // Check if there is word without plural
            if (empty($translated) && substr($original, -2) == "es") :
                $new_word = substr($original, 0, -2);
                $translated = $this->get($collection, $new_word);
            endif;

            if (empty($translated) && substr($original, -1) == "s") :
                $new_word = substr($original, 0, -1);
                $translated = $this->get($collection, $new_word);
            endif;

            if (empty($translated)) :
                $new_word = $original;
                $translated = $this->get($collection, $new_word);
            endif;

            if (empty($translated)) :
                return $original;
            else :
                return $translated[0]->translated;
            endif;
        endif;
    }
}
