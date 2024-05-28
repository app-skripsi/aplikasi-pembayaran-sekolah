<?php

namespace App\Models;

use CodeIgniter\Model;

class PengajianModel extends Model
{
	protected $table = 'penggajian';

	public function getData($id = false)
	{
		if ($id === false) {
			return $this->table('penggajian')
				->get()
				->getResultArray();
		} else {
			return $this->table('penggajian')
				->where('penggajian.id', $id)
				->get()
				->getRowArray();
		}
	}
	public function countAllpenggajian()
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
