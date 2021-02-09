<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');

class M_referensi extends CI_Model {

	function GetReferensi($get){
        $tabel = 'ref_'.$get;
		$query = $this->db->select('*')
                    ->order_by('id_reference', 'ASC')
                    ->get($tabel);
        return $query->result();   
	}

    function GetFungsiKK(){
        $query = $this->db->order_by('id_fungsi_kk', 'ASC')->get("fungsi_kk");
        return $query->result();   
    }

	function GetDetailKK($regkk){
		$query = $this->db->where('reg_kk', $regkk)->limit(1)->get("kawasan");
        return $query->row();   
	}

    function GetKodeSatkerKK($regkk){
        $row = $this->GetDetailKK($regkk);
        return $row->satker_kode;   
    }

	function GetKKSatkerKelompok($kodesatker){
		$query = $this->db->select("reg_kk, CONCAT(fungsi_kk.short_name, '. ', kawasan.nama_kk) as nama_kk", FALSE)
                          ->join('fungsi_kk', 'kawasan.fungsi_kk_id = fungsi_kk.id_fungsi_kk','left outer')
                          ->where('satker_kode', $kodesatker)
                          ->group_by('reg_kk')
                          ->order_by('nama_kk', 'ASC')
						  ->get("kawasan");
        return $query->result();   
	}

    function GetKKSatker($kodesatker){
        $query = $this->db->join('fungsi_kk', 'kawasan.fungsi_kk_id = fungsi_kk.id_fungsi_kk','left outer')
                          ->where('satker_kode', $kodesatker)
                          ->order_by('nama_kk', 'ASC')
                          ->get("kawasan");
        return $query->result();   
    }

    function GetAllKK(){
        $query = $this->db->join('fungsi_kk', 'kawasan.fungsi_kk_id = fungsi_kk.id_fungsi_kk','left outer')
                          ->group_by('reg_kk')
                          ->order_by('nama_kk', 'ASC')
                          ->get("kawasan");
        return $query->result();   
    }

	function GetRegKKSatker($kodesatker){
		$query = $this->db->select('DISTINCT(reg_kk)')->from('kawasan')->where('satker_kode', $kodesatker)->get();
		$val_reg_kk = "";
        $c_reg_kk = $query->num_rows();
        $record = $query->result();
        $i=0;
        foreach ($record as $row) {
            $x=$c_reg_kk-1;
            $val_reg_kk .= $row->reg_kk;
            if ($i != $x) {
                $val_reg_kk .= ";";
            }
            $i++;
        }     
        return $val_reg_kk;   
	}

	function GetProvinsiIDKK($regkk){
        $query = $this->db->select('prov_id')->from('kawasan')->where('reg_kk', $regkk)->get();
        $c_provinsi = $query->num_rows();
        $row = $query->row();
        $arr_prov = explode(';', $row->prov_id);
        
        $val_prov = "";
        $x = count($arr_prov);
        $main = array();
        for ($i=0; $i < $x; $i++) { 
            $query = $this->db->select('id_prov,nama_prov')
                ->where(array('id_prov'=>$arr_prov[$i]))->get("adm_daerah");
            $record = $query->row();
            $main[] = array('id' => $record->id_prov, 'text' => $record->nama_prov, 'selected' => true);

        }
        return json_encode($main);   
	}

	function GetProvinsiIDSatker($kodesatker){
		$query = $this->db->select('prov_id')->from('satker')->where('kode_satker', $kodesatker)->get();
		$c_provinsi = $query->num_rows();
        $row = $query->row();
        $arr_prov = explode(';', $row->prov_id);
        
        $val_prov = "";
        $x = count($arr_prov);
        $main = array();
        for ($i=0; $i < $x; $i++) { 
            $query = $this->db->select('id_prov,nama_prov')
                ->where(array('id_prov'=>$arr_prov[$i]))->get("adm_daerah");
            $record = $query->row();
            $main[] = array('id' => $record->id_prov, 'text' => $record->nama_prov, 'selected' => true);

        }
        return json_encode($main);   
	}

	function GetSatker(){
		$query = $this->db->select('DISTINCT(kode_satker), nama_satker')->order_by('nama_satker', 'ASC')->get("satker");
        return $query->result();   
	}

    function GetDetailSatker($kodesatker){
        $query = $this->db->select("*")
                    ->where('kode_satker',$kodesatker)
                    ->limit(1)
                    ->get("satker");
        return $query->result();   
    }

    function GetDetailSatkerRow($kodesatker){
        $query = $this->db->select("*")
                    ->where('kode_satker',$kodesatker)
                    ->limit(1)
                    ->get("satker");
        return $query->row();   
    }

	function GetProvinsi($id){
		$query = $this->db->select("id_prov, nama_prov")
                    ->where('id_prov',$id)
                    ->limit(1)
                    ->get("adm_daerah");
        return $query->row();   
	}

	function GetAllProvinsi(){
		$query = $this->db->select("DISTINCT(id_prov), nama_prov")
                    ->order_by("id_prov", "ASC")
                    ->get("adm_daerah");
        return $query->result();   
	}

	function GetKabKota($id){
		$query = $this->db->select("id_prov, nama_prov, id_kab_kota, nama_kab_kota")
                    ->where('id_kab_kota',$id)
                    ->limit(1)
                    ->get("adm_daerah");
        return $query->row();   
	}

    function GetAllKabKota($id){
        $query = $this->db->select("DISTINCT(id_kab_kota), nama_kab_kota")
                    ->where('id_prov',$id)
                    ->order_by("id_kab_kota", "ASC")
                    ->get("adm_daerah");
        return $query->result();   
    }

	function GetKec($id){
		$query = $this->db->select("id_kec, nama_kec, id_prov, nama_prov, id_kab_kota, nama_kab_kota")
                    ->where('id_kec',$id)
                    ->limit(1)
                    ->get("adm_daerah");
        return $query->row();   
	}

    function GetAllKec($id){
        
        $query = $this->db->select("DISTINCT(id_kec), nama_kec")
                    ->where('id_kab_kota',$id)
                    ->order_by("id_kec", "ASC")
                    ->get("adm_daerah");
        return $query->result();   
    }

	function GetDesa($id){
		$query = $this->db->select("*, adm_daerah.updated_at as last_update")
                    ->join('users', 'adm_daerah.user_input = users.id_user','left outer')
                    ->where('id_desa',$id)
                    ->limit(1)
                    ->get("adm_daerah");
        return $query->row();   
	}

    function GetSelectedDesaKelompok($value){
        $arr_desa = explode(';', $value);
        
        $val_desa = "";
        $x = count($arr_desa);
        $main = array();
        for ($i=0; $i < $x; $i++) { 
            $query = $this->db->select('id_desa,nama_desa,nama_kec')
                ->where(array('id_desa'=>$arr_desa[$i]))->get("adm_daerah");
            $record = $query->row();
            $main[] = array('id' => $record->id_desa, 'text' => $record->nama_desa.'/ KEC.'.$record->nama_kec, 'selected' => true);

        }
        return json_encode($main);  
    }

    function GetSelectedDesaKelompokView($value){
        $arr_desa = explode(';', $value);
        
        $val_desa = "";
        $x = count($arr_desa);
        $main = array();
        for ($i=0; $i < $x; $i++) { 
            $query = $this->db->select('id_desa,nama_desa,nama_kec')
                ->where(array('id_desa'=>$arr_desa[$i]))->get("adm_daerah");
            $record = $query->row();
            $val_desa = "";
            $main[] = array('id' => $record->id_desa, 'text' => $record->nama_desa.'/ KEC.'.$record->nama_kec, 'selected' => true);

        }
        return json_encode($main);  
    }

    function GetReffSelected($get,$value){
        $main = array();
        if ($value != "") {
        $arr_data = explode(';', $value);
        
        $val_data = "";
        $x = count($arr_data);
        
        
            for ($i=0; $i < $x; $i++) { 
                $query = $this->db->select('*')
                    ->where(array('id_reference'=>$arr_data[$i]))->get('ref_'.$get);
                $record = $query->row();
                $main[] = array('id' => $record->id_reference, 'text' => $record->detail_1, 'selected' => true);
            }
        }
            
        return json_encode($main);  
        //return $x;
    }

    function GetDetailKelompok($id){
        $query = $this->db->select("*")
                          ->join('satker as S', 'kelompok.satker_kode = S.kode_satker','left outer')
                          ->join('kawasan as K', 'kelompok.kk_reg = K.reg_kk','left outer')
                          ->join('fungsi_kk as F', 'K.fungsi_kk_id = F.id_fungsi_kk','left outer')
                          ->where('id_kelompok',$id)
                          ->limit(1)
                          ->get("kelompok");
        return $query->row();
    }

    function GetAllKelompok(){
        $query = $this->db->select("*")
                          ->join('satker as S', 'kelompok.satker_kode = S.kode_satker','left outer')
                          ->join('kawasan as K', 'kelompok.kk_reg = K.reg_kk','left outer')
                          ->group_by('id_kelompok')
                          ->order_by('id_kelompok', 'DESC')
                          ->get("kelompok");
        return $query->result();
    }

    function GetKelompokSatker($satkerkode){
        $query = $this->db->select("*")
                          ->join('satker as S', 'kelompok.satker_kode = S.kode_satker','left outer')
                          ->join('kawasan as K', 'kelompok.kk_reg = K.reg_kk','left outer')
                          ->where('kelompok.satker_kode', $satkerkode)
                          ->group_by('id_kelompok')
                          ->order_by('id_kelompok', 'DESC')
                          ->get("kelompok");
        return $query->result();
    }

    function GetDesaKelompok($value){
        $arr_desa = explode(';', $value);
        
        $val_desa = "";
        $x = count($arr_desa);
        $query = $this->db->select('*')
                    ->where(array('id_desa'=>$arr_desa[0]))->get("adm_daerah");
        return $query->row();   
    }

    function GetAllDesa($id){
        $query = $this->db->select("id_desa, CONCAT(adm_daerah.nama_desa, ' / KEC. ',adm_daerah.nama_kec) as nama_desa", FALSE)
                    ->join('kawasan as K', 'FIND_IN_SET(adm_daerah.id_prov, K.prov_id)','INNER',false)
                    ->where('reg_kk',$id)
                    ->order_by("id_desa", "ASC")
                    ->get("adm_daerah");
        return $query->result();   
    }

	
	function UpdateUser($id,$data){
		$data['UpdateBy'] = $_SESSION['User']['Username'];
		return $this->Update("tb_master_user",array('UserId'=>$id),$data);
	}

	function GetUserProfile($ProfileId){
		return $this->Select("tb_master_userprofile",array('ProfileId'=>$ProfileId))[0];	
	}
}
/* eof admin/models/M_user.php */
?>