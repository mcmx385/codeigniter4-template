<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Courses extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'course_id' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'code'       => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
			],
			'name'       => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
			],
			'teacher_id' => [
				'type' => 'INT',
				'constraint' => 11,
			]
		]);
		$this->forge->addKey('course_id', true);
		$this->forge->createTable('courses');
	}

	public function down()
	{
		$this->forge->dropTable('courses');
	}
}
