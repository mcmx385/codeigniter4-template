<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CoursestudentSeeder extends Seeder
{
	public function run()
	{
		$data = [
			[
				'course_id' => 1,
				'student_id' => 2,
			],
			[
				'course_id' => 1,
				'student_id' => 3,
			],
			[
				'course_id' => 1,
				'student_id' => 4,
			],
			[
				'course_id' => 1,
				'student_id' => 5,
			],
		];

		$builder = $this->db->table('course_student');
		$builder->truncate('course_student');
		$builder->insertBatch($data);
		echo (string) $this->db->getLastQuery();
	}
}
