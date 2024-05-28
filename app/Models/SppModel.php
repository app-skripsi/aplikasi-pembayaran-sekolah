<?php

namespace App\Models;

use CodeIgniter\Model;

class SppModel extends Model
{
    protected $table = 'spp';

	public function getData($id = false)
	{
		if ($id === false) {
			return $this->table('spp')
				->get()
				->getResultArray();
		} else {
			return $this->table('spp')
				->where('spp.id', $id)
				->get()
				->getRowArray();
		}
	}
	public function countAllSpp()
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

	public function getDataByNIS($nis)
	{
		return $this->table('spp')
			->where('siswa.nis', $nis)
			->get()
			->getResultArray();
	}
}
