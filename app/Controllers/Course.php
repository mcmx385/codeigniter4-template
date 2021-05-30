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
		$students = $this->userM->getUserByRank('student');
		$this->template->teacher('course/students', ['students' => $students, 'course_id' => $course_id]);
	}
	public function student_attendance($course_id = null, $student_id = null)
	{
		if ($course_id !== null && $student_id !== null) {
			$student_records = $this->lecAttendM->getStdAllAttend($course_id, $student_id);
		}
		$this->template->teacher('course/student_attendance', ['student_records' => $student_records]);
	}
}
