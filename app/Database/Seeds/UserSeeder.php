<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
	public function run()
	{
		$data = [
			[
				'name' => 'Liu',
				'password' => 'password',
				'rank' => 'teacher',
			],
			[
				'name' => 'Yan',
				'password' => 'password',
				'rank' => 'teacher',
			],
			[
				'name' => 'Pang',
				'password' => 'password',
				'rank' => 'teacher',
			],
			[
				'name' => 'admin',
				'password' => 'password',
				'rank' => 'admin',
			],
			[
				'name' => 'student',
				'password' => 'password',
				'rank' => 'student',
			],
			[
				'name' => 'teacher',
				'password' => 'password',
				'rank' => 'teacher',
			],
		];

		$builder = $this->db->table('users');
		$builder->truncate('users');
		$builder->insertBatch($data);
		echo (string) $this->db->getLastQuery();
	}
}
