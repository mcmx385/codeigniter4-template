<?php
// Accept [$params]

$styleClass = [
    "view" => ["btn" => "primary", "icon" => "visibility", "color" => "blue"],
    "edit" => ["btn" => "dark", "icon" => "&#xE254;", "color" => "yellow"],
    "delete" => ["btn" => "danger", "icon" => "&#xE872;", "color" => "red"],
    "add" => ["btn" => "success", "icon" => "&#xE147;", "color" => "green"],
    "manage" => ["btn" => "light", "icon" => "construction", "color" => "gray"],
    "login" => ["btn" => "info", "icon" => "login", "color" => "brown"],
    "logout" => ["btn" => "danger", "icon" => "exit_to_app", "color" => "red"],
    "extend" => ["btn" => "warning", "icon" => "update", "color" => "blue"],
    "chart" => ["btn" => "dark", "icon" => "table_view", "color" => "gray"],
    "checklist" => ["btn" => "warning", "icon" => "fact_check", "color" => "blue"],
    "search" => ["btn" => "primary", "icon" => "search", "color" => "black"],
    "return" => ["btn" => "dark", "icon" => "undo", "color" => "white"],
];

// Setup variables
$def_params = [
    "action" => "view", // Action is used for icon and cap text by default

    "class" => [],
    "color" => "",
    "token" => "", // Token module dependency
    "link" => "#",
    "btn" => false,

    "icon" => "def", // By default find icon type with icon list
    "text" => "def", // By default uses action as name and cap
];
$params = array_replace_recursive($def_params, $params);
// print_r($params);
$action = $params["action"];

// Handle token
if (!empty($params["token"])) :
    array_push($params["class"], "uni_modal");
endif;

// Handle text
if ($params["text"] == "def") :
    $params["text"] = ucfirst($action);
elseif ($params["text"] == "hide") :
    $params["text"] = "";
endif;

// Handle icon
if ($params["icon"] == "def" && $params["icon"] !== "none") :
    $params["icon"] = $styleClass[$action]["icon"];
    if (!$params["btn"]) :
        $params["color"] = $styleClass[$action]["color"];
    endif;
endif;

// Handle button
if ($params["btn"]) :
    array_push($params["class"], "btn");
    $btnType = $styleClass[$action]["btn"];
    array_push($params["class"], "btn-$btnType");
endif;

// Empty link
if ($params['link'] == "") :
    $params['link'] = "#";
endif;

// Display button
?>
<a href="<?php echo $params["link"]; ?>" <?php if (!empty($params['id'])) : echo "id='" . $params['id'] . "'";
                                            endif;
                                            if (!empty($params['token'])) :
                                                echo "data-id='" . $params['token'] . "'";
                                            endif;
                                            ?> <?php
                                                if (!empty($params['tab']) && $params['tab']) :
                                                    echo "target='_blank'";
                                                endif;
                                                ?> class="<?php echo implode(" ", $params["class"]); ?>" style="color:<?php echo $params["color"]; ?>;">
    <?php
    if ($params["icon"] !== "none") :
    ?>
        <i class="material-icons" style="font-size: <?php if ($params["text"] == "") : echo "140%";
                                                    else : echo "100%";
                                                    endif; ?>;"><?php echo $params["icon"]; ?></i>
    <?php
    endif;
    ?>
    <?php echo $params["text"]; ?>
</a>