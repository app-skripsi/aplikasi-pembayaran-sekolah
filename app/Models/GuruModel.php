<?php

namespace App\Models;

use CodeIgniter\Model;

class GuruModel extends Model
{
	protected $table            = 'guru';
	public function getData($id = false)
	{
		if ($id === false) {
			return $this->table('guru')
				->get()
				->getResultArray();
		} else {
			return $this->table('guru')
				->where('guru.id', $id)
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
