<?php
// Accept [$params]

$def_params = [
    "class" => [
        "col" => 6,
        "col-md" => 3,
        "col-lg" => 2,
        "py" => 3,
        "text" => "center",
    ],
    "bgcolor" => "",
    "color" => "",
    "title_size" => 2,

    "icon" => "",
    "title" => "",
    "text" => "",
    "link" => "",

    "btn" => false,
    "badge" => false,
];
$params = array_replace_recursive($def_params, $params);

// Element
if (!empty($params["link"])) :
    $link = $params['link'];
    $element_attr = "a href='$link'";
    $element_end = "a";
else :
    $element_attr = $element_end = "div";
endif;

// Class
if ($params["btn"]) :
    $class_attr = "btn";
else :
    $class_attr = "card ";
endif;
foreach ($params["class"] as $key => $value) :
    $class_attr .= " $key-$value";
endforeach;

// Id Area
if (!empty($params['id'])) :
    $id_area = "id='" . $params['id'] . "'";
else :
    $id_area = '';
endif;

// Display Card
?>
<<?php echo $element_attr; ?> <?php echo $id_area; ?> class="<?php echo $class_attr; ?>" style="color: <?php echo $params["color"]; ?>;">
    <div class="card-body">
        <i class="<?php echo $params['icon']; ?> fa-5x"></i>
        <?php echo "<h" . $params["title_size"] . ">"; ?><?php echo $params["title"]; ?><?php echo "</h" . $params["title_size"] . ">"; ?>
        <p><?php echo $params["text"]; ?></p>
    </div>
</<?php echo $element_end; ?>>