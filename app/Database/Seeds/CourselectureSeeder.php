<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CourselectureSeeder extends Seeder
{
	public function run()
	{
		$data = [
			[
				'course_id' => 1,
				'date' => '2021-05-18',
				'start_time' => '01:54:00',
				'end_time' => '06:54:00',
			],
			[
				'course_id' => 2,
				'date' => '2021-05-19',
				'start_time' => '04:54:00',
				'end_time' => '09:54:00',
			],
		];

		$builder = $this->db->table('course_lecture');
		$builder->truncate('course_lecture');
		$builder->insertBatch($data);
		echo (string) $this->db->getLastQuery();
	}
}
