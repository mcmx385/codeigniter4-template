<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class LectureAttendance extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'attendance_id' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'lecture_id' => [
				'type'           => 'INT',
				'constraint'     => 11,
			],
			'student_id' => [
				'type'           => 'INT',
				'constraint'     => 11,
			],
		]);
		$this->forge->addKey('attendance_id', true);
		$this->forge->createTable('lecture_attendance');
	}

	public function down()
	{
		$this->forge->dropTable('lecture_attendance');
	}
}
