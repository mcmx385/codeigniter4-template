<?php

namespace App\Libraries;

class colorLib
{
    public function __construct()
    {
    }

    public static $button_class = [
        'delete' => 'danger',
        'add' => 'success',
        'edit' => 'dark',
        'view' => 'primary',
        'manage' => 'light',
        'login' => 'info',
        'logout' => 'danger',
        'extend' => 'warning',
        'chart' => 'dark',
    ];

    public static $icon_class = [
        'delete' => '&#xE872;',
        'add' => '&#xE147;',
        'edit' => '&#xE254;',
        'view' => 'visibility',
        'manage' => 'construction',
        'search' => 'search',
        'chart' => 'table_view',
        'extend' => 'update',
        'checklist' => 'fact_check',
    ];

    public static $color_class = [
        'delete' => 'red',
        'add' => 'green',
        'edit' => 'yellow',
        'view' => 'blue',
        'manage' => 'gray',
        'login' => 'brown',
        'search' => 'black',
        'chart' => 'grey',
        'extend' => 'blue',
        'checklist' => 'blue',
    ];

    public static $styleClass = [
        'view' => ['btn' => 'primary', 'icon' => 'visibility', 'color' => 'blue'],
        'edit' => ['btn' => 'dark', 'icon' => '&#xE254;', 'color' => 'yellow'],
        'delete' => ['btn' => 'danger', 'icon' => '&#xE872;', 'color' => 'red'],
        'add' => ['btn' => 'success', 'icon' => '&#xE147;', 'color' => 'green'],
        'insert' => ['btn' => 'primary', 'icon' => '&#xE147;', 'color' => 'green'],
        'manage' => ['btn' => 'light', 'icon' => 'construction', 'color' => 'gray'],
        'login' => ['btn' => 'info', 'icon' => 'login', 'color' => 'brown'],
        'logout' => ['btn' => 'danger', 'icon' => 'exit_to_app', 'color' => 'red'],
        'extend' => ['btn' => 'warning', 'icon' => 'update', 'color' => 'blue'],
        'chart' => ['btn' => 'dark', 'icon' => 'table_view', 'color' => 'gray'],
        'checklist' => ['btn' => 'warning', 'icon' => 'fact_check', 'color' => 'blue'],
        'search' => ['btn' => 'primary', 'icon' => 'search', 'color' => 'black'],
        'return' => ['btn' => 'dark', 'icon' => 'undo', 'color' => 'white'],
    ];
}
