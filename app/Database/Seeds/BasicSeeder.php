<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BasicSeeder extends Seeder
{
	public function run()
	{
		$this->call('UserSeeder');
	}
}
