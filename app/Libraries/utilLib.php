<?php

namespace App\Libraries;

class utilLib
{
    public function __construct()
    {
        $this->dbL = new \App\Libraries\dbLib();
        $this->db = $this->dbL->db;
        $this->dtL = new \App\Libraries\datetimeLib();
        $this->stringL = new \App\Libraries\stringLib();
        $this->varL = new \App\Libraries\varLib();
        $this->ajaxL = new \App\Libraries\ajaxLib();
        $this->colorL = new \App\Libraries\colorLib();
        $this->tokenM = new \App\Models\Token();
        $this->translateM = new \App\Models\Translate();
    }

    public function manage($table)
    {
        $where = "id > 0";
        $data['result'] = $this->dbL->selectRows($table, $where);
        $columns = $this->dbL->fieldsTable($table);

        $data['table'] = $table;
        $data['columns'] = $columns;

        # Add button
        $params = [
            "data" => [
                [
                    "table" => $table,
                    "action" => "add",
                    "set" => [
                        "status" => "active"
                    ],
                ]
            ],
            "modal" => [
                "header" => "Add $table",
                "filter" => ["updated", "status", 'date', 'created'],
            ],
        ];
        $data['add_token'] = $this->tokenM->getNumber($params);

        # Action buttons
        $count = 0;
        foreach ($data['result'] as $item) :
            $params = [
                "data" => [
                    [
                        "table" => $table,
                        "action" => "edit",
                        "where" => [
                            "id" => $item->id,
                        ],
                    ],
                ],
                "modal" => [
                    "header" => "Edit record",
                ],
            ];
            $data['result'][$count]->edit_token = $this->tokenM->getNumber($params);
            $params = [
                "data" => [
                    [
                        "table" => $table,
                        "action" => "delete",
                        "where" => [
                            "id" => $item->id,
                        ],
                    ],
                ],
                "modal" => [
                    "header" => "Delete record",
                ],
            ];
            $data['result'][$count]->delete_token = $this->tokenM->getNumber($params);
            $count += 1;
        endforeach;

        // print_r($data['result']);
        return $data;
    }

    public function databaseList()
    {
        $data = [];

        $tables = $this->dbL->listTables();
        foreach ($tables as $table) :
            $icons_param = [
                "title" => ucfirst($table),
                "table" => $table,
                "icon" => [
                    ["link" => "/util/chart/$table", "button" => "chart"],
                    ["link" => "/util/form/add/$table", "button" => "add"],
                    ["link" => "/util/form/edit/$table", "button" => "edit"],
                ]
            ];
            array_push($data, $icons_param);
        endforeach;

        return $data;
    }

    public function form($action, $table, $id, $params = [])
    {
        $data['status'] = $_GET['status'];

        // Setup input fields
        $column_list = $this->dbL->fieldsTable($table);
        $data = [];
        switch ($action):
            case ("add"):
                $data['data'] = $this->varL->emptyArrayObject($column_list);
                foreach ($data['data'][0] as $key => $value) :
                    if (!empty($_GET[$key])) :
                        $data['data'][0]->$key = $_GET[$key];
                    endif;
                endforeach;
                break;
            case ("delete"):
            case ("view"):
            case ("edit"):
                $id = (int) $id;
                if ($id > 0) :
                    $data['data'] = $this->dbL->whereRows($table, ["id" => $id]);
                else :
                    $data['status'] .= "You must have a target id";
                endif;
                break;
            default:
                break;
        endswitch;
        $data['result_exist'] = count($data) > 0;

        // Filter columns
        $filter_list = [
            "classes" => [
                "add" => ['start_time', 'end_time', 'emoji', 'icon', 'text_color', 'status'],
            ],
            "package_user" => [
                "add" => ["tickets", 'quantity', "status", "start_date", "expire_date"],
            ]
        ];
        $filter = ["updated", "created"];
        if (isset($filter_list[$table][$action])) :
            $filter = array_merge($filter, $filter_list[$table][$action]);
        endif;
        $data['filter'] = $filter;

        // Form target
        $target_list = [
            "package_user" => [
                "add" => "/package/addUser",
            ],
            "default" => [
                "all" => "/ajax/request/page",
            ]
        ];
        if (isset($target_list[$table][$action])) :
            $data['formTarget'] = $target_list[$table][$action];
        else :
            $data['formTarget'] = $target_list["default"]["all"];
        endif;

        // Required list
        $required_list = [
            'books' => true,
            'default' => false,
        ];
        if (isset($required_list[$table])) :
            $data['required'] = $required_list[$table];
        else :
            $data['required'] = $required_list["default"];
        endif;
        $prev_list = [
            'package_user' => '/user/details/' . $id,
            'default' => $_SERVER['HTTP_REFERER'],
        ];
        if (isset($prev_list[$table])) :
            $data['previous_page'] = $prev_list[$table];
        else :
            $data['previous_page'] = $prev_list["default"];
        endif;

        // Adding token
        if (empty($params)) :
            $params = [
                "data" => [
                    [
                        "table" => $table,
                        "action" => $action,
                        "duplicate" => false,
                        "where" => [
                            "id" => $id,
                        ],
                    ],
                ],
            ];
        endif;
        $data['token'] = $this->tokenM->getNumber($params);

        # Other params ( must be here )
        $data['action'] = $action;
        $data['table'] = $table;

        // Title
        $form_title = "";
        $form_title .= $this->translateM->getWord("zh-hk", $action);
        $form_title .= $this->translateM->getWord("zh-hk", $table);
        $data['form_title'] = $form_title;

        // Dependencies
        $data['ajaxL'] = $this->ajaxL;
        $data['modalL'] = $this->modalL;
        $data['colorL'] = $this->colorL;

        return $data;
    }
}
