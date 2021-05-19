<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CourseLecture extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'lecture_id' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'course_id' => [
				'type'           => 'INT',
				'constraint'     => 11,
			],
			'date' => [
				'type' => 'DATE',
			],
			'start_time' => [
				'type' => 'TIME',
			],
			'end_time' => [
				'type' => 'TIME',
			],
		]);
		$this->forge->addKey('lecture_id', true);
		$this->forge->createTable('course_lecture');
	}

	public function down()
	{
		$this->forge->dropTable('course_lecture');
	}
}
