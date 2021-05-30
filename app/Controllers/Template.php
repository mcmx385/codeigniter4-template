<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Template extends Controller
{
    public function user($page = 'home/index', $data = [], $title = 'User')
    {
        echo view('templates/user', ['page' => 'pages/' . $page, 'data' => $data, 'title' => $title]);
    }
    public function admin($page = 'home', $data = [], $title = 'Admin')
    {
        echo view('templates/admin', ['page' => 'pages/' . $page, 'data' => $data, 'title' => $title]);
    }
}
