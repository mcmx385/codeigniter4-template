<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Admin extends BaseController
{
	public function __construct()
	{
		$this->userM = new \App\Models\User();
		$this->utilL = new \App\Libraries\utilLib();
		$this->urlL = new \App\Libraries\urlLib();
		$this->fileL = new \App\Libraries\fileLib();
		$this->inputm = new \App\Libraries\inputLib();
		$this->tableL = new \App\Libraries\tableLib();
		$this->translateM = new \App\Models\Translate();
		$this->widgetL = new \App\Libraries\widgetLib();
		$this->zip = $this->fileL->zip;
		$this->locale = service('request')->getLocale();
		$this->tokenL = new \App\Libraries\AjaxTokens\Token();
	}
	public function index()
	{
		$this->template->admin('admin/index');
	}
	public function tables()
	{
		$this->template->admin('admin/tables');
	}

	public function chart($table = "users_details")
	{
        $this->userL->autoLogout();
		echo 'hi';
		$this->userM->adminSecurity();

		$data = $this->tableL->standard($table);
		$data['title'] = $this->translateM->getWord("zh-hk", $table);

		$table_string = explode("_", $table);
		array_pop($table_string);
		$data['table'] = implode("_", $table_string);

		$data['tableL'] = $this->tableL;
		$data['widgetL'] = $this->widgetL;

		return $this->template->back('master/util/chart', $data);
	}
}
