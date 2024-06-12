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
				->join('guru', 'guru.id = penggajian.guru_id')
				->get()
				->getResultArray();
		} else {
			return $this->table('penggajian')
				->join('guru', 'guru.id = penggajian.guru_id')
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

	public function getStatusPembayaranEnum()
    {
        // Lakukan query untuk mendapatkan nilai-nilai unik dari kolom status_pembayaran
        $query = $this->db->query('SHOW COLUMNS FROM '.$this->table.' WHERE Field = "status"');
        $row = $query->getRow();
        
        // Parsing nilai-nilai enum dari string
        preg_match("/^enum\(\'(.*)\'\)$/", $row->Type, $matches);
        $enumValues = explode("','", $matches[1]);

        return $enumValues;
    }

	    public function getPengajianById($id)
    {
        // Mengambil data pengajian berdasarkan ID
        return $this->db->table($this->table)
            ->where('id', $id)
            ->get()
            ->getRowArray();
    }
	

}
