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
    public function student($page = 'home', $data = [], $title = 'Student')
    {
        echo view('templates/student', ['page' => 'pages/' . $page, 'data' => $data, 'title' => $title]);
    }
    public function teacher($page = 'home', $data = [], $title = 'Teacher')
    {
        echo view('templates/teacher', ['page' => 'pages/' . $page, 'data' => $data, 'title' => $title]);
    }
}
