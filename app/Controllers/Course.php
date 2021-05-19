<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Course extends BaseController
{
	public function __construct()
	{
		$this->lecAttendM = new \App\Models\LectureAttendance();
		$this->courseStdM = new \App\Models\Coursestudent();
	}
	public function students($course_id)
	{
		$this->userL->autoLogout();
		$students = $this->courseStdM->getAllStudentsWithInfo($course_id);
		$this->template->teacher('course/students', ['students' => $students]);
	}
}
