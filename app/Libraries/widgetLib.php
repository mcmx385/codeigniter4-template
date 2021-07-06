<?php

namespace App\Libraries;

class widgetLib
{
    public function __construct()
    {
        $this->urlL = new \App\Libraries\urlLib();
    }
    public static $styleClass = [
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
    public function btn($params)
    {
        // Setup variables
        $def_params = [
            "action" => "view", // Action is used for icon and cap text by default

            "class" => [],
            "color" => "",
            "token" => "", // Token module dependency
            "link" => "#",
            "btn" => false,
            "modal" => "",

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
            $params["icon"] = self::$styleClass[$action]["icon"];
            if (!$params["btn"]) :
                $params["color"] = self::$styleClass[$action]["color"];
            endif;
        endif;

        // Handle button
        if ($params["btn"]) :
            array_push($params["class"], "btn");
            $btnType = self::$styleClass[$action]["btn"];
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
                                                    if (!empty($params['tab']) && $params['tab']) :
                                                        echo "target='_blank'";
                                                    endif;
                                                    if (!empty($params['modal'])) :
                                                        echo "data-toggle='modal' data-target='#" . $params['modal'] . "'";
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
    <?php
    }
    public function card($params)
    {
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

        // Display Card
    ?>
        <<?php echo $element_attr; ?> <?php if (!empty($params['id'])) : echo "id='" . $params['id'] . "'";
                                        endif; ?> class="<?php echo $class_attr; ?>" style="color: <?php echo $params["color"]; ?>;">
            <div class="card-body">
                <i class="<?php echo $params['icon']; ?> fa-5x"></i>
                <?php echo "<h" . $params["title_size"] . ">"; ?><?php echo $params["title"]; ?><?php echo "</h" . $params["title_size"] . ">"; ?>
                <p><?php echo $params["text"]; ?></p>
            </div>
        </<?php echo $element_end; ?>>
    <?php
    }
    public function pagination($params)
    {
        $url_page = $params["page"];
        $total_pages = $params["total"];
        $quantity = $params["quantity"];
        $between = 2;
    ?>
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-3 d-flex justify-content-center">
                    <?php
                    // Specific page
                    ?>
                    <h6 class="mx-2 py-2">往頁</h6>
                    <div style="width:100px;">
                        <select class="form-control" name="page" title="Page" id="" onchange="this.form.submit();">
                            <?php
                            for ($i = 1; $i <= $total_pages; $i++) :
                            ?>
                                <option value="<?php echo $i; ?>" <?php if ($url_page == $i) : echo "selected";
                                                                    endif; ?>><?php echo $i; ?></option>
                            <?php
                            endfor;
                            ?>
                        </select>
                    </div>
                </div>
                <!-- <div class="d-none d-md-block col-1"></div> -->
                <div class="col-12 col-md-6">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            <?php
                            // Previous button
                            $url = $_SERVER['REQUEST_URI'];
                            $previous_page = $url_page - 1;
                            $edit_url = $this->urlL->changeUrlParam($url, "page", $previous_page);
                            if ($previous_page < 1) {
                            ?>
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">上一頁</a>
                                </li>
                            <?php
                            } else {
                            ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo $edit_url; ?>" tabindex="-1">上一頁</a>
                                </li>
                                <?php
                            }

                            // Middle
                            $left = $url_page - $between;
                            $right = $url_page + $between;
                            if ($left < 1) :
                                $left_offset = 1 - $left;
                                $left = 1;
                                if ($right >= $total_pages) :
                                    $right = $total_pages;
                                else :
                                    $right += $left_offset;
                                    if ($right > $total_pages) :
                                        $right = $total_pages;
                                    endif;
                                endif;
                            endif;
                            if ($right > $total_pages) :
                                $right_offset = $right - $total_pages;
                                $right = $total_pages;
                                if ($left <= 1) :
                                    $left = 1;
                                else :
                                    $left -= $right_offset;
                                    if ($left < 1) :
                                        $left = 1;
                                    endif;
                                endif;
                            endif;
                            for ($x = $left; $x <= $right; $x++) {
                                if ($x == $url_page) {
                                ?>
                                    <li class="page-item active">
                                        <span class="page-link">
                                            <?php echo $x; ?>
                                            <span class="sr-only">(current)</span>
                                        </span>
                                    </li>
                                <?php
                                } else {
                                    $edit_url = $this->urlL->changeUrlParam($url, "page", $x);
                                ?>
                                    <li class="page-item"><a class="page-link" href="<?php echo $edit_url; ?>"><?php echo $x; ?></a></li>
                                <?php
                                }
                            }

                            // Next button
                            $next_page = $url_page + 1;
                            if ($next_page <= $total_pages) {
                                $edit_url = $this->urlL->changeUrlParam($url, "page", $next_page);
                                ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo $edit_url; ?>">下一頁</a>
                                </li>
                            <?php
                            } else {
                            ?>
                                <li class="page-item disabled">
                                    <a class="page-link" href="#">下一頁</a>
                                </li>
                            <?php
                            }
                            ?>
                        </ul>
                    </nav>
                </div>
                <div class="col-12 col-md-3 d-flex justify-content-center">
                    <h6 class="mx-2 py-2">顯示數量</h6>
                    <div style="width:100px;">
                        <select class="form-control" name="quantity" title="quantity" id="" onchange="this.form.submit();">
                            <?php
                            foreach ([1, 5, 10, 20, 50, 100, 200, 500, 1000, 9999] as $i) :
                            ?>
                                <option value="<?php echo $i; ?>" <?php if ($quantity == $i) : echo "selected";
                                                                    endif; ?>><?php echo $i; ?></option>
                            <?php
                            endforeach;
                            ?>
                        </select>
                    </div>
                </div>
                <!-- <div class="d-none d-md-block col-1"></div> -->
            </div>
        </div>
<?php
    }
}
