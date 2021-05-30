<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CourseStudent extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'course_id' => [
				'type'           => 'INT',
				'constraint'     => 11,
			],
			'student_id' => [
				'type'           => 'INT',
				'constraint'     => 11,
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('course_student');
	}

	public function down()
	{
		$this->forge->dropTable('course_student');
	}
}
