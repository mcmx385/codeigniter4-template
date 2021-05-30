<?php

namespace App\Models;

use CodeIgniter\Model;

class LectureAttendance extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'lecture_attendance';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'object';
	protected $useSoftDelete        = false;
	protected $protectFields        = false;
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

	public function getLecAttend($lecture_id)
	{
		return $this->where('lecture_id', $lecture_id)->findAll();
	}
	public function checkStdAttend($lecture_id, $student_id)
	{
		$result = $this->where('lecture_id', $lecture_id)->where('student_id', $student_id)->findAll();
		return count($result) > 0;
	}
	public function regStdAttend($lecture_id, $student_id)
	{
		if ($this->checkStdAttend($lecture_id, $student_id)) {
			return 0;
		}
		$data = [
			'lecture_id' => $lecture_id,
			'student_id' => $student_id
		];
		return $this->save($data);
	}
	public function getStdAllAttend($course_id, $student_id)
	{
		return $this->db->table('course_lecture')
			->select('course_lecture.lecture_id, date, start_time, end_time, attendance_id')
			->where('course_lecture.course_id', $course_id)
			->where('lecture_attendance.student_id', $student_id)
			->join('lecture_attendance', 'lecture_attendance.lecture_id=course_lecture.lecture_id', 'left')
			->get()->getResult();
	}
}
