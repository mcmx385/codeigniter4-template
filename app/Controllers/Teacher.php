<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Teacher extends BaseController
{
	public function __construct()
	{
		$this->courseM = new \App\Models\Course();
		$this->lecAttendM = new \App\Models\lectureAttendance();
		$this->courseLecM = new \App\Models\CourseLecture();
	}
	public function index()
	{
		$user_id = $this->userL->autoLogout();
		$this->userL->autoRedirectRank('teacher');
		$count = $this->courseM->countTeacherCourse($user_id);
		$this->template->teacher('teacher/index', ['count' => $count]);
	}
	public function courses()
	{
		$userid = $this->userL->autoLogout();
		$this->userL->autoRedirectRank('teacher');
		$teacher_courses = $this->courseM->getTeacherCourse($userid);
		$this->template->teacher('teacher/courses', ['teacher_courses' => $teacher_courses]);
	}
}
