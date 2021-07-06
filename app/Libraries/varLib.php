<?php

namespace App\Libraries;

class varLib
{
    public function set_post_var($post_list)
    {
        foreach ($post_list as $var) {
            if (!isset($_POST[$var])) {
                $_POST[$var] = "";
            }
        }
    }
    public function set_get_var($get_list)
    {
        foreach ($get_list as $var) {
            if (isset($_GET[$var])) {
                global ${$var};
                ${$var} = $_GET[$var];
            }
        }
    }
    public function emptyString($var)
    {
        return $var == "";
    }

    public function issetVar($var)
    {
        global ${$var};
        return isset(${$var});
    }
    public function emptyColumn($column_list)
    {
        $data = [[]];
        foreach ($column_list as $item) {
            $data[0][$item] = "";
        }
        return $data;
    }
    public function emptyArrayObject($column_list)
    {
        $data = [(object)[]];
        foreach ($column_list as $item) {
            $data[0]->$item = "";
        }
        return $data;
    }
    public function record_exist($data)
    {
        return count($data) > 0;
    }
    public function twodarrayFilter($array, $filter)
    {
        $count = 0;
        foreach ($array as $item) :
            foreach ($item as $key => $value) :
                if (in_array($key, $filter)) :
                    unset($array[$count][$key]);
                endif;
            endforeach;
            $count += 1;
        endforeach;
        return $array;
    }
    public function twodarrayValueFilter($array, $filter)
    {
        $count = 0;
        foreach ($array as $item) :
            foreach ($item as $key => $value) :
                if (isset($filter[$key]) && $filter[$key] = $value) :
                    unset($array[$count]);
                endif;
            endforeach;
            $count += 1;
        endforeach;
        sort($array);
        return $array;
    }
    public function assocArrayValueFilter($array, $filter)
    {
        foreach ($filter as $key => $value) :
            if (is_string($key)) :
                foreach ($value as $thing) :
                    $pos = array_search($thing, $array[$key]);
                    unset($array[$key][$pos]);
                endforeach;
                $array[$key] = array_values($array[$key]);
            elseif (is_int($key)) :
                $pos = array_search($value, $array);
                unset($array[$pos]);
            endif;
        endforeach;
        return $array;
    }
    public function twodobjectValueFilter($array, $filter)
    {
        $count = 0;
        foreach ($array as $item) :
            foreach ($item as $key => $value) :
                if (isset($filter[$key]) && $filter[$key] == $value) :
                    unset($array[$count]);
                endif;
            endforeach;
            $count += 1;
        endforeach;
        sort($array);
        return $array;
    }
    public function array_clone($array)
    {
        // return $array;
        return array_replace([], $array);
    }
    public function object_merge($object1, $object2)
    {
        return (object)array_merge((array)$object1, (array)$object2);
    }
    public function twodarrayobjectFilter($arrayobject, $filter)
    {
        $new_arrayobject = [];
        $count = 0;
        foreach ($arrayobject as $item) :
            $new_item = clone $item;
            foreach ($item as $key => $value) :
                if (in_array($key, $filter)) :
                    unset($new_item->$key);
                endif;
            endforeach;
            $new_arrayobject[$count] = $new_item;
            $count += 1;
        endforeach;
        return $new_arrayobject;
    }
    public function arrayValueFilter($array, $filter)
    {
        foreach ($filter as $item) :
            if (in_array($item, $array)) :
                $pos = array_search($item, $array);
                unset($array[$pos]);
            endif;
        endforeach;
        return $array;
    }
    public function arrayKeyFilter($array, $filter)
    {
        foreach ($filter as $item) :
            unset($array[$item]);
        endforeach;
        return $array;
    }
    public function arrayKeyKeep($array, $keys)
    {
        foreach ($array as $key => $value) :
            if (in_array($key, $keys)) :
                $data[$key] = $value;
            endif;
        endforeach;
        return $data;
    }
    public function arrayValueKeep($array, $keep)
    {
        $list = [];
        foreach ($keep as $item) :
            if (in_array($item, $array)) :
                array_push($list, $item);
            endif;
        endforeach;
        return $list;
    }
    public function twodarrayKeep($array, $keep)
    {
        $result = [];
        $count = 0;
        print_r($array);
        foreach ($array as $item) :
            foreach ($item as $key => $value) :
                if (in_array($key, $keep)) :
                    $result[$count][$key] = $value;
                endif;
            endforeach;
            $count += 1;
        endforeach;
        return $result;
    }
    public function twodobjectKeep($array, $keep)
    {
        $count = 0;
        $first_list = [];
        foreach ($array as $item) :
            $second_list = (object) [];
            foreach ($item as $key => $value) :
                if (in_array($key, $keep)) :
                    $second_list->{$key} = $value;
                endif;
            endforeach;
            array_push($first_list, $second_list);
            $count += 1;
        endforeach;
        return $first_list;
    }
    public function twod_array_columns($data)
    {
        if (count($data) > 0) :
            $data = $data[0];
            if (is_object($data)) :
                $data = (array) $data;
            endif;
            return array_keys($data);
        else :
            return $data;
        endif;
    }

    public function getVar($params)
    {
        $source = strtoupper($params["source"]);
        $varname = $params["name"];
        $default = $params["default"];

        # If empty not ok
        if (isset($params["empty"])) :
            $empty = $params["empty"];
            if (!$empty) :
                switch ($source):
                    case ("GET"):
                        if (isset($_GET[$varname]) && $_GET[$varname] !== "") :
                            return $_GET[$varname];
                        else :
                            return $default;
                        endif;
                        break;
                    case ("POST"):
                        if (isset($_POST[$varname]) && $_POST[$varname] !== "") :
                            return $_POST[$varname];
                        else :
                            return $default;
                        endif;
                        break;
                    case ("SERVER"):
                        if (isset($_SERVER[$varname]) && $_SERVER[$varname] !== "") :
                            return $_SERVER[$varname];
                        else :
                            return $default;
                        endif;
                        break;
                    case ("SESSION"):
                        if (isset($_SESSION[$varname]) && $_SESSION[$varname] !== "") :
                            return $_SESSION[$varname];
                        else :
                            return $default;
                        endif;
                        break;
                    default;
                        break;
                endswitch;
                if ($source == "GET") :
                endif;
            endif;
        endif;

        # If empty is ok
        switch ($source):
            case ("GET"):
                if (isset($_GET[$varname])) :
                    return $_GET[$varname];
                else :
                    return $default;
                endif;
                break;
            case ("POST"):
                if (isset($_POST[$varname])) :
                    return $_POST[$varname];
                else :
                    return $default;
                endif;
                break;
            case ("SERVER"):
                if (isset($_SERVER[$varname])) :
                    return $_SERVER[$varname];
                else :
                    return $default;
                endif;
                break;
            case ("SESSION"):
                if (isset($_SESSION[$varname])) :
                    return $_SESSION[$varname];
                else :
                    return $default;
                endif;
                break;
            default;
                break;
        endswitch;
    }

    public function unsetArrayValue($value, $list)
    {
        if (($key = array_search($value, $list)) !== false) {
            unset($list[$key]);
        }
        return $list;
    }

    public function arrayMergeRecursive($array1, $array2)
    {
        $count = 0;
        foreach ($array2 as $item) :
            foreach ($item as $key => $value) :
                $array1[$count]->$key = $value;
            endforeach;
            $count += 1;
        endforeach;
        return $array1;
    }

    public function arrayObjectList($array, $require)
    {
        $result = [];
        foreach ($array as $item) :
            array_push($result, $item->$require);
        endforeach;
        return $result;
    }
    public function arrayObject($array)
    {
        $arrayObject = [];
        foreach ($array as $item) {
            array_push($arrayObject, (object) $item);
        }
        return $arrayObject;
    }
    function replace_in_array($find, $replace, &$array)
    {
        array_walk_recursive($array, function (&$array) use ($find, $replace) {
            if ($array == $find) {
                $array = str_replace($find, $replace, $array);
            }
        });
        return $array;
    }
    public function replacer(&$item, $key)
    {
        if ($key == 'Price') {
            $item = str_replace(",", ".", $item);
        }
    }

    public function arrayRemoveEmpty($array)
    {
        return array_filter($array, fn ($value) => !is_null($value) && $value !== '');
    }

    public function column_result($data, $column)
    {
        $list = [];
        foreach ($data as $item) :
            $item = (array) $item;
            array_push($list, $item[$column]);
        endforeach;
        return $list;
    }

    public function sumArrayCol($result, $col)
    {
        $result = $this->column_result($result, $col);
        return (int) array_sum($result);
    }
    public function sumArray($result)
    {
        return (int) array_sum($result);
    }
    public function avgArray($result)
    {
        return (int) array_sum($result) / count($result);
    }
    public function maxArray($result)
    {
        return (int) max($result);
    }
    public function minArray($result)
    {
        return (int) min($result);
    }
    public function countArray($result)
    {
        return count($result);
    }
    public function stdevArray($result)
    {
        if ($this->intArray($result)) :
            $num_of_elements = count($result);
            $variance = 0.0;
            $average = array_sum($result) / $num_of_elements;
            foreach ($result as $i) {
                $variance += pow(($i - $average), 2);
            }
            $result = (float) sqrt($variance / $num_of_elements);
            return $this->sigFig($result, 3);
        endif;
    }
    public function rangeArray($result)
    {
        return $this->maxArray($result) - $this->minArray($result);
    }
    public function popularArray($result)
    {
        $values = array_count_values($result);
        arsort($values);
        return array_slice(array_keys($values), 0, 5, true);
    }
    public function modeArray($result)
    {
        return $this->popularArray($result)[0];
    }
    public function varianceArray($result)
    {
        if ($this->intArray($result)) :
            $variance = 0.0;
            $totalElementsInArray = count($result);
            // Calc Mean.
            $averageValue = array_sum($result) / $totalElementsInArray;

            foreach ($result as $item) {
                $variance += pow(abs($item - $averageValue), 2);
            }
            return $variance;
        endif;
    }
    public function intArray($result)
    {
        foreach ($result as $value) {
            if (!is_numeric($value)) {
                return false;
            }
        }
        return true;
    }
    function sigFig($value, $digits)
    {
        if ($value == 0) {
            $decimalPlaces = $digits - 1;
        } elseif ($value < 0) {
            $decimalPlaces = $digits - floor(log10($value * -1)) - 1;
        } else {
            $decimalPlaces = $digits - floor(log10($value)) - 1;
        }

        $answer = round($value, $decimalPlaces);
        return $answer;
    }
    public function countEmptyPost($list)
    {
        $error_count = 0;
        foreach ($list as $item) {
            if (empty($_POST[$item])) {
                $error_count += 1;
            }
        }
        return $error_count;
    }
    public function sumIfSame($result, $col, $target)
    {
        // print_r($result);
        $new_result = [];
        foreach ($result as $item) :
            $key = $item->$col;
            $value = $item->$target;
            if (!is_array($new_result[$key])) :
                $new_result[$key] = [];
            endif;
            array_push($new_result[$key], $value);
        endforeach;
        // print_r($new_result);
        $final_result = [];
        $count = 0;
        foreach ($new_result as $key => $value) :
            $final_result[$count][$col] = $key;
            $final_result[$count][$target] = array_sum($value);
            $final_result[$count] = (object) $final_result[$count];
            $count += 1;
        endforeach;
        // print_r($final_result);
        return $final_result;
    }

    public function isAssoc(array $arr)
    {
        if (array() === $arr) return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
    public function is2darray($array)
    {
        return is_array(reset($array));
    }

    public function array_once($array, $key)
    {
        if (!in_array($key, $array)) :
            array_push($array, $key);
        endif;
        return $array;
    }

    public function obj2array($obj)
    {
        return json_decode(json_encode($obj), true);
    }

    public function prefixArray($array, $prefix)
    {
        $count = 0;
        foreach ($array as $item) :
            $array[$count] = $prefix . $item;
            $count += 1;
        endforeach;
        return $array;
    }

    function recursive_unset(&$array, $unwanted_key)
    {
        unset($array[$unwanted_key]);
        foreach ($array as &$value) {
            if (is_array($value)) {
                $this->recursive_unset($value, $unwanted_key);
            }
        }
    }

    public function array221($array)
    {
        return call_user_func_array('array_merge', $array);
    }

    public function flattenArray($array)
    {
        $count = 0;
        $new_array = [];
        foreach ($array as $key => $item) :
            if (is_int($key)) :
                array_push($new_array, $item);
            elseif (is_string($key)) :
                $new_array = array_merge($new_array, $item);
            endif;
            $count += 1;
        endforeach;
        return $new_array;
    }

    public function isJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    public function decodeIfJson($string)
    {
        if (is_array($string)) :
            return $string;
        elseif ($this->isJson($string)) :
            return json_decode($string);
        else :
            return $string;
        endif;
    }

    public function getObjOrArrValue($obj, $key)
    {
        if (is_array($obj)) :
            return $obj[$key];
        elseif (is_object($obj)) :
            return $obj->$key;
        else :
            return $obj;
        endif;
    }

    public function filter2DList($type_list, $filter_list, $key = 'key')
    {
        if (count($filter_list) > 0) :
            $final_type_list = [];
            foreach ($type_list as $item) :
                $pos = array_search(strtolower($item[$key]), $filter_list);
                if (!is_int($pos) && empty($pos)) :
                    array_push($final_type_list, $item);
                endif;
            endforeach;
            return $type_list = $final_type_list;
        else :
            return $type_list;
        endif;
    }
    public function keep2DFList($type_list, $keep_list, $key = 'key')
    {
        if (count($keep_list) > 0) :
            $final_type_list = [];
            foreach ($type_list as $item) :
                $pos = array_search(strtolower($item[$key]), $keep_list);
                if (is_int($pos)) :
                    array_push($final_type_list, $item);
                endif;
            endforeach;
            return $type_list = $final_type_list;
        else :
            return $type_list;
        endif;
    }

    public function testing()
    {
        echo "hi";
    }
}
