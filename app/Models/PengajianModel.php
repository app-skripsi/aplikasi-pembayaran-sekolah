<?php

namespace App\Models;

use CodeIgniter\Model;

class PengajianModel extends Model
{
	protected $table = 'pengajian';

	public function getData($id = false)
	{
		if ($id === false) {
			return $this->table('pengajian')
				->join('guru', 'guru.id = pengajian.guru_id')
				->get()
				->getResultArray();
		} else {
			return $this->table('pengajian')
				->join('guru', 'guru.id = pengajian.guru_id')
				->where('pengajian.id', $id)
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
