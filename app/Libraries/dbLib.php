<?php

namespace App\Libraries;

class dbLib
{
    public function __construct()
    {
        $this->db = $this->connectDB();
        $this->stmtM = new \App\Libraries\stmtLib();
        $this->varL = new \App\Libraries\varLib();
        $this->dtL = new \App\Libraries\datetimeLib();
    }

    // SQL database
    public function connectDB()
    {
        return \Config\Database::connect();
    }

    // Database tables
    public function fieldsTable($table)
    {
        return $this->db->getFieldNames($table);
    }
    public function existsTable($table)
    {
        return $this->db->tableExists($table);
    }
    public function listTables()
    {
        return $this->db->listTables();
    }
    public function describeTable($table)
    {
        $list = [];
        $sql = $this->stmtM->describeTable($table);
        $result = $this->queryRows($sql);
        foreach ($result as $row) :
            array_push($list, [
                "key" => $row->Field,
                "type" => $row->Type,
            ]);
        endforeach;
        return $list;
    }

    // Table rows
    // Line Query
    public function queryRows($sql)
    {
        return $this->db->query($sql)->getResult();
    }
    public function selectRows($table, $sql)
    {
        $sql = $this->stmtM->selectRows($table, $sql);
        # echo $sql;
        return $this->queryRows($sql);
    }
    public function deleteRows($table, $criteria)
    {
        $sql = $this->stmtM->deleteRows($table, $criteria);

        $result = $this->queryRows($sql);

        // echo $sql;
        $query = $this->db->getLastQuery();
        // print_r($query);
        // echo (string) $query;

        return $result;
    }

    // Builder Query
    public function insertRows($table, $data)
    {
        $data['created'] = date("Y-m-d H:i:s");
        $this->db->table($table)->insert($data);

        // For Debugging
        $query = $this->db->getLastQuery();
        // print_r($query);
        // echo (string) $query;
        // exit;

        return $this->db->insertID();
    }
    public function prevID()
    {
        return $this->last_insert_id;
    }
    public function checkDup($table, $data)
    {
        if (is_object($data)) :
            unset($data->date);
            unset($data->created);
        elseif (is_array($data)) :
            unset($data['date']);
            unset($data['created']);
        endif;
        $result = $this->whereRows($table, $data);
        return count($result) < 1;
    }
    public function whereRows($table, $data = [], $additional = [], $returnstmt = false, $returnCount = false)
    {
        $builder = $this->db->table($table);
        foreach (array_keys($additional) as $item) :
            if (isset($additional[$item])) :
                ${$item} = $additional[$item];
            else :
                ${$item} = null;
            endif;
        endforeach;

        # Order By
        if (isset($orderby) && $orderby !== null) :
            foreach ($orderby as $key => $value) :
                $builder->orderBy($key, $value);
            endforeach;
        endif;

        # Filter
        if (isset($filter) && $filter !== null) :
            $select = $this->fieldsTable($table);
            foreach ($filter as $value) :
                $select = $this->varL->unsetArrayValue($value, $select);
            endforeach;
        endif;

        # Select Stmt
        if (isset($selectStmt)) :
            foreach ($selectStmt as $key => $value) :
                $builder->select($value);
            endforeach;
        endif;

        # Select Expecting array
        if (isset($select) && $select !== null) :
            if (is_array(reset($select))) :
                foreach ($select as $key => $value) :
                    foreach ($value as $item) :
                        if (is_string($item)) :
                            $builder->select($key . "." . $item);
                        elseif (is_array($item)) :
                            // print_r($item);
                            $column = $key . "." . $item['column'];
                            if (isset($item['date'])) :
                                $date = $item['date'];
                                $new_date = $this->dtL->formatPercent($date);
                                $column = 'DATE_FORMAT(' . $column . ',"' . $new_date . '")';
                            endif;
                            if (isset($item['count'])) :
                                $countTable = $item['count']['table'];
                                $where = $item['count']['where'];
                                $additional = $item['count']['additional'];
                                if (!isset($additional['select'])) :
                                    $additional['select'] = [];
                                endif;
                                array_push($additional['select'], "count(*)");
                                $stmt = $this->whereRows($countTable, $where, $additional, true);
                                $column = "($stmt)";
                            endif;
                            if (isset($item['concat'])) :
                                $list = implode(", ", $show_field);
                                $column = "concat($list)";
                            endif;
                            if (isset($item['rename'])) :
                                $rename = $item['rename'];
                                $column .= " as $rename";
                            endif;
                            $builder->select($column);
                        endif;
                    endforeach;
                endforeach;
            else :
                if (count($select) > 0) :
                    // print_r($select);
                    foreach ($select as $item) :
                        if (is_string($item)) :
                            $builder->select($item);
                        elseif (is_array($item)) :
                            // print_r($item);
                            $column = $item['column'];
                            if (isset($item['date'])) :
                                $date = $item['date'];
                                $new_date = $this->dtL->formatPercent($date);
                                $column = 'DATE_FORMAT(' . $column . ',"' . $new_date . '")';
                            endif;
                            if (isset($item['count'])) :
                                $countTable = $item['count']['table'];
                                $where = $item['count']['where'];
                                $additional = $item['count']['additional'];
                                if (!isset($additional['select'])) :
                                    $additional['select'] = [];
                                endif;
                                array_push($additional['select'], "count(*)");
                                $dbL2 = new dbLib;
                                $stmt = $dbL2->whereRows($countTable, $where, $additional, true);
                                $column = "($stmt)";
                            endif;
                            if (isset($item['rename'])) :
                                $rename = $item['rename'];
                                $column .= " as $rename";
                            endif;
                            $builder->select($column);
                        endif;
                    endforeach;
                else :
                    $builder->select("*");
                endif;
            endif;
        endif;

        # Where
        if (is_object($data) || $this->varL->isAssoc($data)) :
            foreach ($data as $key => $value) :
                if (is_array($value)) :
                    $column = $item['column'];
                    if (isset($item['date'])) :
                        $date = $item['date'];
                        $new_date = $this->dtL->formatPercent($date);
                        $value = 'DATE_FORMAT(' . $column . ',"' . $new_date . '")';
                    endif;
                endif;
                $builder->where($key, $value);
            endforeach;
        else :
            foreach ($data as $value) :
                $builder->where($value);
            endforeach;
        endif;

        # Where Stmt
        if (isset($whereStmt)) :
            foreach ($whereStmt as $key => $value) :
                $builder->where($value, null, true);
            endforeach;
        endif;

        # Or where
        if (isset($orWhere)) :
            foreach ($orWhere as $key => $value) :
                $builder->orWhere($key, $value);
            endforeach;
        endif;

        # Or where group
        if (isset($orWhereGroup)) :
            foreach ($orWhereGroup as $key => $value) :
                $builder->orWhere($key, $value);
            endforeach;
        endif;

        # Like
        if (isset($like) && $like !== null && count($like) > 0) :
            foreach ($like as $key => $value) :
                if ($value !== "") :
                    $builder->like($key, $value);
                endif;
            endforeach;
        endif;

        # Or Like
        if (isset($orlike) && $orlike !== null && count($orlike) > 0) :
            foreach ($orlike as $key => $value) :
                if ($value !== "") :
                    $builder->orLike($key, $value);
                endif;
            endforeach;
        endif;

        # Limit & Offset
        if (isset($limit) && $limit !== null) :
            if (isset($offset) && $offset !== null) :
                $builder->limit($limit, $offset);
            else :
                $builder->limit($limit);
            endif;
        endif;

        # Group by
        if (isset($groupby) && $groupby !== null) :
            $builder->groupBy($groupby);
        endif;

        // print_r($additional);
        # Join
        if (isset($join) && $join !== null && count($join) > 0) :
            if ($this->varL->isAssoc($join)) :
                foreach ($join['joints'] as $key => $value) :
                    $builder->join($key, $value, $join['method']);
                endforeach;
            else :
                foreach ($join as $joins) :
                    foreach ($joins['joints'] as $key => $value) :
                        $builder->join($key, $value, $joins['method']);
                    endforeach;
                endforeach;
            endif;
        endif;

        # Where In Stmt
        if (isset($inStmt) && $inStmt !== null && count($inStmt) > 0) :
            foreach ($inStmt as $key => $value) :
                $value = implode(',', $value);
                $builder->where("$key in ($value)");
            endforeach;
        endif;

        # Where In Array
        if (isset($inArray) && $inArray !== null && count($inArray) > 0) :
            foreach ($inArray as $key => $value) :
                $builder->whereIn($key, $value);
            endforeach;
        endif;

        # Anywhere multi table
        if (isset($anywhere) && isset($join) && !empty($anywhere) && !empty($join) && count($join) > 0) :
            $anywhere = trim($anywhere);
            $column_list = [];
            $table_list = array_keys($join['joints']);
            if (!in_array($table, $table_list)) :
                array_push($table_list, $table);
            endif;
            foreach ($table_list as $key) :
                $inner_list = $this->describeTable($key);
                $count = 0;
                foreach ($inner_list as $item) :
                    $inner_list[$count]['key'] = $key . "." . $item['key'];
                    $count += 1;
                endforeach;
                $column_list = array_merge($column_list, $inner_list);
            endforeach;
            $builder->groupStart();
            foreach ($column_list as $column) :
                $builder->orlike($column['key'], $anywhere);
            endforeach;
            $builder->groupEnd();
        elseif (!empty($anywhere)) :
            $column_list = $this->describeTable($table);
            $builder->groupStart();
            foreach ($column_list as $column) :
                $builder->orlike($column['key'], $anywhere);
            endforeach;
            $builder->groupEnd();
        endif;
        $result = $builder->get()->getResult();

        // For Debugging
        $query = $this->db->getLastQuery();
        // print_r($query);
        // echo (string) $query;
        // print_r($result);
        // echo $target = debug_backtrace()[1]['function'];
        // echo $appname = debug_backtrace()[1]['class'];

        // if ($returnstmt == "both") :
        //     return ["result" => $result, "stmt" => (string) $query];
        // elseif ($returnstmt) :
        if ($returnstmt) :
            return (string) $query;
        else :
            if ($returnCount) :
                return count($result);
            else :
                return $result;
            endif;
        endif;
    }
    public function countRows($table, $data = [], $additional = [])
    {
        return $this->whereRows($table, $data, $additional, false, true);
    }
    public function existsRows($table, $data = [], $additional = [])
    {
        return count($this->countRows($table, $data, $additional)) > 0;
    }
    public function updateRows($table, $set, $where = [], $additional = [], $returnstmt = false)
    {
        $set["updated"] = $this->dtL->currentDT();
        unset($set["created"]);
        $builder = $this->db->table($table);
        foreach (array_keys($additional) as $item) :
            if (isset($additional[$item])) :
                ${$item} = $additional[$item];
            else :
                ${$item} = null;
            endif;
        endforeach;

        // For Set and Where
        foreach ($set as $key => $value) :
            $builder->set($key, $value);
        endforeach;
        foreach ($where as $key => $value) :
            $builder->where($key, $value);
        endforeach;

        // For Set Stmt
        if (isset($setStmt)) :
            foreach ($setStmt as $key => $value) :
                $builder->set($key, $value, false);
            endforeach;
        endif;

        # Where In Stmt
        if (isset($inStmt) && $inStmt !== null && count($inStmt) > 0) :
            foreach ($inStmt as $key => $value) :
                $builder->where("$key in ($value)");
            endforeach;
        endif;

        # Join
        if (isset($join) && $join !== null && count($join) > 0) :
            if ($this->varL->isAssoc($join)) :
                foreach ($join['joints'] as $key => $value) :
                    echo $key;
                    $builder->join($key, $value, $join['method']);
                endforeach;
            else :
                foreach ($join as $joins) :
                    foreach ($joins['joints'] as $key => $value) :
                        $builder->join($key, $value, $joins['method']);
                    endforeach;
                endforeach;
            endif;
        endif;

        $builder->update();
        // For Debugging
        $query = $this->db->getLastQuery();
        // print_r($query);
        // echo (string) $query;

        // For Updated ID Only
        $where = array_merge($where, $set);
        foreach ($where as $key => $value) :
            $builder->where($key, $value);
        endforeach;
        $result = $builder->get()->getResult();
        $updated_id = $result[0]->id;

        if ($returnstmt) :
            return (string) $query;
        else :
            return $updated_id;
        endif;
    }
    public function removeRows($table, $data)
    {
        $builder = $this->db->table($table);
        // print_r($data);

        if (isset($data['id'])) :
            $deleted_id = $data['id'];
        else :
            foreach ($data as $key => $value) :
                $builder->where($key, $value);
            endforeach;
            $result = $builder->get()->getResult();
            $deleted_id = $result[0]->id;
        endif;

        $builder->delete($data);
        $query = $this->db->getLastQuery();
        // print_r($query);
        // echo (string) $query;

        return $deleted_id;
    }

    // POST Builder Query
    public function insertPOST($table, $list = [])
    {
        if (count($list) > 0) :
            $list = $this->fieldsTable($table);
        endif;
        $_POST['created'] = date("Y-m-d H:i:s");
        $data = $this->valuesPOST($list);
        // print_r($data);
        return $this->insertRows($table, $data);
    }
    public function updatePOST($table, $list, $where)
    {
        unset($_POST['created']);
        $set = $this->valuesPOST($list);
        return $this->updateRows($table, $set, $where);
    }

    // Supportive
    public function record_exist($result)
    {
        return $this->varL->record_exist($result);
    }
    public function existRows($params)
    {
        $result = $this->whereRows($params["table"], $params["where"]);
        return $this->varL->record_exist($result);
    }
    public function valuesPOST($list)
    {
        $data = [];
        foreach ($list as $var) {
            if (isset($_POST[$var]) && $_POST[$var] !== "") :
                $data[$var] = $_POST[$var];
            endif;
        }
        return $data;
    }

    # Make sure there are no duplicate field names, excepting only one record only per table
    public function multi_record($where, $params)
    {
        # Setup User ID
        $data = [];
        foreach ($params as $key => $value) :
            $result = $this->whereRows($key, $where, ["select" => $value]);
            $result = (array) $result[0];
            $data = array_merge_recursive($data, $result);
        endforeach;
        return $data;
    }
    // $params = [
    //     "table" => "class_users",
    //     "where" => ["id" => $classid],
    //     "use" => "user_id",
    //     "find" => [
    //         "users" => ['username', 'email', 'remarks'],
    //         "user_profile" => ['first_name', 'last_name', 'gender', 'about', 'health'],
    //         "user_member" => ['membership'],
    //     ],
    // ];
    public function twod_result($params)
    {
        // Get table where
        $table = $params["table"];
        $where = $params["where"];
        $additional = $params["additional"];

        // Use
        $new_additional = $additional;
        $new_additional["select"] = [$params["use"]];
        $result = $this->whereRows($table, $where, $new_additional);
        // print_r($result);
        $list = [];
        foreach ($result as $item) :
            $use_value = $item->{$params["use"]};
            array_push($list, $use_value);
        endforeach;

        // Keep
        if (isset($params["keep"])) :
            $new_additional = $additional;
            $new_additional["select"] = $keep = $params["keep"];
            $keep_result = $this->whereRows($table, $params["where"], $new_additional);
        endif;

        // Find
        $data = [];
        $count = 0;
        foreach ($list as $item) :
            if (isset($params["as"])) :
                $as = $params["as"];
            else :
                $as = $params["use"];
            endif;
            $result = $this->multi_record([$as => $item], $params["find"]);
            if (isset($keep)) :
                foreach ($keep as $thing) :
                    $result[$thing] = $keep_result[$count]->$thing;
                endforeach;
            endif;
            array_push($data, (object) $result);
            $count += 1;
        endforeach;

        return $data;
    }

    public function crossGetRows($params)
    {
        $def_params = [
            "reference" => [
                "table" => "",
                "where" => [],
                "additional" => [],
            ],
            "find" => [
                "id" => [
                    "table" => []
                ],
                "class_id" => [
                    "table" => [],
                ]
            ]
        ];
    }

    public function selectmAnyExist($params)
    {
        $exist = false;
        foreach ($params as $key => $value) :
            $result = $this->whereRows($key, $value);
            if ($this->varL->record_exist($result)) :
                $exist = true;
            endif;
        endforeach;
        return $exist;
    }

    public function testing()
    {
        echo "testing";
    }
}
