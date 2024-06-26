<?php

namespace App\Models;

use CodeIgniter\Model;

class KelasModel extends Model
{
    protected $table            = 'kelas';
	public function getData($id = false)
	{
		if ($id === false) {
			return $this->table('kelas')
				->get()
				->getResultArray();
		} else {
			return $this->table('kelas')
				->where('kelas.id', $id)
				->get()
				->getRowArray();
		}
	}
	public function countAllKelas()
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
