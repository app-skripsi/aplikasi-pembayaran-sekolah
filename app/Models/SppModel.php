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
				->join('kelas', 'kelas.id = spp.kelas_id')
				->join('siswa', 'siswa.id = spp.siswa_id')
				->join('wali', 'wali.id = spp.wali_id')
				->get()
				->getResultArray();
		} else {
			return $this->table('spp')
				->join('kelas', 'kelas.id = spp.kelas_id')
				->join('siswa', 'siswa.id = spp.siswa_id')
				->join('wali', 'wali.id = spp.wali_id')
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

	public function getStatusPembayaranEnum()
    {
        // Lakukan query untuk mendapatkan nilai-nilai unik dari kolom status_pembayaran
        $query = $this->db->query('SHOW COLUMNS FROM '.$this->table.' WHERE Field = "status_pembayaran"');
        $row = $query->getRow();
        
        // Parsing nilai-nilai enum dari string
        preg_match("/^enum\(\'(.*)\'\)$/", $row->Type, $matches);
        $enumValues = explode("','", $matches[1]);

        return $enumValues;
    }
	public function getMetodePembayaranEnum()
    {
        // Lakukan query untuk mendapatkan nilai-nilai unik dari kolom status_pembayaran
        $query = $this->db->query('SHOW COLUMNS FROM '.$this->table.' WHERE Field = "metode_pembayaran"');
        $row = $query->getRow();
        
        // Parsing nilai-nilai enum dari string
        preg_match("/^enum\(\'(.*)\'\)$/", $row->Type, $matches);
        $enumValues = explode("','", $matches[1]);

        return $enumValues;
    }
}
