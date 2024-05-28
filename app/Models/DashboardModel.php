<?php

namespace App\Models;

use CodeIgniter\Model;

class DashboardModel extends Model
{
    public function getCountTotalDataSpp()
	{
		return $this->db->table("spp")->countAll();
	}
    public function getCountTotalDataPenggajian()
    {
        return $this->db->table("penggajian")->countAll();
    }
}
