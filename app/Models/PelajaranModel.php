<?php

namespace App\Models;

use CodeIgniter\Model;

class PelajaranModel extends Model
{
    protected $table            = 'pelajaran';
	public function getData($id = false)
	{
		if ($id === false) {
			return $this->table('pelajaran')
				->get()
				->getResultArray();
		} else {
			return $this->table('pelajaran')
				->where('pelajaran.id', $id)
				->get()
				->getRowArray();
		}
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
