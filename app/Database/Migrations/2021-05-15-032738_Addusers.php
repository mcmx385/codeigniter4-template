<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Addusers extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'          => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'name'       => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
			],
			'email' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
			],
			'phone' => [
				'type'           => 'INT',
				'constraint'     => 11,
			],
			'password' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
			],
			'rank' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
			],
			'token' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
			],
			'token_created' => [
				'type' => 'DATETIME',
			],
			'last_active' => [
				'type' => 'DATETIME',
			],
			'created_at datetime default current_timestamp',
			'updated_at datetime default current_timestamp on update current_timestamp',
			'deleted_at datetime default current_timestamp on update current_timestamp',
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('users');
	}

	public function down()
	{
		$this->forge->dropTable('users');
	}
}
