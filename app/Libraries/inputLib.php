<?php

namespace App\Libraries;

class inputLib
{
    public function __construct()
    {
        $this->dbL = new \App\Libraries\dbLib();
    }
    public function assocSelect($form, $name, $value = "")
    {
        $element = "";
        $dropdown_result = $this->dbL->whereRows("dropdown", [
            "form" => $form,
            "name" => $name,
        ]);
        if (count($dropdown_result) > 0) :
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
                $assoc_result = $this->dbL->whereRows($assoc_table, [], ["select" => [$assoc_field, $show_field]]);
                $element = 'assoc_select';
            endif;
        endif;
        $input_attr = "";
        switch ($element):
            case ("select"):
                $empty_field = $value == "";
?>
                <select <?php echo $input_attr; ?> class="form-control w-100" name="<?php echo $name; ?>" title="<?php echo $name; ?>">
                    <?php
                    $count = 0;
                    foreach ($items as $thing) {
                    ?>
                        <option <?php if (strtolower($thing) == strtolower($value) || ($empty_field && $count == 0)) :
                                    echo "selected";
                                endif; ?> value='<?php if (preg_match("/\p{Han}+/u", $thing)) : echo ($thing);
                                                    else : echo urlencode($thing);
                                                    endif; ?>'><?php echo ucfirst($thing); ?></option>
                    <?php
                        $count += 1;
                    }
                    ?>
                </select>
            <?php
                break;
            case ("assoc_select"):
            ?>
                <select <?php echo $input_attr; ?> class="form-control w-100" name="<?php echo $name; ?>" title="<?php echo $name; ?>">
                    <?php
                    foreach ($assoc_result as $thing) :
                    ?>
                        <option <?php if (strtolower($thing->$assoc_field) == strtolower($value)) {
                                    echo "selected";
                                }; ?> value='<?php echo urlencode($thing->$assoc_field); ?>'><?php echo ucfirst($thing->$show_field); ?></option>
                    <?php
                    endforeach;
                    ?>
                </select>
<?php
                break;
            default:
                break;
        endswitch;
    }
    public function getCustomSelect($name)
    {
        return $this->dbL->whereRows("dropdown", [
            "form" => "custom",
            "name" => $name,
        ])[0];
    }
    public function getmCustomSelect($list)
    {
        $result = [];
        foreach ($list as $item) :
            array_push($result, $this->getCustomSelect($item));
        endforeach;
        return $result;
    }
}
