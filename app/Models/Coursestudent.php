<?php

namespace App\Models;

use CodeIgniter\Model;

class Coursestudent extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'course_student';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'object';
	protected $useSoftDelete        = false;
	protected $protectFields        = true;
	protected $allowedFields        = [];

	// Dates
	protected $useTimestamps        = false;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

	// Validation
	protected $validationRules      = [];
	protected $validationMessages   = [];
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks       = true;
	protected $beforeInsert         = [];
	protected $afterInsert          = [];
	protected $beforeUpdate         = [];
	protected $afterUpdate          = [];
	protected $beforeFind           = [];
	protected $afterFind            = [];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];

	public function getAllStudents($course_id)
	{
		return $this->select('student_id')->where('course_id', $course_id)->findAll();
	}
	public function getStudentCourse($student_id)
	{
		return $this->select('courses.course_id, courses.name, courses.code, users.name as teacher_name')
			->where('student_id', $student_id)
			->join('courses', 'course_student.course_id=courses.course_id', 'left')
			->join('users', 'users.id=courses.teacher_id', 'left')
			->get()->getResult();
	}
	public function getAllStudentsWithInfo($course_id)
	{
		return $this->db->table('course_student')
			->select('users.id as student_id, name')
			->where('course_student.course_id', $course_id)
			->join('users', 'users.id=course_student.student_id', 'left')
			->get()->getResult();
	}
	public function countStudentCourse($student_id)
	{
		return count($this->getStudentCourse($student_id));
	}
}
