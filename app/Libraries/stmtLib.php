<?php
# Supportive model

namespace App\Libraries;

class stmtLib
{
    // SQL Database
    public function createDB($db_name)
    {
        $sql = "";
        if ($db_name !== "") :
            $sql = "CREATE DATABASE $db_name";
        endif;
        return $sql;
    }

    // Database tables
    public function showTable()
    {
        $sql = "SHOW TABLES;";
        return $sql;
    }
    public function describeTable($table)
    {
        $sql = "DESCRIBE $table";
        return $sql;
    }

    // Table rows
    public function insertRows($table, $data)
    {
        $sql = "";
        $columns = "id";
        $values = "NULL";
        foreach ($data as $key => $value) :
            $columns .= ", $key";
            $values .= ", $value";
        endforeach;
        if ($columns !== "" && $values !== "") :
            $sql = "INSERT INTO `" . $table . "` (" . $columns . ") VALUES (" . $values . ");";
        endif;
        return $sql;
    }
    public function selectRows($table, $criteria, $column = "*")
    {
        $sql = "SELECT $column FROM `$table`";
        if (!empty($sql)) :
            $sql .= " WHERE $criteria";
        endif;
        return $sql;
    }
    public function updateRows($table, $criteria, $change)
    {
        $sql = "";
        if ($change !== "" && $criteria !== "") :
            $sql = "UPDATE " . $table . " SET " . $change . " WHERE " . $criteria;
        endif;
        return $sql;
    }
    public function deleteRows($table, $criteria)
    {
        $sql = "";
        if ($criteria !== "") {
            $sql = "DELETE FROM `" . $table . "` WHERE " . $criteria;
        }
        return $sql;
    }
    public function criteria($data)
    {
        $stmt = "";
        $count = 0;
        foreach ($data as $key => $value) :
            if ($count = 0) :
                $stmt .= "$key=$value";
            else :
                $stmt .= " AND $key=$value";
            endif;
            $count += 1;
        endforeach;
        return $stmt;
    }
    public function list($data)
    {
        $keys = $dummy = $value_string = "";
        $values = [];
        $count = 0;
        foreach ($data as $key => $value) :
            if ($count == 0) :
                $keys .= "$key";
                $value_string .= "$value";
                $dummy .= "?";
            else :
                $keys .= ", $key";
                $value_string .= ", $value";
                $dummy .= ", ?";
            endif;
            array_push($values, $value);
            $count += 1;
        endforeach;
        return [
            "keys" => $keys,
            "values" => $values,
            "valuestring" => $value_string,
            "dummy" => $dummy,
        ];
    }
    public function testing()
    {
        echo "hi";
    }
}
