<?php
# Library model

namespace App\Models;

use CodeIgniter\Model;

// Demo
// $params = [
//     "data" => [
//         [
//             "table" => "class_users",
//             "action" => "update",
//             "set" => [
//                 "status" => "withdraw",
//             ],
//             "where" => [
//                 "id" => $item->id,
//             ],
//         ],
//         [
//             "table" => "class_history",
//             "action" => "insert",
//             "set" => [
//                 "user_id" => $userid,
//                 "action" => "withdraw",
//                 "class_id" => $item->id,
//             ],
//         ],
//     ],
//     "extra" => [
//         "onlyif" => [
//             "table" => "classes",
//             "where" => [
//                 "id" => $item->id,
//                 "start_date >" => $this->dtL->pastDT($this->dtL->currentDT(), 12 * 60 * 60),
//             ],
//         ],
//     ],
//     "modal" => [
//         "header" => "withdraw Course",
//         "content" => "Are you sure you want to withdraw this course?<br> You will gain +1 ticket for an active package.",
//         "button" => "withdraw",
//         "action" => "delete",
//         "defined" => true,
//     ],
// ];
// echo $this->tokenM->getNumber($params);

class Token extends Model
{
    // protected $table = 'token';

    public $token = "";
    public $expire_min = 60;
    public $created = "";

    public $params = [
        "meta" => [
            "token" => "",
            "created" => "",
        ],
        "data" => [
            [
                "table" => "",
                "action" => "",
                "id" => "",
                "duplicates" => true,
                "set" => [],
                "where" => [],
            ],
        ],
        "modal" => [
            "header" => "",
            "content" => "",
            "action" => "",
            "button" => "",
            "defined" => "false",
            "redirect" => "",
            "direct" => ""
        ],
    ];

    // Commonly used variables
    public $result = [];

    public function __construct()
    {
        $this->dbL = new \App\Libraries\dbLib();
        $this->db = $this->dbL->db;
        $this->dtL = new \App\Libraries\datetimeLib();
        $this->varL = new \App\Libraries\varLib();
        $this->stringL = new \App\Libraries\stringLib();
        // $this->clean();
    }

    // Fundamental functions
    public function generateToken()
    {
        $method = $this->stringL->generateRandomString();
        // $method = $this->stringL->generateRandomNumber();
        return md5($method);
    }
    public function getRowByArray($data)
    {
        return $this->dbL->whereRows("token", $data);
    }
    public function getRowByToken($token)
    {
        return $this->dbL->whereRows("token", ["token" => $token]);
    }

    // 2nd Layer function
    public function getRow($arg)
    {
        if (is_array($arg)) :
            $info = $this->getRowByArray($arg);
        elseif (is_string($arg)) :
            $info = $this->getRowByToken($arg);
        endif;
        if ($this->varL->record_exist($info)) :
            foreach (['data', 'extra', 'modal'] as $key) :
                $info[0]->{$key} = json_decode($info[0]->{$key});
            endforeach;
        endif;
        return $info;
    }
    public function ifRecordActive($result)
    {
        $current_time = $this->dtL->currentDT();
        $record_time = $result[0]->created;
        $past_time = $this->dtL->pastDT($current_time, $this->expire_min * 60);
        return $past_time < $record_time;
    }
    public function ifTokenExist($token)
    {
        $result = $this->dbL->whereRows("token", ["token" => $token]);
        return $this->varL->record_exist($result);
    }

    // Public functions
    public function clean()
    {
        $currentDT = $this->dtL->currentDT();
        $pastDT = $this->dtL->pastDT($currentDT, $this->expire_min * 60);
        $this->dbL->deleteRows("token", "created < '$pastDT'");
    }

    # Search for active existing function, if not add
    public function get($data)
    {
        foreach (['data', 'extra', 'modal'] as $item) :
            if (isset($data[$item])) :
                $test_data[$item] = json_encode($data[$item]);
            endif;
        endforeach;
        // print_r($test_data);
        $result = $this->getRow($test_data);
        // print_r($result);

        $done = false;
        if ($this->varL->record_exist($result)) :
            // echo "exist";
            if ($this->ifRecordActive($result)) :
                // echo "active";
                $done = true;
            else :
                $this->dbL->removeRows("token", ['id' => $result[0]->id]);
            endif;
        endif;
        if ($done) :
            // echo "got it";
            // print_r($result);
            return $result;
        else :
            // echo "continues";

            $token = $this->generateToken();

            if ($this->ifTokenExist($token)) :
                return $this->get($data);
            endif;

            $final_data = $test_data;
            $final_data["token"] = $token;
            // print_r($final_data);
            $id = $this->dbL->insertRows("token", $final_data);
            return $this->dbL->whereRows("token", ["id" => $id]);
        endif;
    }
    public function getNumber($params)
    {
        $result = $this->get($params);
        // print_r($result[0]);
        return $result[0]->token;
    }

    // Supportive functions
    public function rm_date($data)
    {
        if (is_object($data)) :
            unset($data->date);
            unset($data->created);
        elseif (is_array($data)) :
            unset($data['date']);
            unset($data['created']);
        endif;
        return $data;
    }

    # Only basic
    public function row_token($result, $name, $params)
    {
        $count = 0;
        foreach ($result as $item) :
            $result[$count]->{$name} = $this->getNumber($params);
            $count += 1;
        endforeach;
        return $result;
    }
}
