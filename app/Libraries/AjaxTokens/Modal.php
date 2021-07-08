<?php

namespace App\Libraries\AjaxTokens;

class Modal
{
    public function __construct()
    {
        $this->model = new \App\Models\AjaxToken();
        $this->stringL = new \App\Libraries\stringLib();
    }
    public function setupAdd($params)
    {
        // Empty data when adding and data not defined
        $table = $params['table'];
        $action = $params['action'];
        $data = $params['data'];
        $fields = $this->dbL->fieldsTable($table);
        if ($action == 'add' && count($data) == 0) :
            $params['data'] = $this->varL->emptyColumn($fields);
        elseif (count($data) > 1) :
            $new_data = [];
            foreach ($fields as $field) :
                if (isset($data[$field])) :
                    $new_data[$field] = $data[$field];
                else :
                    $new_data[$field] = '';
                endif;
            endforeach;
            $params['data'] = $new_data;
        endif;
        return $params;
    }
    public function setupData($params)
    {
        $action = $params['action'];
        $table = $params['table'];
        $select = $params['select'];
        $where = $params['where'];
        if (in_array($action, ['update', 'insert', 'edit', 'view'])) :
            $result = $this->dbL->whereRows($table, $where, ["select" => $select]);
        endif;
    }
}
