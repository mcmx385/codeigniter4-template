<?php

namespace App\Models;

use CodeIgniter\Model;

class User extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'users';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'object';
	protected $useSoftDelete        = false;
	protected $protectFields        = true;
	protected $allowedFields        = [];

	// Dates
	protected $useTimestamps        = false;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

	// Validation
	protected $validationRules      = [];
	protected $validationMessages   = [];
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks       = true;
	protected $beforeInsert         = [];
	protected $afterInsert          = [];
	protected $beforeUpdate         = [];
	protected $afterUpdate          = [];
	protected $beforeFind           = [];
	protected $afterFind            = [];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];

	public function ifUserValid($username, $password)
	{
		$user = $this->where('name', $username)->where('password', $password)->findAll();
		return (count($user) == 1) ? $user[0] : false;
	}
	public function getUserRank($userid)
	{
		$user = $this->where('id', $userid)->first();
		return $user->rank;
	}
	public function getUsersInfoById($list)
	{
		return $this->select('id, name')->whereIn('id', $list)->findAll();
	}
	public function getUserByRank($rank)
	{
		return $this->select('id, name')->where('rank', $rank)->findAll();
	}
}
