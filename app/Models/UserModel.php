<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
	protected $table = 'users';

	public function getData($id = false)
	{
		if ($id === false) {
			return $this->table('users')
				->get()
				->getResultArray();
		} else {
			return $this->table('users')
				->where('users.id', $id)
				->get()
				->getRowArray();
		}
	}

	public function cek_login($username, $password)
	{
		return $this->db->table('users')
			->where(array('username' => $username, 'password' => $password))
			->get()->getRowArray();
	}
}
