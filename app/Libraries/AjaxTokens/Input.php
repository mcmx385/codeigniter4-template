<?php

namespace App\Libraries\AjaxTokens;

class Input
{
    public function __construct()
    {
        $this->model = new \App\Models\AjaxToken();
        $this->stringL = new \App\Libraries\stringLib();
        $this->dbL = new \App\Libraries\dbLib();
        $this->dtL = new \App\Libraries\datetimeLib();
        $this->varL = new \App\Libraries\varLib();
        $this->translateM = new \App\Models\Translate();
    }
    public function show($params)
    {
        $params = $this->params($params);
        $params = $this->fieldTypes($params);
    }
    public function params($params)
    {
        $def_params = [
            'table' => '',
            'action' => '',
            'data' => [],
            'filter' => ['id', 'last_active', 'updated', 'created', 'deleted_at', 'updated_at', 'created_at'],
            'select' => [],
            'fields' => [],
            'translate' => false,
            'col_width' => 6,
        ];
        $params = array_replace_recursive($def_params, $params);
        return $params;
    }
    public function fieldTypes($params)
    {
        // Get columns name and type of table, ignoring id
        $table = $params['table'];
        $field_types = $this->dbL->describeTable($table);
        $field_types = array_slice($field_types, 1);
        $select = $params['select'];
        $field_types = $this->varL->select2DList($field_types, $select);
        $filter = $params['filter'];
        $field_types = $this->varL->filter2DList($field_types, $filter);
        $params['field_types'] = $field_types;
        return $params;
    }
    public function translate($params)
    {
        if ($params['translate']) :
            $table = $params['table'];
            $field_types = $params['field_types'];
            foreach ($field_types as &$field) :
                $key = $field['key'];
                $type = $field['type'];
                $translated = $this->translateM->getWord("zh-hk", $key);
                if ($key == "name") :
                    $translated_table = $this->translateM->getWord("zh-hk", $table);
                    $translated_key = $this->translateM->getWord("zh-hk", $key);
                    $translated = $translated_table . $translated_key;
                else :
                    $translated = $this->translateM->getWord("zh-hk", $key);
                endif;
                $field['key'] = $translated;
            endforeach;
        endif;
    }
}
