<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Student extends BaseController
{
	public function __construct()
	{
		$this->courseStdM = new \App\Models\Coursestudent();
	}
	public function index()
	{
		$userid = $this->userL->autoLogout();
		$this->userL->autoRedirectRank('student');
		$count = $this->courseStdM->countStudentCourse($userid);
		$this->template->student('student/index', ['count' => $count]);
	}
	public function courses()
	{
		$userid = $this->userL->autoLogout();
		$this->userL->autoRedirectRank('student');

		$courses = $this->courseStdM->getStudentCourse($userid);
		$this->template->student('student/courses', ['courses' => $courses]);
	}
}
