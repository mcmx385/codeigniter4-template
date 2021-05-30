<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
	public function run()
	{
		$data = [
			[
				'name' => 'user',
				'password' => 'password',
				'rank' => 'user',
			],
			[
				'name' => 'student',
				'password' => 'password',
				'rank' => 'student',
			],
			[
			],
		];

		$builder = $this->db->table('users');
		$builder->truncate('users');
		$builder->insertBatch($data);
		echo (string) $this->db->getLastQuery();
	}
}
