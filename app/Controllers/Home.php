<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function __construct()
    {
        $this->template = new \App\Controllers\Template();
    }
	public function index()
	{
		$this->template->user('home/index');
	}
}
