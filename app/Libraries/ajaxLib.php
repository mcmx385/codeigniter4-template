<?php

namespace App\Libraries;

class ajaxLib
{
    public function __construct()
    {
        $this->dbL = new \App\Libraries\dbLib();
        $this->dtL = new \App\Libraries\datetimeLib();
        $this->varL = new \App\Libraries\varLib();
        $this->translateM = new \App\Models\Translate();
        $this->userM = new \App\Models\User();
        $this->tokenM = new \App\Models\Token();
    }

    // List filtering
    public function filterList($type_list, $filter_list, $key = 'key')
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
    public function keepList($type_list, $keep_list, $key = 'key')
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

    // Field Generator
    public function inputField($table, $action_type, $data, $additional)
    {
        $default_params = [
            "filter" => ['id', 'last_active', 'updated', 'created'],
            "select" => [],
            'required' => false,
            "col_width" => 6,
        ];
        foreach ($default_params as $key => $value) :
            if (isset($additional[$key])) :
                ${$key} = $additional[$key];
            else :
                ${$key} = $value;
            endif;
        endforeach;

        # Get columns name and type of table, ignoring id
        $type_list = $this->dbL->describeTable($table);
        $type_list = array_slice($type_list, 1);
        // print_r($filter);
        $type_list = $this->filterList($type_list, $filter);
        $type_list = $this->keepList($type_list, $select);
        $data = $data[0];
        // print_r($type_list);
?>
        <div class="row w-100 mx-0">
            <?php
            $count = 0;
            foreach ($type_list as $column) :
                // echo "Start";
                $column_key = $new_key = $column['key'];
                $column_type = $column['type'];

                $translated = $this->translateM->getWord("zh-hk", $column_key);

                if ($new_key == "name") :
                    $translated_table = $this->translateM->getWord("zh-hk", $table);
                    $translated_key = $this->translateM->getWord("zh-hk", $new_key);
                    $translated = $translated_table . $translated_key;
                endif;

                # Check action type
                $class_attr = "form-control";
                switch ($action_type):
                    case ("view"):
                    case ("insert"):
                    case ("join"):
                    case ("update"):
                        $input_attr = "readonly disabled ";
                        break;
                    default:
                        $input_attr = "";
                        break;
                endswitch;
                if ($required) :
                    $input_attr .= "required ";
                endif;

            ?>
                <div class="col-md-<?php echo $col_width; ?> col-12 px-1">

                    <?php
                    // Input/textarea
                    $column_type_param = [
                        "longtext" => "textarea",
                        "default" => "input",
                    ];
                    if (isset($column_type_param[$column_type])) :
                        $element = $column_type_param[$column_type];
                    else :
                        $element = $column_type_param["default"];
                    endif;

                    $placeholder = "$translated";

                    // Setup input type
                    $append_icon = "";
                    if (strpos($column_key, "period") !== false) :
                        $input_type = "month";
                    elseif (strpos($column_type, "char") !== false) :
                        if (strpos($column_key, "color") !== false) :
                            $input_type = "color";
                        elseif ($column_key == "emoji" || $column_key == "icon") :
                            $input_type = "emoji";
                            $input_attr .= " data-emojiable='true' data-emoji-input='unicode'";
                        // elseif (strpos($column_key, "image") !== false) :
                        elseif ($column_key == "image") :
                            $input_type = "file";
                            $input_attr .= "accept='image/*'";
                        else :
                            $input_type = "text";
                        endif;
                    elseif (strpos($column_type, "int") !== false) :
                        $input_type = "number";
                    // $class_attr .= " input-number";
                    // $append_icon = "dialpad";
                    elseif (strpos($column_type, "datetime") !== false) :
                        $input_type = "datetime";
                        $append_icon = "date_range";
                        if (!empty($data->{$column_key})) :
                            $data->{$column_key} = $this->dtL->utc2local($data->{$column_key});
                        endif;
                        $placeholder .= " (點擊這裡選擇日期)";
                    elseif (substr($column_type, 0, 4) == "date") :
                        $input_type = "date";
                        $placeholder .= " (點擊這裡選擇日期)";
                    endif;

                    // Check if dropdown defined
                    $dropdown_result = $this->dbL->whereRows("dropdown", [
                        "form" => $table,
                        "name" => $column_key,
                    ]);
                    if ($this->varL->record_exist($dropdown_result)) :
                        $dropdown_result = $dropdown_result[0];
                        $items = $dropdown_result->items;
                        $type = $dropdown_result->type;
                        if ($type == "static" || $type == "") :
                            if ($items !== null && $items !== "[]" && $items !== "") :
                                $items = json_decode($items);
                                $element = "select";
                            endif;
                        elseif ($type == "associative" && isset($dropdown_result->related)) :
                            $related = json_decode($dropdown_result->related);
                            $assoc_table = $related->table;
                            $assoc_field = $related->field;
                            $show_field = $related->show;
                            if (is_string($show_field)) :
                                $assoc_result = $this->dbL->whereRows($assoc_table, [], ["select" => [$assoc_field, $show_field]]);
                            elseif (is_array($show_field)) :
                                $list = implode(", ", $show_field);
                                $show_field = "show_field";
                                $assoc_result = $this->dbL->whereRows($assoc_table, [], ["select" => [$assoc_field, "concat($list) as $show_field"]]);
                            endif;
                            $element = 'assoc_select';

                            // Assume it will get id, because thats how object oriented works
                            $new_key = str_replace("_id", "s", $column_key);
                            // It will try a word without plural
                            $translated = $this->translateM->getWord("zh-hk", $new_key);
                            if (empty($translated)) :
                                $translated = $column_key;
                            endif;
                        endif;
                    endif;
                    // echo $column_key;
                    ?>
                    <label class="mb-0 text-left" for="<?php echo $translated; ?>"><?php echo ucfirst($translated); ?></label>
                    <div class="input-group mb-2">
                        <?php
                        // Output input fields
                        $column_value = $this->varL->getObjOrArrValue($data, $column_key);
                        $column_value = $this->varL->decodeIfJson($column_value);
                        switch ($element):
                            case ("select"):
                                $empty_field = $column_value == "" || $column_value == "null";
                        ?>
                                <select <?php echo $input_attr; ?> class="form-control w-100" name="<?php echo $column_key; ?>" title="選擇<?php echo $translated; ?>">
                                    <!-- <option data-hidden="true"><?php echo $translated; ?></option> -->
                                    <?php
                                    $count = 0;
                                    $items = $this->varL->decodeIfJson($items);
                                    foreach ($items as $thing) {
                                        $translated_thing = $this->translateM->getWord("zh-hk", $thing);
                                    ?>
                                        <option <?php if (strtolower($thing) == strtolower($column_value) || ($count == 0 && $empty_field)) :
                                                    echo "selected";
                                                endif; ?> value='<?php if (preg_match("/\p{Han}+/u", $thing) or strpos($thing, "#") == false) : echo ($thing);
                                                                    else : echo urlencode($thing);
                                                                    endif; ?>'><?php echo ucfirst($translated_thing); ?></option>
                                    <?php
                                        $count += 1;
                                    }
                                    ?>
                                    <option <?php if ($action_type !== "add" && strtolower($column_value) == "") : echo "selected";
                                            endif; ?> value=""><?php echo $this->translateM->getWord("zh-hk", "blank field"); ?></option>
                                </select>
                            <?php
                                break;
                            case ("assoc_select"):
                            ?>
                                <select <?php echo $input_attr; ?> class="form-control w-100" name="<?php echo $column_key; ?>" title="選擇<?php echo $translated; ?>">
                                    <?php
                                    foreach ($assoc_result as $thing) :
                                        $thing->$show_field = $this->varL->decodeIfJson($thing->$show_field);
                                        $thing->$show_field = $this->translateM->getWord("zh-hk", $thing->$show_field);
                                    ?>
                                        <option <?php if (strtolower($thing->$assoc_field) == strtolower($column_value)) {
                                                    echo "selected";
                                                }; ?> value='<?php echo urlencode($thing->$assoc_field); ?>'><?php echo ucfirst($thing->$show_field); ?></option>
                                    <?php
                                    endforeach;
                                    ?>
                                    <option <?php if ($action_type !== "add" && strtolower($column_value) == "") : echo "selected";
                                            endif; ?> value=""><?php echo $this->translateM->getWord("zh-hk", "blank field"); ?></option>
                                </select>
                                <?php
                                break;
                            case ("textarea"):
                                echo "<$element $input_attr class='$class_attr' id='$column_key' name='$column_key' style='height:100px' placeholder='$placeholder'>$column_value</$element>";
                                break;
                            case ("input"):
                                if ($column_key == "emoji") :
                                    echo "<p class='emoji-picker-container mb-2 w-100'>";
                                    echo "<$element $input_attr class='$class_attr' type='$input_type' id='$column_key' name='$column_key' value='$column_value' placeholder='$placeholder'>";
                                    echo "</p>";
                                else :
                                    if ($append_icon !== "") :
                                        // echo "<$element $input_attr class='$class_attr' type='$input_type' id='field$count' name='$column_key' value='$column_value' placeholder='$placeholder'>";
                                        echo "<$element $input_attr class='$class_attr' type='$input_type' id='$column_key' name='$column_key' value='$column_value' placeholder='$placeholder'>";
                                ?>
                                        <div class="input-group-append noselect" id="<?php echo $column_key; ?>_clicker" style="cursor:pointer;">
                                            <span class="input-group-text material-icons">
                                                <span class="material-icons"><?php echo $append_icon; ?></span>
                                            </span>
                                        </div>
                                        <?php
                                        if ($input_type == "datetime") :
                                        ?>
                                            <script>
                                                $('#<?php echo $column_key; ?>_clicker').on('click', function() {
                                                    $('#<?php echo $column_key; ?>').datetimepicker("show");
                                                });
                                            </script>
                                        <?php
                                        endif;
                                        ?>
                        <?php
                                    else :
                                        echo "<$element $input_attr class='$class_attr' type='$input_type' id='$column_key' name='$column_key' value='$column_value' placeholder='$placeholder'>";
                                    endif;
                                endif;
                                break;
                        endswitch;
                        ?>
                    </div>
                </div>
            <?php
                $count += 1;
            // echo "End";
            endforeach;
            ?>
        </div><?php
            }

            public function dataHandling($info)
            {
                // ==========Setup Affected ID==========
                $params = [];
                $first_affected_id = "";
                $last_affected_id = "";
                $all_affected_id = [];
                $insert_count = 0;

                $onlyif = true;
                $error = "您不符合執行此操作的要求";
                if (isset($info->extra->onlyif) && $info->extra->onlyif !== "null" && $info->extra->onlyif !== "[]") :
                    // print_r($info->extra);
                    $action_onlyif = $info->extra->onlyif;
                    // print_r($action_onlyif);
                    if (isset($action_onlyif->error)) :
                        $error = $action_onlyif->error;
                    endif;
                    if (!$this->varL->record_exist($this->dbL->whereRows($action_onlyif->table, $action_onlyif->where))) :
                        $onlyif = false;
                    // echo "Did not meet OnlyIf criteria";
                    endif;
                endif;


                if ($onlyif) :
                    // print_r($info);
                    foreach ($info->data as $item) :

                        // ==========Replace Var==========
                        $_POST['phone'] = str_replace(",", "", $_POST['phone']);
                        $temp_item = json_encode($item);
                        if ($insert_count > 0) :
                            if (strpos($temp_item, "_firstAffectedID") !== false && empty($first_affected_id)) :
                                break;
                            endif;
                            if (strpos($temp_item, "_lastAffectedID") !== false && empty($last_affected_id)) :
                                break;
                            endif;
                            $temp_item = str_replace("_firstAffectedID", $first_affected_id, $temp_item);
                            $temp_item = str_replace("_lastAffectedID", $last_affected_id, $temp_item);
                        endif;
                        $postCount = substr_count($temp_item, "_post");
                        $prevPos = 0;
                        if ($postCount > 0) :
                            for ($i = 0; $i < $postCount; $i++) :
                                $initpos = strpos($temp_item, "_post[", $prevPos) + 6;
                                $endpos = strpos($temp_item, "]", $prevPos);
                                $distance = $endpos - $initpos;
                                $var = substr($temp_item, $initpos, $distance);
                                $whole_word = "_post[" . $var . "]";
                                $prevPos = $endpos;
                                $temp_item = str_replace($whole_word, $_POST[$var], $temp_item);
                            endfor;
                        endif;
                        $item = json_decode($temp_item);
                        // print_r($item);
                        // exit;

                        // ==========Setup==========
                        $action_table = $item->table;
                        $action_type = $item->action;
                        // echo "<br>=========New $action_type in $action_table Action==========<br>";
                        $column_list = $this->dbL->fieldsTable($action_table);
                        if (isset($item->set)) :
                            $action_data = (array) $item->set;
                        endif;
                        if (isset($item->where)) :
                            $action_where = (array) $item->where;
                        endif;

                        // =============File Upload===============
                        if (isset($info->extra->file)) :
                            $file_info = $info->extra->file;
                            foreach ($file_info as $key => $value) :
                                if (isset($_FILES[$key]['tmp_name'])) :
                                    $apparent_location = $value . $_FILES[$key]['name'];
                                    $destination = $_SERVER['DOCUMENT_ROOT'] . $apparent_location;
                                    $source = $_FILES[$key]['tmp_name'];
                                    move_uploaded_file($source, $destination);
                                    $_POST[$key] = $apparent_location;
                                endif;
                            endforeach;
                        endif;

                        // ==========Exist/Write Once==========
                        if ($action_type == "exist" || $action_type == "write_once") :

                            // Get unqiue fields and determine add or edit
                            // If unique is set, then just need query defined criterias
                            if (isset($item->unique)) :
                                $action_where = (array) $item->unique;
                            // If unique field is set, then query specific POST fields
                            elseif (isset($item->unique_field)) :
                                // echo "Unique Field";
                                $action_where = [];
                                foreach ($item->unique_field as $key) :
                                    if (isset($action_data[$key]) && $action_data[$key] !== "") :
                                        $action_data[$key] = $action_where[$key] = $action_data[$key];
                                    elseif (isset($_POST[$key]) && $_POST[$key] !== "") :
                                        $action_data[$key] = $action_where[$key] = $_POST[$key];
                                    endif;
                                endforeach;
                            // If no unique field is defined, then query all POST fields
                            else :
                                // echo "General Unique";
                                $action_where = (array) $item->set;
                                foreach ($_POST as $key => $value) :
                                    if (in_array($key, $column_list)) :
                                        $action_data[$key] = $action_where[$key] = $value;
                                    endif;
                                endforeach;
                            endif;

                            // Query to find duplicates
                            $check_result = $this->dbL->whereRows($action_table, $action_where);
                            if ($this->varL->record_exist($check_result)) :
                                // Although the row exist, but we can still edit other column values
                                if ($action_type !== "write_once") :
                                    $action_type = "edit";
                                endif;
                                $affected_id = $check_result[0]->id;
                            else :
                                // If row does not exist, then we add a new one
                                $action_type = "add";
                                foreach ((array) $item->unique as $key => $value) :
                                    $action_data[$key] = $value;
                                endforeach;
                            endif;
                        // echo "Action finalized: $action_type<br>";
                        endif;

                        // print_r($action_data);

                        // ==========Duplicate==========
                        $enable_dup = true;
                        if (isset($info->extra->duplicate)) :
                            $enable_dup = $info->extra->duplicate;
                        endif;
                        $allow_insert = true;
                        if (!$enable_dup && isset($action_data)) :
                            unset($action_data['created']);

                            $result_exist = false;
                            // ==========Predefined Dup Check==========
                            // $result = $this->dbL->whereRows($action_table, $action_data);
                            // print_r($result);
                            // $result_exist = $this->varL->record_exist($result);

                            // ==========Unique Fields POST Dup Check==========
                            $actual_result = [];
                            if (isset($item->unique_field)) :
                                // echo "Checking unique field";
                                $params = [];
                                foreach ($item->unique_field as $thing) :
                                    if (isset($_POST[$thing])) :
                                        $params[$thing] = $_POST[$thing];
                                    elseif (isset($action_data[$thing])) :
                                        $params[$thing] = $action_data[$thing];
                                    endif;
                                endforeach;
                                $result = $this->dbL->whereRows($action_table, $params);
                                $result_exist = $this->varL->record_exist($result);
                                if ($result_exist) :
                                    $actual_result = $result;
                                endif;
                            endif;
                            if (isset($item->unique)) :
                                // echo "Checking unique";
                                foreach ($item->unique as $key => $value) :
                                    $result = $this->dbL->whereRows($action_table, [$key => $value]);
                                    if ($result_exist == false) :
                                        $result_exist = $this->varL->record_exist($result);
                                    endif;
                                endforeach;
                            endif;
                            $allow_insert = !$result_exist;
                            if ($result_exist) :
                                $affected_id = $actual_result[0]->id;
                            endif;
                        endif;
                        if ($allow_insert) :
                        // echo "Allow Insert<br>";
                        else :
                        // echo "Found duplicate<br>";
                        endif;

                        // ==========Sys Var==========
                        foreach ($_POST as $key => $value) :
                            if (in_array($key, ["start_date", "end_date"])) :
                                $_POST[$key] = date("Y-m-d H:i:s", strtotime($_POST[$key]));
                            endif;
                        endforeach;
                        $action_data['created'] = $_POST['created'] = $this->dtL->currentDT();

                        if (strpos($_POST['password'], '$2y$10$') !== false) :
                        else :
                            $_POST['password'] = $this->userM->encryptPassword($_POST['password']); // One way only for now
                        endif;
                        foreach ($_POST as $key => $value) :
                            if (in_array($key, ['title', 'content', 'description'])) :
                                $_POST[$key] = json_encode($_POST[$key]);
                            endif;
                        endforeach;
                        // echo $_POST['password'];
                        // echo "Changed data to system variables<br>";

                        // ==========Switch Action==========
                        // echo "Current action: $action_type<br>";
                        switch ($action_type):
                            case ("add"):
                                if ($allow_insert) :
                                    // echo "Adding<br>";
                                    // print_r($action_data);
                                    foreach ($action_data as $key => $value) :
                                        if ($value == "_lastAffectedID") :
                                            $_POST[$key] = $last_affected_id;
                                        elseif ($value == "_firstAffectedID") :
                                            $_POST[$key] = $first_affected_id;
                                        else :
                                            $_POST[$key] = $value;
                                        endif;
                                    endforeach;
                                    // print_r($action_data);
                                    $affected_id = $this->dbL->insertPOST($action_table, $column_list);
                                endif;
                                break;
                            case ("edit"):
                                // echo "Editing<br>";
                                foreach ($action_data as $key => $value) :
                                    $_POST[$key] = $value;
                                endforeach;
                                if (count($action_where) > 0) :
                                    $affected_id = $this->dbL->updatePOST($action_table, $column_list, $action_where);
                                endif;
                                break;
                            case ("delete"):
                                $affected_id = $this->dbL->removeRows($action_table, $action_where);
                                break;
                            case ("logout"):
                                $location = "/user/logout";
                                break;
                            case ("update"):
                                // echo "Updating<br>";
                                $affected_id = $this->dbL->updateRows($action_table, $action_data, $action_where);
                                break;
                            case ("insert"):
                                if ($allow_insert) :
                                    // echo "Inserting<br>";
                                    $affected_id = $this->dbL->insertRows($action_table, $action_data);
                                endif;
                                break;
                            case ("view"):
                            default:
                                break;
                        endswitch;

                        // ==========Affected ID==========
                        // echo "Insert Count: $insert_count<br>";
                        if ($insert_count == 0) :
                            $first_affected_id = $affected_id;
                        endif;
                        $last_affected_id = $affected_id;
                        $insert_count += 1;
                        array_push($all_affected_id, $affected_id);
                        // echo "First Affected ID: $first_affected_id<br>";
                        // echo "Last Affected ID: $last_affected_id<br>";
                        // print_r($all_affected_id);
                        // echo "<br>";
                        $affected_id = implode(", ", $all_affected_id);
                    endforeach;
                endif;

                $params = [
                    "first_affected_id" => $first_affected_id,
                    "last_affected_id" => $last_affected_id,
                    "all_affected_id" => $all_affected_id,
                    "insert_count" => $insert_count,
                    "onlyif" => $onlyif,
                    "error" => $error,
                ];
                return $params;
            }

            public function processParams($params, $action)
            {
                if ($action == "token") :
                    return $this->tokenM->getNumber($params);
                elseif ($action == "query") :
                    return $this->dataHandling($params);
                endif;
            }
        }
