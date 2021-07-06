<?php

namespace App\Libraries;

class tableLib
{
    public function __construct()
    {
        $this->dbL = new \App\Libraries\dbLib();
        $this->db = $this->dbL->db;
        $this->dtL = new \App\Libraries\datetimeLib();
        $this->utilL = new \App\Libraries\utilLib();
        $this->varL = new \App\Libraries\varLib();
        $this->ajaxL = new \App\Libraries\ajaxLib();
        $this->urlL = new \App\Libraries\urlLib();
        $this->tokenM = new \App\Models\Token();
        $this->translateM = new \App\Models\Translate();
        $this->widgetL = new \App\Libraries\widgetLib();
        $this->tokenM = new \App\Models\Token();
    }
    public function standard($table)
    {
        // Page quantity anywhere
        $page = $this->varL->getVar([
            "name" => "page",
            "default" => 1,
            "source" => "get",
            "empty" => false,
        ]);
        $quantity = $this->varL->getVar([
            "name" => "quantity",
            "default" => 10,
            "source" => "get",
            "empty" => false,
        ]);
        $anywhere = $this->varL->getVar([
            "name" => "anywhere",
            "default" => "",
            "source" => "get",
            "empty" => false,
        ]);
        $userid = $this->varL->getVar([
            "name" => "userid",
            "default" => "",
            "source" => "session",
            "empty" => false,
        ]);
        $table_string = explode("_", $table);
        if (count($table_string) > 1) {
            array_pop($table_string);
        }
        $core_table = implode("_", $table_string);

        // Join and select
        // Must have ID, or else buttons cant work
        $custom_list = [
            "matches_show" => [
                "join" => [
                    "method" => "left outer",
                    "joints" => [
                        "users" => "matches.user_id = users.id",
                    ]
                ],
                "select" => [
                    "users" => ["username"],
                    "matches" => ["id", "user_id", "target", "location", "price", "purpose", "time", "subject", "date"]
                ],
                'where' => [
                    'availability' => '服務中',
                ],
                "filter" => [
                    "matches" => ["id", "user_id"],
                ],
                "table_list" => false,
                "checkbox" => false,
                "buttons" => [
                    "edit" => [],
                    "delete" => [],
                    "apply" => [
                        "link" => "",
                        "button" => "add",
                        "token" => "join_token",
                        "hideif" => [
                            "equal" => [
                                "user_id" => $userid,
                            ]
                        ],
                        "info" => [
                            "data" => [
                                [
                                    "table" => "match_paired",
                                    "action" => "write_once",
                                    "set" => [
                                        "finder_id" => "__user_id",
                                        "receiver_id" => $userid,
                                        "matches_id" => "__id",
                                        "accept" => "pending",
                                    ],
                                    "unique_field" => [
                                        "finder_id", "receiver_id", "matches_id"
                                    ]
                                ],
                            ],
                            "modal" => [
                                "duplicate" => false,
                                "header" => "參加該課",
                                "defined" => true,
                                "button" => "參加",
                                "action" => "add",
                                "content" => "您確定要參加該課程嗎",
                                "message" => "成功加入",
                            ],
                        ],
                    ]
                ],
            ],
            "matches_details" => [
                "table_list" => false,
                "join" => [
                    "method" => "left outer",
                    "joints" => [
                        "users" => "matches.user_id = users.id",
                    ]
                ],
                "select" => [
                    "users" => ["username"],
                    "matches" => ["id", "user_id", "target", "location", "price", "purpose", "time", "subject", "date"]
                ],
                'where' => [
                    'availability' => '服務中',
                ],
                "filter" => [
                    "matches" => ["id", "user_id"],
                ],
            ],
            "users_details" => [
                "table_list" => false,
                "join" => [
                    "method" => "left outer",
                    "joints" => [
                        "user_profile" => "users.id = user_profile.user_id",
                        "user_member" => "users.id = user_member.user_id",
                    ]
                ],
                "select" => [
                    "users" => ['id', 'username', 'email', 'phone', 'rank'],
                    "user_profile" => ['full_name', 'gender'],
                    "user_member" => ['membership'],
                ],
                "filter" => ["users" => ['id', 'rank']],
                // 'where' => [
                //     'rank !=' => 'admin',
                // ],
                "buttons" => [
                    "edit" => [
                        "link" => "",
                        "button" => "edit",
                        "token" => "edit_token",
                        "info" => [
                            "data" => [
                                [
                                    "table" => "users",
                                    "action" => "edit",
                                    "where" => [
                                        "id" => "__id",
                                    ],
                                    "select" => [
                                        'username', 'email', 'phone',
                                        //  'password',
                                        'rank'
                                    ],
                                ],
                                [
                                    "table" => "user_profile",
                                    "action" => "edit",
                                    "where" => [
                                        "user_id" => "__id",
                                    ],
                                    "filter" => ["user_id", "updated", "created"],
                                ],
                                [
                                    "table" => "user_member",
                                    "action" => "edit",
                                    "where" => [
                                        "user_id" => "__id",
                                    ],
                                    "select" => ['membership'],
                                ],
                            ],
                            "modal" => [
                                "header" => "編輯",
                                "button" => "編輯",
                            ],
                        ],
                    ],
                    "delete" => [
                        "link" => "",
                        "button" => "delete",
                        "token" => "delete_token",
                        "info" => [
                            "data" => [
                                [
                                    "table" => "users",
                                    "action" => "delete",
                                    "where" => [
                                        "id" => "__id",
                                    ],
                                ],
                                [
                                    "table" => "user_profile",
                                    "action" => "delete",
                                    "where" => [
                                        "user_id" => "__id",
                                    ],
                                ],
                                [
                                    "table" => "users_member",
                                    "action" => "delete",
                                    "where" => [
                                        "user_id" => "__id",
                                    ],
                                ],
                            ],
                            "modal" => [
                                "header" => "刪除",
                                "button" => "刪除",
                            ],
                        ],
                    ],
                ]
            ],
            "classes_today" => [
                "table_list" => false,
                "join" => [
                    "method" => "left outer",
                    "joints" => [
                        "user_teacher" => "user_teacher.id = classes.teacher_id",
                    ]
                ],
                "select" => [
                    "classes" => [
                        "id",
                        ["column" => "start_date", "date" => "Y-m-d", "rename" => "date"],
                        ["column" => "start_date", "date" => "H:i", "rename" => "start_time"],
                        ["column" => "end_date", "date" => "H:i", "rename" => "end_time"],
                        ["column" => "name", "rename" => "course_name"],
                        "category",
                        "max_ppl",
                        ["count" => ["table" => "class_users", "where" => ["classes.id = class_users.class_id and class_users.status='active'"]], "rename" => "current_ppl"]
                    ],
                    "user_teacher" => [["column" => "name", "rename" => "teacher_name"]],
                ],
                "filter" => ["classes" => ['id']],
                "orderby" => ["start_date" => "ASC"],
                "where" => [
                    "start_date >" => $this->dtL->todayDate(),
                    "start_date <" => $this->dtL->tmrDate(),
                ],
                "buttons" => [
                    "edit" => [
                        "link" => "",
                        "button" => "edit",
                        "token" => "edit_token",
                        "info" => [
                            "data" => [
                                [
                                    "table" => $core_table,
                                    "action" => "edit",
                                    "where" => [
                                        "id" => "__id",
                                    ],
                                    "select" => ['name', 'category', 'room_id', 'description', 'teacher_id', 'max_ppl', 'start_date', 'end_date', 'price', 'date_color', 'status']
                                ],
                            ],
                            "modal" => [
                                "header" => "編輯",
                                "button" => "編輯",
                            ],
                        ],
                    ],
                ],
            ],
            "classes_future" => [
                "table_list" => false,
                "join" => [
                    "method" => "left outer",
                    "joints" => [
                        "user_teacher" => "user_teacher.id = classes.teacher_id",
                    ]
                ],
                "select" => [
                    "classes" => [
                        "id",
                        ["column" => "start_date", "date" => "Y-m-d", "rename" => "date"],
                        ["column" => "start_date", "date" => "H:i", "rename" => "start_time"],
                        ["column" => "end_date", "date" => "H:i", "rename" => "end_time"],
                        ["column" => "name", "rename" => "course_name"],
                        "category",
                        "max_ppl",
                        ["count" => ["table" => "class_users", "where" => ["classes.id = class_users.class_id and class_users.status='active'"]], "rename" => "current_ppl"]
                    ],
                    "user_teacher" => [["column" => "name", "rename" => "teacher_name"]],
                ],
                "filter" => ["classes" => ['id']],
                "orderby" => ["start_date" => "ASC"],
                "where" => [
                    "start_date >" => $this->dtL->todayDate(),
                ],
                "buttons" => [
                    "edit" => [
                        "link" => "",
                        "button" => "edit",
                        "token" => "edit_token",
                        "info" => [
                            "data" => [
                                [
                                    "table" => $core_table,
                                    "action" => "edit",
                                    "where" => [
                                        "id" => "__id",
                                    ],
                                    "select" => ['name', 'category', 'room_id', 'description', 'teacher_id', 'max_ppl', 'start_date', 'end_date', 'price', 'date_color', 'status']
                                ],
                            ],
                            "modal" => [
                                "header" => "編輯",
                                "button" => "編輯",
                            ],
                        ],
                    ],
                ],
            ],
            "classes_details" => [
                "table_list" => false,
                "join" => [
                    "method" => "left outer",
                    "joints" => [
                        "user_teacher" => "user_teacher.id = classes.teacher_id",
                    ]
                ],
                "select" => [
                    "classes" => [
                        "id",
                        ["column" => "start_date", "date" => "Y-m-d", "rename" => "date"],
                        ["column" => "start_date", "date" => "H:i", "rename" => "start_time"],
                        ["column" => "end_date", "date" => "H:i", "rename" => "end_time"],
                        ["column" => "name", "rename" => "course_name"],
                        "category",
                        "max_ppl",
                        ["count" => ["table" => "class_users", "where" => ["classes.id = class_users.class_id and class_users.status='active'"]], "rename" => "current_ppl"]
                    ],
                    "user_teacher" => [["column" => "name", "rename" => "teacher_name"]],
                ],
                "filter" => ["classes" => ['id']],
                "orderby" => ["start_date" => "ASC"],
                "buttons" => [
                    "edit" => [
                        "link" => "",
                        "button" => "edit",
                        "token" => "edit_token",
                        "info" => [
                            "data" => [
                                [
                                    "table" => $core_table,
                                    "action" => "edit",
                                    "where" => [
                                        "id" => "__id",
                                    ],
                                    "select" => ['name', 'category', 'room_id', 'description', 'teacher_id', 'max_ppl', 'start_date', 'end_date', 'price', 'date_color', 'status']
                                ],
                            ],
                            "modal" => [
                                "header" => "編輯",
                                "button" => "編輯",
                            ],
                        ],
                    ],
                ],
            ],
            "class_users_details" => [
                "table_list" => false,
                "join" => [
                    "method" => "left outer",
                    "joints" => [
                        "classes" => "class_users.class_id = classes.id",
                        "package_user" => "class_users.user_package_id = package_user.id",
                        "packages" => "packages.id = package_user.package_id",
                        "users" => "users.id = class_users.user_id",
                    ]
                ],
                "select" => [
                    "users" => [['column' => 'id', "rename" => "user_id"], 'username', 'email'],
                    "classes" => [['column' => "id", "rename" => "class_id"], ['column' => 'name', 'rename' => 'course_name'], "start_date", "end_date"],
                    "class_users" => ['id', 'type', 'status'],
                    "packages" => [['column' => "id", "rename" => "package_id"], ['column' => 'name', 'rename' => 'package_name'], 'category'],
                    "package_user" => ['tickets', 'expire_date'],
                ],
                "filter" => [
                    "users" => ['user_id'],
                    "classes" => ['class_id'],
                    "class_users" => ['id'],
                    "packages" => ['packages_id'],
                ],
            ],
            "class_history_details" => [
                "table_list" => false,
                "join" => [
                    "method" => "left outer",
                    "joints" => [
                        "users" => "class_history.user_id = users.id",
                        "classes" => "class_history.class_id = classes.id",
                    ]
                ],
                "select" => [
                    "users" => ['email'],
                    "classes" => [['column' => 'name', 'rename' => 'course_name']],
                    "class_history" => ['id', 'action'],
                ],
                "filter" => [
                    "class_history" => ['id'],
                ],
            ],
            "packages_details" => [
                "table_list" => false,
                "filter" => ['id', 'type', 'icon', 'icon_color', 'updated', 'created'],
                "buttons" => [
                    "edit" => [
                        "link" => "",
                        "button" => "edit",
                        "token" => "edit_token",
                        "info" => [
                            "data" => [
                                [
                                    "table" => $core_table,
                                    "action" => "edit",
                                    "where" => [
                                        "id" => "__id",
                                    ],
                                    "select" => ['name', 'type', 'category', 'alt_category', 'tickets', 'price', 'expire', 'description', 'comments']
                                ],
                            ],
                            "modal" => [
                                "header" => "編輯",
                                "button" => "編輯",
                            ],
                        ],
                    ],
                ],
            ],
            "package_user_details" => [
                "table_list" => false,
                "join" => [
                    "method" => "left outer",
                    "joints" => [
                        "users" => "package_user.user_id = users.id",
                        "packages" => "package_user.package_id = packages.id",
                    ]
                ],
                "select" => [
                    "users" => ["username"],
                    "packages" => [['column' => 'name', 'rename' => 'package_name'], 'category'],
                    "package_user" => ['id', 'tickets', 'expire_date', 'status'],
                ],
                "filter" => ["package_user" => ['id']],
            ],
            "package_history_details" => [
                "table_list" => false,
                "join" => [
                    "method" => "left outer",
                    "joints" => [
                        "users" => "package_history.user_id = users.id",
                        "packages" => "package_history.package_id = packages.id",
                    ]
                ],
                "select" => [
                    "users" => ['email'],
                    "packages" => [['column' => 'name', 'rename' => 'package_name'], 'category'],
                    "package_history" => ['id', 'action', 'tickets', 'value'],
                ],
                "filter" => [
                    "package_history" => ['id'],
                ],
            ],
            "user_teacher_details" => [
                "table_list" => false,
                "join" => [
                    "method" => "left outer",
                    "joints" => [
                        "users" => "user_teacher.user_id = users.id",
                    ]
                ],
                "select" => [
                    "users" => [['column' => 'id', 'rename' => 'user_id'], 'username', 'email'],
                    "user_teacher" => ['id', 'name', 'description'],
                ],
                "filter" => [
                    'users' => ['user_id'],
                    "user_teacher" => ['id'],
                ],
            ],
            'parent_child_details' => [
                "table_list" => false,
                'join' => [
                    'method' => 'left outer',
                    'joints' => [
                        'users u1' => 'parent_child.parent_id = u1.id',
                        'users u2' => 'parent_child.child_id = u2.id',
                    ]
                ],
                'select' => [
                    'u1' => [['column' => 'username', 'rename' => 'parent_name']],
                    'u2' => [['column' => 'username', 'rename' => 'child_name']],
                    'parent_child' => ['id', 'status']
                ],
                'filter' => [
                    'parent_child' => ['id']
                ]
            ],
            'match_paired_details' => [
                "table_list" => false,
                'join' => [
                    'method' => 'left outer',
                    'joints' => [
                        'users u1' => 'match_paired.receiver_id = u1.id',
                        'users u2' => 'match_paired.finder_id = u2.id',
                    ]
                ],
                'select' => [
                    'match_paired' => ['id', 'status'],
                    'u1' => [['column' => 'username', 'rename' => 'receiver_name']],
                    'u2' => [['column' => 'username', 'rename' => 'finder_name']],
                ],
                'filter' => [
                    'match_paired' => ['id'],
                ]
            ],
            "default" => [
                "select" => [],
                "join" => [],
                "keep" => [],
                "orderby" => [],
                'where' => [],
                "table_list" => true,
                "checkbox" => true,
                "filter" => [],
                "buttons" => [
                    "edit" => [
                        "link" => "",
                        "button" => "edit",
                        "token" => "edit_token",
                        "info" => [
                            "data" => [
                                [
                                    "table" => $core_table,
                                    "action" => "edit",
                                    "where" => [
                                        "id" => "__id",
                                    ],
                                ],
                            ],
                            "modal" => [
                                "header" => "編輯",
                                "button" => "編輯",
                            ],
                        ],
                    ],
                    "delete" => [
                        "link" => "",
                        "button" => "delete",
                        "token" => "delete_token",
                        "info" => [
                            "data" => [
                                [
                                    "table" => $core_table,
                                    "action" => "delete",
                                    "where" => [
                                        "id" => "__id",
                                    ],
                                ],
                            ],
                            "modal" => [
                                "header" => "刪除",
                                "button" => "刪除",
                            ],
                        ],
                    ],
                ],
                "format" => [
                    "default" => [
                        "start_date" => ["date" => "Y-m-d H:i"],
                        "end_date" => ["date" => "Y-m-d H:i"],
                    ]
                ],
            ]
        ];

        // Unlogged cases
        if (!isset($_SESSION['userid'])) :
            $custom_list['matches_show']['buttons']['apply'] = [];
        endif;

        // Get variables
        foreach (['join', 'where', 'select', 'buttons', 'keep', 'filter', 'format', 'orderby', 'table_list', 'checkbox'] as $item) :
            if (isset($custom_list[$table][$item])) :
                $$item = $custom_list[$table][$item];
            else :
                $$item = $custom_list['default'][$item];
            endif;
        endforeach;
        if (isset($format[$table])) :
            $current_format = $format[$table];
        else :
            $current_format = $format["default"];
        endif;

        // Where
        unset($_GET['anywhere']);
        unset($_GET['page']);
        unset($_GET['quantity']);
        unset($_GET['csrf_test_name']);
        // print_r($select);
        foreach ($_GET as $key => $value) :
            if ($value !== "") :
                $key = str_replace("__", ".", $key);
                $new_key = explode(".", $key);
                $current_table = reset($new_key);
                $current_column = end($new_key);
                $value = urldecode($value);
                if (in_array($key, ['price_from', 'price_under'])) :
                    if ($key == "price_from") :
                        $key = 'price >=';
                    elseif ($key == "price_under") :
                        $key = 'price <=';
                    endif;
                else :
                    if (strpos(json_encode($select), $current_column) !== false) :
                        if ($this->varL->is2darray($select)) :
                            if (isset($select[$current_table])) :
                                foreach ($select as $key => $thing) :
                                    foreach ($thing as $item) :
                                        if (is_string($item)) :
                                            $to_compare = $item;
                                        elseif (is_array($item)) :
                                            if (isset($item['rename'])) :
                                                $to_compare = $item['rename'];
                                            else :
                                                $to_compare = $item['column'];
                                            endif;
                                        endif;
                                        if ($to_compare == $current_column) :
                                            $result = $item;
                                            break;
                                        endif;
                                    endforeach;
                                endforeach;
                            endif;
                        else :
                            foreach ($select as $item) :
                                if (is_string($item)) :
                                    $to_compare = $item;
                                elseif (is_array($item)) :
                                    if (isset($item['rename'])) :
                                        $to_compare = $item['rename'];
                                    else :
                                        $to_compare = $item['column'];
                                    endif;
                                endif;
                                if ($to_compare == $current_column) :
                                    $result = $item;
                                    break;
                                endif;
                            endforeach;
                        endif;

                        if (is_string($result)) :
                            if (!empty($current_format[$result])) :
                                foreach ($current_format[$result] as $one => $two) :
                                    if ($one == "date") :
                                        $result = ["column" => $result, "date" => $two, "rename" => $result];
                                    endif;
                                endforeach;
                            endif;
                        endif;
                        if (is_string($result)) :
                            $key = $current_table . "." . $result;
                        elseif (is_array($result)) :
                            $column = $result['column'];
                            $key = $current_table . "." . $column;
                            if (isset($result['date'])) :
                                $date = $result['date'];
                                $new_date = $this->dtL->formatPercent($date);
                                $key = 'DATE_FORMAT(' . $key . ',"' . $new_date . '")';
                                $value = date($date, strtotime($value));
                            endif;
                        endif;
                    endif;
                endif;
                $where[$key] = $value;
            endif;
        endforeach;

        // Table params
        $data['params'] = [
            "data" => [
                "defined" => false,
                "table" => $core_table,
                "where" => $where,
                "additional" => [
                    "join" => $join,
                    "select" => $select,
                    "anywhere" => $anywhere,
                    "orderby" => $orderby,
                ],
                "translate" => true,
                "keep" => $keep,
                "filter" => $filter,
            ],
            "search" => [
                "pagination" => false,
                "value" => $anywhere,
                "table_list" => $table_list,
            ],
            "header" => [
                "options" => true,
                "checkbox" => $checkbox,
            ],
            "pagination" => [
                "page" => $page,
                "quantity" => $quantity,
            ],
            "result" => [
                "checkbox" => $checkbox,
                "pagination" => true,
                "allow_url" => true,
                "url" => [
                    "users" => [
                        "email" => "/user/details/__id",
                    ],
                    "class_users" => [
                        "email" => "/user/details/__user_id",
                        "course_name" => "/classes/class/__class_id",
                        "package_name" => "/util/chart/packages_details?id=__package_id",
                    ],
                    "classes" => [
                        "course_name" => "/classes/class/__id",
                        "name" => "/classes/class/__id",
                    ],
                    "matches" => [
                        "username" => "/user/profile/__user_id",
                    ],
                    "package_user" => [
                        "username" => "/user/details/__user_id",
                    ],
                    "posts" => [
                        "title" => "/util/editor/__id",
                    ],
                    'user_teacher' => [
                        "email" => "/user/profile/__user_id",
                    ]
                ],
                "actions" => [
                    "name" => "行動",
                    "buttons" => $buttons,
                ],
                "format" => $format,
            ]
        ];

        // print_r($data['params']);

        // Add button
        $add_list = [
            "users_details" => [
                "data" => [
                    [
                        "table" => "users",
                        "action" => "add",
                        "select" => ['username', 'email', 'password', 'phone', 'rank'],
                    ],
                    [
                        "table" => "user_profile",
                        "action" => "add",
                        "set" => [
                            "user_id" => "_firstAffectedID",
                        ],
                    ],
                    [
                        "table" => "user_member",
                        "action" => "add",
                        "set" => [
                            "user_id" => "_firstAffectedID",
                        ],
                        "select" => ['membership'],
                    ],
                ],
                "modal" => [
                    "header" => "添加會員",
                    "button" => "添加",
                ],
            ],
            "classes_today" => [
                "data" => [
                    [
                        "table" => "classes",
                        "action" => "add",
                        "set" => [
                            "status" => "active",
                        ],
                        "select" => ['name', 'category', 'room_id', 'description', 'teacher_id', 'max_ppl', 'start_date', 'end_date', 'price', 'date_color'],
                    ],
                ],
                "modal" => [
                    "header" => "添加",
                    "button" => "添加",
                    'required' => true,
                ],
            ],
            "classes_future" => [
                "data" => [
                    [
                        "table" => "classes",
                        "action" => "add",
                        "set" => [
                            "status" => "active",
                        ],
                        "select" => ['name', 'category', 'room_id', 'description', 'teacher_id', 'max_ppl', 'start_date', 'end_date', 'price', 'date_color'],
                    ],
                ],
                "modal" => [
                    "header" => "添加",
                    "button" => "添加",
                    'required' => true,
                ],
            ],
            "classes_details" => [
                "data" => [
                    [
                        "table" => "classes",
                        "action" => "add",
                        "set" => [
                            "status" => "active",
                        ],
                        "select" => ['name', 'category', 'room_id', 'description', 'teacher_id', 'max_ppl', 'start_date', 'end_date', 'price', 'date_color'],
                    ],
                ],
                "modal" => [
                    "header" => "添加",
                    "button" => "添加",
                    'required' => true,
                ],
            ],
            "package_user_details" => [
                "data" => [
                    [
                        "table" => "package_user",
                        "action" => "add",
                    ]
                ],
                "modal" => [
                    "header" => "添加",
                    "button" => "添加",
                ],
                "extra" => [
                    "target" => "/package/addUser",
                ]
            ],
            "packages_details" => [
                "data" => [
                    [
                        "table" => "packages",
                        "action" => "add",
                        "select" => ['name', 'type', 'category', 'alt_category', 'tickets', 'price', 'expire', 'description', 'comments'],
                    ]
                ],
                "modal" => [
                    "header" => "添加",
                    "button" => "添加",
                ],
            ],
            "default" => [
                "data" => [
                    [
                        "table" => $core_table,
                        "action" => "add"
                    ]
                ],
                "modal" => [
                    "header" => "添加",
                    "button" => "添加",
                ],
            ]
        ];
        if (isset($add_list[$table])) :
            $params = $add_list[$table];
        else :
            $params = $add_list['default'];
        endif;
        $data['add_token'] = $this->tokenM->getNumber($params);

        return $data;
    }
    public function fullparams($params)
    {
        $def_params = [
            "data" => [
                "table" => "classes",
                "result" => [],
                "org_result" => [],
                "raw_data" => [],
                "where" => [],
                "additional" => [],
                "twod_result" => [],
                "defined" => false,
                "filter" => [],
                "keep" => [],
                "columns" => [],
                "order" => [],
                "displays" => [],
                "translate" => true,
            ],

            "bootstrap" => [
                "class" => [
                    "table" => true,
                    "table-dark" => false,
                    "table-light" => false,
                    "table-striped" => true,
                    "table-bordered" => true,
                    "table-hover" => true,
                    "table-sm" => true,
                    "table-responsive" => "",
                    "overflow-auto" => true,
                ],
                "attr" => [
                    "data-toggle" => false,
                    "data-pagination" => false,
                    "data-search" => false,
                    "cell-padding" => 0,
                    "width" => "100%",
                ],
                "others" => [
                    "table-caption" => "",
                ]
            ],

            "pagination" => [
                "page" => 1,
                "quantity" => 10,
                "limit" => 10,
                "offset" => 0,
                "showall" => false,
            ],

            "search" => [
                "table_list" => true,
                "pagination" => false,
                "placeholder" => "Search here ...",
                "value" => "",
                "search_bar" => true,
                "search_btn" => true,
                "reset_btn" => true,
                "reset_url" => strtok($_SERVER["REQUEST_URI"], '?'),
            ],

            "header" => [
                "checkbox" => true,
                "options" => true,
                "exist" => false,
                "keep" => [],
                "filter" => [],
                "display" => [],
                "color" => "light",
            ],

            "result" => [
                "url" => [],
                "allow_url" => true,
                "checkbox" => true,
                "pagination" => true,
                "min-height" => true,
                "manual_actions" => false,
                "actions" => [
                    "name" => "Manage",
                    "buttons" => [
                        "edit" => [
                            "link" => "",
                            "button" => "edit",
                            "token" => "edit_token",
                            "info" => [
                                "data" => [
                                    [
                                        "table" => "__table",
                                        "action" => "edit",
                                        "where" => [
                                            "id" => "__id",
                                        ],
                                    ],
                                ],
                                "modal" => [
                                    "header" => "Edit record",
                                ],
                            ],
                        ],
                        "delete" => [
                            "link" => "",
                            "button" => "delete",
                            "token" => "delete_token",
                            "info" => [
                                "data" => [
                                    [
                                        "table" => "__table",
                                        "action" => "delete",
                                        "where" => [
                                            "id" => "__id",
                                        ],
                                    ],
                                ],
                                "modal" => [
                                    "header" => "Delete record",
                                ],
                            ],
                        ],
                    ]
                ],
                "format" => [
                    "default" => [
                        "start_date" => ["date" => "Y-m-d H:i"],
                        "end_date" => ["date" => "Y-m-d H:i"],
                    ]
                ],
            ],
        ];
        // print_r($params['result']['actions']);
        if (isset($params['result']['actions']['buttons']['edit'])) :
            $def_params['result']['actions']['buttons']['edit'] = [];
            if (count($params['result']['actions']['buttons']['edit']) == 0) :
                $def_params['result']['actions']['buttons']['edit'] = [];
            endif;
        endif;
        if (isset($params['result']['actions']['buttons']['delete'])) :
            $def_params['result']['actions']['buttons']['delete'] = [];
            if (count($params['result']['actions']['buttons']['delete']) == 0) :
                $def_params['result']['actions']['buttons']['delete'] = [];
            endif;
        endif;
        $params = array_replace_recursive($def_params, $params);
        // print_r($params['result']['actions']);
        // print_r($params);
        return $params;
    }
    public function minparams($params)
    {
        $def_params = [
            "data" => [
                "table" => "",
                "result" => [],
                "org_result" => [],
                "raw_data" => [],
                "where" => [],
                "additional" => [],
                "twod_result" => [],
                "defined" => false,
                "filter" => [],
                "keep" => [],
                "columns" => [],
                "order" => [],
                "displays" => [],
                "translate" => false,
            ],

            "bootstrap" => [
                "class" => [
                    "table" => true,
                    "table-dark" => false,
                    "table-light" => false,
                    "bg-white" => true,
                    "table-striped" => true,
                    "table-bordered" => true,
                    "table-hover" => true,
                    "table-sm" => true,
                    "table-responsive" => "",
                    "overflow-auto" => true,
                ],
                "attr" => [
                    "data-toggle" => false,
                    "data-pagination" => false,
                    "data-search" => false,
                    "cell-padding" => 0,
                    "width" => "100%",
                ],
                "others" => [
                    "table-caption" => "",
                ]
            ],

            "pagination" => [
                "page" => 1,
                "quantity" => 10,
                "limit" => 10,
                "offset" => 0,
                "showall" => true,
            ],

            "search" => [
                "table_list" => false,
                "pagination" => false,
                "placeholder" => "Search here ...",
                "value" => "",
                "search_bar" => false,
                "search_btn" => false,
                "reset_btn" => false,
                "reset_url" => strtok($_SERVER["REQUEST_URI"], '?'),
            ],

            "header" => [
                "checkbox" => false,
                "options" => false,
                "exist" => false,
                "keep" => [],
                "filter" => [],
                "display" => [],
                "color" => "light",
            ],

            "result" => [
                "url" => [],
                "allow_url" => false,
                "checkbox" => false,
                "pagination" => false,
                "min-height" => false,
                "actions" => [],
                "format" => [],
            ],
        ];
        $params = array_replace_recursive($def_params, $params);
        // print_r($params);
        return $params;
    }
    public function full($params = [])
    {
        $params = $this->fullparams($params);
        $params = $this->data_pagination($params);
        $params = $this->actions($params);
        $params = $this->columns($params);
        $this->logic($params);
    }
    public function min($params = [])
    {
        $params = $this->minparams($params);
        $params = $this->actions($params);
        $params = $this->columns($params);
        $this->logic($params);
    }
    public function actions($params)
    {
        $actions = $params["result"]["actions"];
        $table = $params["data"]["table"];
        $count = 0;
        foreach ($params["data"]["result"] as $item) :
            if (isset($actions["buttons"]) && count($actions["buttons"]) > 0) :
                foreach ($actions["buttons"] as $key => $thing) :
                    if (!empty($thing['token'])) :
                        $token_params = $thing["info"];
                        $token_name = $thing["token"];
                        $params["data"]["filter"] = $this->varL->array_once($params['data']['filter'], $token_name);
                        // $org_result = $params['data']['org_result'];
                        $token_params = json_encode($token_params);
                        $token_params = $this->replaceVar($table, $item, $token_params);
                        $token_params = json_decode($token_params, true);
                        $params["data"]["result"][$count]->$token_name = $this->tokenM->getNumber($token_params);
                    endif;
                endforeach;
            endif;
            $count += 1;
        endforeach;
        $params["data"]["raw_data"] = $this->varL->array_clone($params["data"]["result"]);
        return $params;
    }
    public function logic($params)
    {
        $this->formOpenTag($params);
        $this->searchBar($params);
        if (count($params["data"]["result"]) > 0) :
            $this->tableOpenTag($params);
            $this->headings($params);
            $this->result($params);
            $this->tableCloseTag();
        else :
            echo "<small>沒有結果</small>";
        endif;
        $this->bottom_pagination($params);
        $this->formCloseTag();
    }
    public function data_pagination($params)
    {
        if (empty($params['data']['where'])) :
            $params['data']['where'] = [];
        endif;

        // Get params
        $page_params = $params["pagination"];
        $data_params = $params["data"];

        // Get a copy just in case and for total number of pages
        $additional = $data_params['additional'];
        unset($additional['offset']);
        unset($additional['limit']);
        $data_params["org_result"] = $this->dbL->whereRows($data_params["table"], $data_params["where"], $additional);

        // Show all vs pagination
        if (!$page_params["show_all"]) :
            $page = $page_params["page"];
            $per = $page_params["quantity"];
            $page_params["total"] = $total = count($data_params["org_result"]);
            $page_params["possible_pages"] = ceil($total / $per);
            if ($page > $total) :
                $page_params["page"] = $page = 1;
            endif;
            $page = $page_params["page"];
            $data_params["additional"]["offset"] = $page_params["offset"] = ($page - 1) * $per;
            $data_params["additional"]["limit"] = $page_params["limit"] = $per;
        endif;

        // Query for developer if no result is given
        if (count($data_params["result"]) == 0) :
            $result = $this->dbL->whereRows(
                $data_params["table"],
                $data_params["where"],
                $data_params["additional"]
                // , true
            );
            // print_r($result);
            // exit;
            $count = 0;
            foreach ($result as $item) :
                foreach ($item as $key => $value) :
                    $result[$count]->$key = $this->varL->decodeIfJson($result[$count]->$key);
                endforeach;
                $count += 1;
            endforeach;
            $data_params["result"] = $result;
        else :
            $data_params["defined"] = true;
        endif;

        // Return params
        $params["pagination"] = $page_params;
        $params["data"] = $data_params;
        return $params;
    }
    public function searchBar($params)
    {
        $search_params = $params["search"];
        $table = $params["data"]["table"];
        $table_list = $this->dbL->listTables();
        if (in_array(true, $search_params)) :
?>
            <div class="input-group mb-2">
                <?php

                if ($search_params["pagination"] || $search_params["table_list"]) :
                ?>
                    <div class="input-group-prepend">
                        <?php
                        if ($search_params["table_list"]) :
                        ?>
                            <select name="" title="Tables" onchange="location = this.value;">
                                <option data-hidden="true">Tables</option>
                                <optgroup label="Main">
                                    <option value="/util/search">Clear</option>
                                    <?php
                                    foreach ($table_list as $table_name) {
                                        if ($params['data']['translate']) :
                                            $table_display = $this->translateM->getWord("zh-hk", $table_name);
                                        else :
                                            $table_display = $table_name;
                                        endif;
                                    ?>
                                        <option <?php
                                                if ($table == $table_name) :
                                                    echo "selected";
                                                endif; ?> value='<?php echo dirname($_SERVER['REQUEST_URI']) . "/$table_name"; ?>'><?php echo ucfirst($table_display); ?></option>
                                    <?php
                                    }
                                    ?>
                                </optgroup>
                            </select>
                        <?php
                        endif;
                        if ($search_params["pagination"]) :
                            $page_params = $params["pagination"];
                            $page = $page_params["page"];
                        ?>
                            <select name="page" title="Page" id="" onchange="this.form.submit();">
                                <?php
                                for ($i = 1; $i <= $page_params["possible_pages"]; $i++) :
                                ?>
                                    <option value="<?php echo $i; ?>" <?php if ($page == $i) : echo "selected";
                                                                        endif; ?>><?php echo $i; ?></option>
                                <?php
                                endfor;
                                ?>
                            </select>
                        <?php
                        endif;
                        ?>
                    </div>
                <?php
                endif;
                if ($search_params["search_bar"]) :
                ?>
                    <input type="text" class="form-control" name="anywhere" value="<?php echo $search_params["value"]; ?>" placeholder="<?php echo $search_params["placeholder"]; ?>">
                <?php
                endif;
                if ($search_params["search_btn"] || $search_params["reset_btn"]) :
                ?>
                    <div class="input-group-append">
                        <?php
                        if ($search_params["search_btn"]) :
                        ?>
                            <button class="btn btn-success" type="submit">搜索</button>
                        <?php
                        endif;
                        ?>
                        <?php
                        if ($search_params["reset_btn"]) :
                        ?>
                            <a href="<?php echo $search_params["reset_url"]; ?>" class="btn btn-danger">重設</a>
                        <?php
                        endif;
                        ?>
                    </div>
                <?php
                endif;
                ?>
            </div>
        <?php
        endif;
    }
    public function tableOpenTag($params)
    {
        // Classes
        $class_list = $params["bootstrap"]["class"];
        $class_stor = [];
        foreach ($class_list as $key => $value) :
            if ($value) :
                array_push($class_stor, $key);
            endif;
        endforeach;
        $class_attr = implode(" ", $class_stor);

        // Attributes
        $attr_list = $params["bootstrap"]["attr"];
        $attr_stor = [];
        foreach ($attr_list as $key => $value) :
            if (is_bool($value)) :
                if ($value) :
                    $value = "true";
                else :
                    $value = "false";
                endif;
            elseif (is_string($value)) :
            endif;
            array_push($attr_stor, "$key='$value'");
        endforeach;
        $elem_attr = implode(" ", $attr_stor);

        // Others
        $others_list = $params["bootstrap"]["others"];
        ?>
        <div class="overflow-auto my-2" <?php if ($params['result']['min-height']) : echo 'style="min-height:60vh;"';
                                        endif; ?>>
            <table class="<?php echo $class_attr; ?>" <?php echo $elem_attr; ?> style="white-space: nowrap;">
                <?php
                if (!empty($others_list["caption"])) :
                ?>
                    <caption><?php echo $others_list["caption"]; ?></caption>
                <?php
                endif;
            }
            public function tableCloseTag()
            {
                ?>
            </table>
        </div>
    <?php
            }
            public function formOpenTag($params)
            {
    ?>
        <form action="">
        <?php
            }
            public function formCloseTag()
            {
        ?>
        </form>
    <?php
            }
            public function columns($params)
            {
                $data = $params["data"]["result"];
                $table = $params["data"]["table"];
                $header_keep = count($params["header"]["keep"]) > 0;

                // All or Select Columns
                if ($header_keep) :
                    $columns = $params["header"]["keep"];
                else :
                    // Get the remaining data columns
                    $columns = $this->varL->twod_array_columns($data);
                    // Simple filtering defined by users
                    if (count($params["data"]["filter"]) > 0) :
                        $filter = $params["data"]["filter"];
                        if ($this->varL->is2darray($filter)) :
                            $filter = $this->varL->flattenArray($filter);
                        endif;
                        $data = $this->varL->twodarrayobjectFilter($data, $filter);
                        $columns = $this->varL->twod_array_columns($data);
                    endif;
                    // print_r($columns);

                    // Defined is show table columns only, excluding tokens
                    if ($params["data"]["defined"]) :
                        $columns = $this->varL->arrayValueKeep($columns, $this->dbL->fieldsTable($table));
                    endif;

                    // Order is user defined therefore highest priority
                    if (count($params["data"]["order"]) > 0) :
                        $columns = $params["data"]["order"];
                    endif;
                endif;
                $params["data"]["columns"] = $columns;
                if (count($params["data"]["displays"]) == 0) :
                    $params["data"]["displays"] = $columns;
                endif;
                return $params;
            }
            public function headings($params)
            {
                $table = $params["data"]["table"];
                $header_keep = count($params["header"]["keep"]) > 0;

                $columns = $params["data"]["columns"];
                $displays = $params["data"]["displays"];


                // Column dropdown
                if ($params["header"]["options"]) :
                    $dropdown_list = [];
                    if (isset($params["data"]["additional"]["select"]) && count($params["data"]["additional"]["select"]) > 0 && isset($params["data"]["additional"]["join"]) && count($params["data"]["additional"]["join"]) > 0) :
                        $select = $params["data"]["additional"]["select"];
                        $filter = $params['data']['filter'];
                        $filter = $this->varL->flattenArray($filter);
                        if (isset($params['result']['format'][$table])) :
                            $format = $params['result']['format'][$table];
                        else :
                            $format = $params['result']['format']["default"];
                        endif;
                        // With join it has to be associative
                        foreach ($select as $key => $value) :
                            $count = 0;
                            foreach ($value as $item) :
                                if (is_string($item)) :
                                    $to_compare = $item;
                                elseif (is_array($item)) :
                                    if (!empty($item['rename'])) :
                                        $to_compare = $item['rename'];
                                    else :
                                        $to_compare = $item['column'];
                                    endif;
                                endif;
                                if (in_array($to_compare, $filter)) :
                                    unset($select[$key][$count]);
                                endif;
                                if (isset($format[$to_compare])) :
                                    foreach ($format[$to_compare] as $process => $thing) :
                                        if ($process == "date") :
                                            $select[$key][$count] = ['column' => $to_compare, 'date' => $thing, 'rename' => $to_compare];
                                        endif;
                                    endforeach;
                                endif;
                                $count += 1;
                            endforeach;
                            $select[$key] = array_values($select[$key]);
                        endforeach;
                        $displays = $this->varL->arrayValueFilter($displays, $filter);
                        $displays = array_values($displays);
                        $join = $params["data"]["additional"]["join"];
                        $count = 0;
                        foreach ($select as $key => $value) :
                            foreach ($value as $item) :
                                // This is based on our core table, then inner join, so $table. You cannot inner join yourself
                                if (is_string($item)) :
                                    $column = $key . "." . $item;
                                    // print_r(["select" => [$column], "join" => $join, "groupby" => $column]);
                                    $groups = $this->dbL->whereRows($table, $params['data']['where'], ["select" => [$column], "join" => $join, "groupby" => $column]);
                                    $inner_list = $this->varL->column_result($groups, $item);
                                    $column = $item;
                                elseif (is_array($item)) :
                                    $column = $key . "." . $item['column'];
                                    if (isset($item['date'])) :
                                        $date = $item['date'];
                                        $new_date = $this->dtL->formatPercent($date);
                                        $column = 'DATE_FORMAT(' . $column . ',"' . $new_date . '")';
                                    endif;
                                    if (isset($item['rename'])) :
                                        $rename = $title = $item['rename'];
                                        $column .= " as $rename";
                                    endif;
                                    $groups = $this->dbL->whereRows($table, $params['data']['where'], ["select" => [$column], "join" => $join, "groupby" => $rename]);
                                    $inner_list = $this->varL->column_result($groups, $rename);
                                    $column = $rename;
                                endif;
                                $inner_list = array_filter($inner_list);
                                $inner_list = array_values($inner_list);
                                if ($header_keep) :
                                    $column = $params["header_display"][$count];
                                endif;
                                $title = $displays[$count];
                                // echo $title;
                                if ($params["data"]["translate"]) :
                                    // $column = $title;
                                    if ($title == "name") :
                                        if (substr($table, -1) == "s") :
                                            $new_table = substr($table, 0, -1);
                                        else :
                                            $new_table = $table;
                                        endif;
                                        $title = $new_table . "_" . $title;
                                    endif;
                                    $title = $this->translateM->getWord("zh-hk", $title);
                                endif;
                                array_push($dropdown_list, [
                                    "column" => $key . "__" . $column,
                                    "title" => $title,
                                    "list" => $inner_list,
                                ]);
                                $count += 1;
                            endforeach;
                        endforeach;
                    // exit;
                    // print_r($dropdown_list);
                    else :
                        $count = 0;
                        $select_params = $this->varL->arrayValueFilter($params['data']['additional']['select'], $params['data']['filter']);
                        $select_params = array_values($select_params);
                        foreach ($columns as $column) :
                            $select_column = $select_params[$count];
                            if (is_array($select_column)) :
                                $column = $select_column['column'];
                                if (isset($select_column['date'])) :
                                    $date = $select_column['date'];
                                    $new_date = $this->dtL->formatPercent($date);
                                    $column = 'DATE_FORMAT(' . $column . ',"' . $new_date . '")';
                                endif;
                                if (isset($select_column['rename'])) :
                                    $rename = $title = $select_column['rename'];
                                    $column .= " as $rename";
                                endif;
                                $groups = $this->dbL->whereRows($table, [], [
                                    "groupby" => $rename, "select" => [$column],
                                ]);
                                $inner_list = $this->varL->column_result($groups, $rename);
                                $column = $rename;
                            else :
                                $groups = $this->dbL->whereRows($table, [], [
                                    "groupby" => $column, "select" => [$column],
                                ]);
                                $inner_list = $this->varL->column_result($groups, $column);
                            endif;
                            $inner_list = array_filter($inner_list);
                            $inner_list = array_values($inner_list);
                            if ($header_keep) :
                                $column = $params["header_display"][$count];
                            endif;
                            $title = $displays[$count];
                            if ($params["data"]["translate"]) :
                                // $column = $title;
                                if ($title == "name") :
                                    if (substr($table, -1) == "s") :
                                        $new_table = substr($table, 0, -1);
                                    else :
                                        $new_table = $table;
                                    endif;
                                    $title = $new_table . "_" . $title;
                                endif;
                                $title = $this->translateM->getWord("zh-hk", $title);
                            endif;
                            array_push($dropdown_list, [
                                "column" => $table . "__" . $column,
                                "title" => $title,
                                "list" => $inner_list
                            ]);
                            $count += 1;
                        endforeach;
                    // print_r($dropdown_list);
                    endif;
                endif;
                // print_r($dropdown_list);
                // exit;
    ?>
        <thead class="thead-light">
            <?php
                if ($params["header"]["checkbox"]) :
            ?>
                <td class="active p-0 pl-2 pt-1">
                    <span class="custom-checkbox">
                        <input type="checkbox" id="selectAll" class="select-all checkbox" name="select-all">
                        <label for="selectAll"></label>
                    </span>
                </td>
            <?php
                endif;
            ?>
            <?php
                if ($params["header"]["options"]) :
                    foreach ($dropdown_list as $dropdown) :
                        $column = $dropdown['column'];
                        $real_column = explode('__', $column);
                        if (count($real_column) > 1) :
                            $real_column = $real_column[1];
                        else :
                            $real_column = $column;
                        endif;
                        $title = $dropdown['title'];
            ?>
                    <td class="p-0">
                        <!-- <div class="row px-3">
                            <div class="col-2 m-0 p-0 justify-content-center text-center">
                                <i class="fas fa-sort"></i>
                            </div>
                            <div class="col-10 m-0 p-0"> -->
                        <?php
                        if ($real_column == 'price') :
                            if ($params['data']['translate']) :
                                $real_column = $this->translateM->getWord('zh-hk', $real_column);
                            endif;
                            $price_from = $this->varL->getVar([
                                "name" => "price_from",
                                "default" => 200,
                                "source" => "get",
                                "empty" => false,
                            ]);
                            $price_under = $this->varL->getVar([
                                "name" => "price_under",
                                "default" => 600,
                                "source" => "get",
                                "empty" => false,
                            ]);
                        ?>
                            <div class="dropdown">
                                <button class="btn btn-light dropdown-toggle form-control text-left" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?php echo $real_column; ?>
                                </button>
                                <div class="dropdown-menu px-2">
                                    <div class="form-group">
                                        <label for="exampleDropdownFormEmail1" class="d-flex">價錢大於:<div id='price_from' class="px-1"><?php echo $price_from; ?></div></label>
                                        <input name="price_from" type="range" min="0" max="1000" step="50" value="<?php echo $price_from; ?>" class="form-control-range" id="exampleDropdownFormEmail1" oninput="updatePriceFrom(this.value);">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleDropdownFormPassword1" class="d-flex">價錢低於:<div id='price_under' class="px-1"><?php echo $price_under; ?></div></label>
                                        <input name="price_under" type="range" min="0" max="1000" step="50" value="<?php echo $price_under; ?>" class="form-control-range" id="exampleDropdownFormPassword1" oninput="updatePriceUnder(this.value);">
                                    </div>
                                    <button type="submit" class="btn btn-primary">搜索</button>
                                </div>
                                <script>
                                    function updatePriceFrom(val) {
                                        document.getElementById('price_from').innerHTML = val;
                                    }

                                    function updatePriceUnder(val) {
                                        document.getElementById('price_under').innerHTML = val;
                                    }
                                </script>
                            </div>
                        <?php
                        else :
                        ?>
                            <select class="m-0" title="<?php echo $title; ?>" name="<?php echo $column; ?>" onchange="this.form.submit()" data-style="btn-white" data-size="5" data-container="body">
                                <!-- <option data-hidden="true"><?php echo $column; ?></option> -->
                                <option value="">Clear</option>
                                <?php
                                foreach ($dropdown['list'] as $list_item) {
                                ?>
                                    <option <?php
                                            if (urldecode($_GET[$column]) == $list_item) :
                                                echo "selected";
                                            endif; ?> value='<?php echo urlencode($list_item); ?>'><?php echo $this->translateM->getWord("zh-hk", $list_item); ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        <?php
                        endif;
                        ?>
                        <!-- </div>
                        </div> -->
                    </td>
                    <?php
                    endforeach;
                else :
                    if ($params["data"]["translate"]) :
                        foreach ($displays as $display) :
                    ?>
                        <td class="font-weight-bold px-2">
                            <?php echo $this->translateM->getWord("zh-hk", $display); ?>
                        </td>
                    <?php
                        endforeach;
                    else :
                        foreach ($displays as $display) :
                    ?>
                        <td class="font-weight-bold px-2">
                            <?php echo $display; ?>
                        </td>
            <?php
                        endforeach;
                    endif;
                endif;
            ?>
            <?php
                if (isset($params["result"]["actions"]["buttons"])) :
                    if ($params["header"]["options"]) :
            ?>
                    <td data-field="action" class="text-center pt-2"><?php echo $params["result"]["actions"]["name"]; ?></td>
                <?php
                    else :
                ?>
                    <td data-field="action" class="font-weight-bold text-center pt-2"><?php echo $params["result"]["actions"]["name"]; ?></td>
            <?php
                    endif;
                endif;
            ?>
        </thead>
    <?php
            }
            public function result($params)
            {
                if (isset($params["data"]["table"])) :
                    $table = $params["data"]["table"];
                endif;
    ?>
        <tbody>
            <?php
                $i = 1;
                $count = 0;
                foreach ($params["data"]["result"] as $item) :
                    $raw_item = $params["data"]["raw_data"][$count];
            ?>
                <tr>
                    <?php
                    if ($params["result"]["checkbox"]) :
                    ?>
                        <td class="active">
                            <span class="custom-checkbox p-1">
                                <input type="checkbox" class="select-item checkbox" id="checkbox<?php echo $i; ?>" name="options" value="<?php echo $i; ?>" data-id="action[]" data-name="<?php echo $item->id; ?>">
                                <label for="checkbox<?php echo $i; ?>"></label>
                            </span>
                        </td>
                    <?php
                    endif;
                    ?>
                    <?php
                    // print_r($params);
                    if (isset($params['result']['format'][$table])) :
                        $format = $params['result']['format'][$table];
                    elseif (isset($params['result']['format']["default"])) :
                        $format = $params['result']['format']["default"];
                    else :
                        $format = [];
                    endif;
                    foreach ($params["data"]["columns"] as $key) :
                        $no_url = false;
                        if ($params['result']['allow_url']) :
                            if (isset($params["result"]["url"][$table][$key])) :
                                $result_url = $params["result"]["url"][$table][$key];
                            elseif (isset($params['result']['url']['default']) && array_key_first($params['result']['url']['default']) == $key) :
                                $result_url = reset($params["result"]["url"]["default"]);
                            else :
                                $no_url = true;
                            endif;
                        else :
                            $no_url = true;
                        endif;
                        if (isset($format[$key])) :
                            foreach ($format[$key] as $process => $thing) :
                                if ($process == "date") :
                                    $item->$key = date($thing, strtotime($item->$key));
                                endif;
                            endforeach;
                        endif;

                        $str_limit = 80;
                        if (strlen($item->$key) > $str_limit) :
                            $item->$key = substr($item->$key, 0, $str_limit) . "...";
                        endif;
                        if ($params['data']['translate']) :
                            $item->$key = $this->translateM->getWord("zh-hk", $item->$key);
                        endif;

                        if ($no_url) :
                    ?>
                            <td><?php echo $item->$key; ?></td>
                        <?php
                        else :
                            $raw_item = $params["data"]["raw_data"][$count];
                            $result_url = $this->replaceVar($table, $raw_item, $result_url);
                            // target="_blank"
                        ?>
                            <td><a href="<?php echo $result_url; ?>"><?php echo $item->$key; ?></a></td>
                        <?php
                        endif;
                    endforeach;
                    if (isset($params["result"]["actions"]["buttons"])) :
                        ?>
                        <td class="text-center justify-content-center">
                            <?php
                            foreach ($params["result"]["actions"]["buttons"] as $thing) :
                                if (count($thing) > 0) :
                                    $hide = false;
                                    if (isset($thing['hideif'])) :
                                        foreach ($thing['hideif'] as $key => $value) :
                                            if ($key == "equal") :
                                                $one = array_key_first($value);
                                                $two = current($value);
                                                if ($item->$one == $two) :
                                                    $hide = true;
                                                endif;
                                            endif;
                                        endforeach;
                                    endif;
                                    if (!$hide) :
                                        # Link
                                        if (is_string($thing["link"])) :
                                            $link = $thing["link"];
                                        elseif (is_array($thing["link"])) :
                                            foreach ($thing["link"] as $key => $value) :
                                                $link = $key . $item->{$value};
                                            endforeach;
                                        endif;
                                        $raw_item = $params["data"]["raw_data"][$count];
                                        $link = $this->replaceVar($table, $raw_item, $link);

                                        # Button
                                        $button = $thing["button"];

                                        # Token
                                        if ($thing["token"] !== "") :
                                            $token = $raw_item->{$thing["token"]};
                                        else :
                                            $token = $thing["token"];
                                        endif;
                                        $this->widgetL->btn([
                                            "action" => $button,
                                            "link" => $link,
                                            "token" => $token,
                                            "text" => ""
                                        ]);
                                    endif;
                                endif;
                            endforeach;
                            ?>
                        </td>
                    <?php
                    endif;
                    ?>
                </tr>
            <?php
                    $i += 1;
                    $count += 1;
                endforeach;
            ?>
        </tbody>
<?php
            }
            public function bottom_pagination($params)
            {
                if ($params["result"]["pagination"]) :
                    $page_params = $params["pagination"];
                    $this->widgetL->pagination([
                        "page" => $page_params["page"],
                        "total" => $page_params["possible_pages"],
                        "quantity" => $page_params["quantity"],
                    ]);
                endif;
            }

            public function replaceVar($table, $raw_item, $var)
            {
                $var = str_replace("__table", $table, $var);
                $var_list = ["id", "user_id", "teacher_id", "parent_id", "child_id", "class_id", "course_id", "package_id"];
                foreach ($var_list as $item) :
                    $var = str_replace("__$item", $raw_item->$item, $var);
                endforeach;
                return $var;
            }
        }
