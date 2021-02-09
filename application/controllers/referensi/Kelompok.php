<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kelompok extends CI_Controller{
    //put your code here
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_referensi','m_referensi');
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        date_default_timezone_set('Asia/Jakarta');
    }    
    
    public function index() {
        $data['judul'] = 'Data Referensi - Kelompok Masyarakat';
        
        $reg_kk = $this->input->post('reg_kk');
        $satker_kode = $this->input->post('satker_kode');
        if ($this->session->sub_role == 4 ) {
            $satker_kode = $this->session->satker_kode;
        }
        
        if (!isset($reg_kk)){
            $reg_kk = 0;
        }
        if (!isset($satker_kode)){
            $satker_kode = 0;
        }
        $where = array();
        
        if ($satker_kode != 0 ) {
            $where['kelompok.satker_kode'] = $satker_kode;
        }
        if ($reg_kk != 0 ) {
            $where['kelompok.kk_reg'] = $reg_kk;
        }
        $data['reg_kk_exist'] = $reg_kk;
        $data['satker_exist'] = $satker_kode;
        $query = $this->db->select("*")
                ->join('satker as S', 'kelompok.satker_kode = S.kode_satker','left outer')
                ->join('kawasan as K', 'kelompok.kk_reg = K.reg_kk','left outer')
                ->join('fungsi_kk as F', 'K.fungsi_kk_id = F.id_fungsi_kk','left outer')
                ->group_by('id_kelompok')
                ->order_by('id_kelompok', 'DESC')
                ->get_where("kelompok", $where);
        if($query->num_rows() > 0){
            $data['record'] = $query->result();
        } else {
            $data['record'] = array();
        }
        
        $data['dataSatker'] = $this->m_referensi->GetSatker();
        if ($this->session->sub_role == 4 || $satker_kode != 0) {
            $data['dataKK'] = $this->m_referensi->GetKKSatker($satker_kode);
        } else {
            $data['dataKK'] = $this->m_referensi->GetAllKK();
        }
            
        $data['dataProv'] = $this->m_referensi->GetAllProvinsi();
        
        $this->load->view('kelompok/index.php',$data);
    }

    
    public function add() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $data['judul'] = "Tambah Data Kelompok Masyarakat";
        $flag = $this->input->get('flag');
        $id_pdskk = $this->input->get('id_pdskk');
        if ($flag != 1 || $flag != 2 || $flag != 3 || $flag != 4) {
            $flag = 0;
            //redirect('referensi/kelompok/add');
        }
        if ($this->session->sub_role == 4) {
            $data['dataKK'] = $this->m_referensi->GetKKSatker($this->session->satker_kode);
            $data['dataSatker'] = $this->m_referensi->GetDetailSatker($this->session->satker_kode);
        } else {
            $data['dataKK'] = $this->m_referensi->GetAllKK();
            $data['dataSatker'] = $this->m_referensi->GetSatker();
        }
        $data['flag'] = $flag;
        $data['id_pdskk'] = $id_pdskk;
        $data['dataProv'] = $this->m_referensi->GetAllProvinsi();
        $this->load->view('kelompok/form_create', $data);
    }

    public function insert() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $now = date("Y-m-d H:i:s");

        $c_desa = count($this->input->post('desa_id[]'));
        if ($c_desa == 0) {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Desa harus diisi minimal 1. Data Kelompok Masyarakat gagal dibuat.')));
        } else {
            
            $cekEnd = 0;
            $desa_id = "";
            for ($i=0; $i < $c_desa; $i++) { 
                $x=$c_desa-1;
                $desa_id .= $this->input->post('desa_id['.$i.']');
                if ($i != $x) {
                    $desa_id .= ";";
                }
            }
            $jml_anggota_kelompok = intval($this->input->post('jml_anggota_l')) + intval($this->input->post('jml_anggota_p'));
            $data = array('satker_kode'=>$this->input->post('satker_kode'),
                          'kk_reg'=>$this->input->post('kk_reg'),
                          'nama_kelompok'=>$this->input->post('nama_kelompok'),
                          'desa_id'=>$desa_id,
                          'jml_anggota_l'=>$this->input->post('jml_anggota_l'),
                          'jml_anggota_p'=>$this->input->post('jml_anggota_p'),
                          'nama_ketua'=>$this->input->post('nama_ketua'),
                          'pekerjaan_ketua'=>$this->input->post('pekerjaan_ketua'),
                          'telp_ketua'=>$this->input->post('telp_ketua'),
                          'jml_anggota_kelompok'=>$jml_anggota_kelompok,
                          'nama_tokoh'=>$this->input->post('nama_tokoh'),
                          'telp_tokoh'=>$this->input->post('telp_tokoh'),
                          'pekerjaan_tokoh'=>$this->input->post('pekerjaan_tokoh'),
                          'nama_pendamping'=>$this->input->post('nama_pendamping'),
                          'jabatan_pendamping'=>$this->input->post('jabatan_pendamping'),
                          'telp_pendamping'=>$this->input->post('telp_pendamping'),
                          'created_at'=>$now,
                          'updated_at'=>$now,
                          'user_input'=>$this->session->user_id);
            //upload file
            $config1['upload_path']          = './assets/filekelompok/';
            $config1['allowed_types']        = 'pdf';
            $config1['overwrite'] = TRUE;
            $this->load->library('upload', $config1);
            $this->upload->initialize($config1);
            if($this->upload->do_upload('fileskkelompok')){
                $file_name = $this->upload->data('file_name');
                $data['sk_kelompok'] = $file_name;
            }
            $insert = $this->db->set($data)->insert('kelompok');
            $flag = $this->input->post('flag');
            $id_pdskk = $this->input->post('id_pdskk');
            if($insert){
                die(json_encode(array('id_pdskk' => $id_pdskk,'flag' => $flag, 'status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Kelompok Masyarakat berhasil dibuat.')));
                //return true;
            } else {
                die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Kelompok Masyarakat gagal dibuat.')));
                //return false;
            }
        }
            
    }

    public function edit($idkelompok) {
        $data['judul'] = "Ubah Data Kelompok Masyarakat";
        $query = $this->db->from('kelompok')
                ->join('kawasan', 'kelompok.kk_reg = kawasan.reg_kk','left outer')
                ->join('fungsi_kk', 'kawasan.fungsi_kk_id = fungsi_kk.id_fungsi_kk','left outer')
                ->where('id_kelompok', $idkelompok)
                ->limit(1)
                ->get();
        if($query->num_rows() > 0){
            $row = $query->row();
            $data['record'] = $row;
            $data['recordDaerah'] = $this->m_referensi->GetDesaKelompok($row->desa_id);
            $data['recordSelectedDesa'] = $this->m_referensi->GetSelectedDesaKelompok($row->desa_id);
        } else {
            $data['record'] = array();
            $data['recordDaerah'] = array();
            $data['recordSelectedDesa'] = array();
        }
        
        if ($this->session->sub_role == 4) {
            $data['dataKK'] = $this->m_referensi->GetKKSatker($this->session->satker_kode);
            $data['dataSatker'] = $this->m_referensi->GetDetailSatker($this->session->satker_kode);
        } else {
            $data['dataKK'] = $this->m_referensi->GetAllKK();
            $data['dataSatker'] = $this->m_referensi->GetSatker();
        }
        
        $data['dataProv'] = $this->m_referensi->GetAllProvinsi();
        $this->load->view('kelompok/form_edit', $data);
    }

    public function update() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        
        $now = date("Y-m-d H:i:s");

        $c_desa = count($this->input->post('desa_id[]'));
        if ($c_desa == 0) {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Desa harus diisi minimal 1. Data Kelompok Masyarakat gagal dibuat.')));
        } else {
            
            $cekEnd = 0;
            $desa_id = "";
            for ($i=0; $i < $c_desa; $i++) { 
                $x=$c_desa-1;
                $desa_id .= $this->input->post('desa_id['.$i.']');
                if ($i != $x) {
                    $desa_id .= ";";
                }
            }
            $jml_anggota_kelompok = intval($this->input->post('jml_anggota_l')) + intval($this->input->post('jml_anggota_p'));
            $data = array('satker_kode'=>$this->input->post('satker_kode'),
                          'kk_reg'=>$this->input->post('kk_reg'),
                          'nama_kelompok'=>$this->input->post('nama_kelompok'),
                          'desa_id'=>$desa_id,
                          'jml_anggota_l'=>$this->input->post('jml_anggota_l'),
                          'jml_anggota_p'=>$this->input->post('jml_anggota_p'),
                          'nama_ketua'=>$this->input->post('nama_ketua'),
                          'pekerjaan_ketua'=>$this->input->post('pekerjaan_ketua'),
                          'telp_ketua'=>$this->input->post('telp_ketua'),
                          'jml_anggota_kelompok'=>$jml_anggota_kelompok,
                          'nama_tokoh'=>$this->input->post('nama_tokoh'),
                          'telp_tokoh'=>$this->input->post('telp_tokoh'),
                          'pekerjaan_tokoh'=>$this->input->post('pekerjaan_tokoh'),
                          'nama_pendamping'=>$this->input->post('nama_pendamping'),
                          'jabatan_pendamping'=>$this->input->post('jabatan_pendamping'),
                          'telp_pendamping'=>$this->input->post('telp_pendamping'),
                          'created_at'=>$now,
                          'updated_at'=>$now,
                          'user_input'=>$this->session->user_id);
            //upload file
            $config1['upload_path']          = './assets/filekelompok/';
            $config1['allowed_types']        = 'pdf';
            $config1['overwrite'] = TRUE;
            $this->load->library('upload', $config1);
            $this->upload->initialize($config1);
            if($this->upload->do_upload('fileskkelompok')){
                $file_name = $this->upload->data('file_name');
                $data['sk_kelompok'] = $file_name;
            }
            //$insert = $this->db->set($data)->insert('kelompok');
            $update = $this->db->where('id_kelompok', $this->input->post('id_kelompok'))
                            ->update("kelompok", $data);
            if($update){
                die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Kelompok Masyarakat berhasil disimpan.')));
                //return true;
            } else {
                die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Kelompok Masyarakat gagal disimpan.')));
                //return false;
            }
        }

    }

    public function detail($idkelompok) {
        $data['judul'] = "Detail Data Kelompok Masyarakat";
        $query = $this->db->select("kelompok.*,short_name, nama_satker, nama_kk, kelompok.updated_at as last_update, UI.nama_user")->from('kelompok')
                ->join('kawasan', 'kelompok.kk_reg = kawasan.reg_kk','left outer')
                ->join('satker', 'kelompok.satker_kode = satker.kode_satker','left outer')
                ->join('fungsi_kk', 'kawasan.fungsi_kk_id = fungsi_kk.id_fungsi_kk','left outer')
                ->join('users as UI', 'kelompok.user_input = UI.id_user','left outer')
                ->where('id_kelompok', $idkelompok)
                ->limit(1)
                ->get();

        $query1 = $this->db->select('tahun_keg as tahun, SUM(jml_anggota_interaksi) as jml_anggota_interaksi, SUM(jml_anggota_kelompok) as jml_anggota_kelompok, AVG(rata_pendapatan) as jml_rata_pendapatan, COUNT(usaha_id) as jml_usaha')
                ->join('kelompok', 'pdskk.kelompok_id = kelompok.id_kelompok','inner')
                ->where('id_kelompok', $idkelompok)
                ->group_by('tahun')
                ->get("pdskk");
        
        if($query->num_rows() > 0){
            $row = $query->row();
            $data['record'] = $row;
            $data['record1'] = $query1->result();
            $data['recordDaerah'] = $this->m_referensi->GetDesaKelompok($row->desa_id);
            $data['recordSelectedDesa'] = $this->m_referensi->GetSelectedDesaKelompok($row->desa_id);
        } else {
            $data['record'] = array();
            $data['recordDaerah'] = array();
            $data['recordSelectedDesa'] = array();
            $data['record1'] = array();
        }
        
        if ($this->session->sub_role == 4) {
            $data['dataKK'] = $this->m_referensi->GetKKSatker($this->session->satker_kode);
            $data['dataSatker'] = $this->m_referensi->GetDetailSatker($this->session->satker_kode);
        } else {
            $data['dataKK'] = $this->m_referensi->GetAllKK();
            $data['dataSatker'] = $this->m_referensi->GetSatker();
        }

        

        
        $data['dataProv'] = $this->m_referensi->GetAllProvinsi();
        $this->load->view('kelompok/form_detail', $data);
    }

    public function getdatadesaekspor($value) {
        $arr_desa = explode(';', $value);
        
        $val_desa = array();
        $x = count($arr_desa);
        for ($i=0; $i < $x; $i++) { 
            if ($arr_desa[$i] != 0 || $arr_desa[$i] != '') {
               $query = $this->db->select('*')
                    ->where(array('id_desa'=>$arr_desa[$i]))->get("adm_daerah");
                
                //if($query->num_rows() > 0){
                    $record = $query->row();
                    $row_desa = array();
                    $row_desa['nama_desa'] = $record->nama_desa;
                    $row_desa['nama_kec'] = $record->nama_kec;
                    $row_desa['nama_kab_kota'] = $record->nama_kab_kota;
                    $row_desa['nama_prov'] = $record->nama_prov;
                    $val_desa[$i] = $row_desa;
                //} 
            }
                
            
        }
                
        return $val_desa;
    }
    
    public function getdatakk() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $id = $this->input->get('id');
        $result = $this->m_referensi->GetKKSatkerKelompok($id);
        $main = array();
        $list = array('reg_kk' => 'id', 'nama_kk' => 'text');
        foreach ($result as $index => $item){ 
            foreach ($item as $key => $value) {
                $main[$index][$list[$key]] = $value; 
            }
        }
        die(json_encode($main));
    }

    public function getdataprov() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $result = $this->m_referensi->GetAllProvinsi();
        $main = array();
        $list = array('id_prov' => 'id', 'nama_prov' => 'text');
        foreach ($result as $index => $item){ 
            foreach ($item as $key => $value) {
                $main[$index][$list[$key]] = $value; 
            }
        }
        die(json_encode($main));
    }

    public function getdatakabkota() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $id = $this->input->get('id');
        $result = $this->m_referensi->GetAllKabKota($id);
        $main = array();
        $list = array('id_kab_kota' => 'id', 'nama_kab_kota' => 'text');
        foreach ($result as $index => $item){ 
            foreach ($item as $key => $value) {
                $main[$index][$list[$key]] = $value; 
            }
        }
        die(json_encode($main));
    }

    public function getdatakec() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $id = $this->input->get('id');
        $result = $this->m_referensi->GetAllKec($id);
        $main = array();
        $list = array('id_kec' => 'id', 'nama_kec' => 'text');
        foreach ($result as $index => $item){ 
            foreach ($item as $key => $value) {
                $main[$index][$list[$key]] = $value; 
            }
        }
        die(json_encode($main));
    }

    public function getdatadesa() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $id = $this->input->get('id');
        $result = $this->m_referensi->GetAllDesa($id);
        $main = array();
        $list = array('id_desa' => 'id', 'nama_desa' => 'text');
        foreach ($result as $index => $item){ 
            foreach ($item as $key => $value) {
                $main[$index][$list[$key]] = $value; 
            }
        }
        die(json_encode($main));
    }

    public function getdatadesaview($value) {
        $arr_desa = explode(';', $value);
        
        $val_desa = "";
        $x = count($arr_desa);
        if ($x > 1) {
            for ($i=0; $i < $x; $i++) { 
                $query = $this->db->select('id_desa,nama_desa')
                    ->where(array('id_desa'=>$arr_desa[$i]))->get("adm_daerah");
                $record = $query->row();
                $val_desa .= "- ".$record->nama_desa;
                if ($i != $x) {
                    $val_desa .= "<br> ";
                }
            }
        } else {
            $query = $this->db->select('id_desa,nama_desa')
                    ->where(array('id_desa'=>$arr_desa[0]))->get("adm_daerah");
            $record = $query->row();
            $val_desa .= $record->nama_desa;
        }
                
        echo $val_desa;
    }

    
    public function delete() {
        $id_user = $this->input->post('id_user');
        $delete_user = $this->db->where("id_user", $id_user)->delete("users");
        
        if($delete_user){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data User berhasil dihapus.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data User gagal dihapus.')));
            //return false;
        }

    }
    public function blank_page() {        
        $this->load->view('users/blank_page');
    }
}
