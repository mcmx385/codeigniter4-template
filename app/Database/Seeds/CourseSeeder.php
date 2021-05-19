<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CourseSeeder extends Seeder
{
	public function run()
	{
		$data = [
			[
				'name' => 'Computer Organization',
				'code' => 'AST10201',
				'teacher_id' => 1,
			],
			[
				'name' => 'Understanding the Network-Centric World',
				'code' => 'AST10303',
				'teacher_id' => 2,
			],
			[
				'name' => 'Introduction to Programming',
				'code' => 'AST10106',
				'teacher_id' => 3,
			],
		];

		$builder = $this->db->table('courses');
		$builder->truncate('courses');
		$builder->insertBatch($data);
		echo (string) $this->db->getLastQuery();
	}
}
