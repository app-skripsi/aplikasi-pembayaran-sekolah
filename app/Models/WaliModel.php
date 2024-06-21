<?php

namespace App\Models;

use CodeIgniter\Model;

class WaliModel extends Model
{
	protected $table            = 'wali';
	public function getData($id = false)
	{
		if ($id === false) {
			return $this->table('wali')
				->get()
				->getResultArray();
		} else {
			return $this->table('wali')
				->where('wali.id', $id)
				->get()
				->getRowArray();
		}
	}
	public function countAllGuru()
    {
        return $this->countAll();
    }
	public function insertData($data)
	{
		return $this->db->table($this->table)->insert($data);
	}

	public function updateData($data, $id)
	{
		return $this->db->table($this->table)->update($data, ['id' => $id]);
	}
	public function deleteData($id)
	{
		return $this->db->table($this->table)->delete(['id' => $id]);
	}
}
