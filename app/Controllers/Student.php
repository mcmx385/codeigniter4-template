<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Student extends BaseController
{
	public function __construct()
	{
		$this->courseStdM = new \App\Models\Coursestudent();
		$this->courseM = new \App\Models\Course();
	}
	public function index()
	{
		$this->userL->autoLogout();
		$this->userL->autoRedirectRank('student');
		$count = $this->courseM->countAllCourse();
		$this->template->student('student/index', ['count' => $count]);
	}
	public function courses()
	{
		$this->userL->autoLogout();
		$courses = $this->courseM->getAllCourse();
		$this->template->student('student/courses', ['courses' => $courses]);
	}
}
