<?php

namespace App\Models;

use CodeIgniter\Model;

class SiswaModel extends Model
{
	protected $table = 'siswa';

	public function getData($id = false)
	{
		if ($id === false) {
			return $this->table('siswa')
				->join('kelas', 'kelas.id = siswa.kelas_id')
				->get()
				->getResultArray();
		} else {
			return $this->table('siswa')
				->join('kelas', 'kelas.id = siswa.kelas_id')
				->where('siswa.id', $id)
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
