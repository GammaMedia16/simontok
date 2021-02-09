<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kawasan extends CI_Controller{
    //put your code here
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_referensi','m_referensi');
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        date_default_timezone_set('Asia/Jakarta');
    }    
    
    public function index() {
        $fungsi_kk_id = $this->input->post('fungsi_kk_id');
        $prov_id = $this->input->post('prov_id');
        $satker_kode = $this->input->post('satker_kode');
        $data['judul'] = 'Data Referensi - Kawasan Konservasi';
        if ($this->session->sub_role == 4 ) {
            $satker_kode = $this->session->satker_kode;
        }
        if (!isset($fungsi_kk_id)){
            $fungsi_kk_id = 0;
        }
        if (!isset($prov_id)){
            $prov_id = 0;
        }
        if (!isset($satker_kode)){
            $satker_kode = 0;
        }
        $where = array();
        if ($fungsi_kk_id != 0) {
            $where['fungsi_kk_id'] = $fungsi_kk_id;
        }
        
        if ($satker_kode != 0) {
            $where['kawasan.satker_kode'] = $satker_kode;
        }
        if ($prov_id != 0) {
            $where['S2.prov_id'] = $prov_id;
        } 
        $data['fungsi_exist'] = $fungsi_kk_id;
        $data['prov_exist'] = $prov_id;
        $data['satker_exist'] = $satker_kode;
        $query = $this->db->select('kawasan.*, fungsi_kk.nama_fungsi, S1.nama_satker, UI.nama_user')
                ->join('fungsi_kk', 'kawasan.fungsi_kk_id = fungsi_kk.id_fungsi_kk','left outer')
                ->join('satker as S1', 'kawasan.satker_kode = S1.kode_satker','left outer')
                ->join('satker as S2', 'kawasan.prov_id = S2.prov_id','left outer')
                ->join('users as UI', 'kawasan.user_input = UI.id_user','left outer')
                ->group_by('reg_kk')
                ->order_by('reg_kk', 'ASC')
                ->get_where("kawasan", $where);
        if($query->num_rows() > 0){
            $data['record'] = $query->result();
        } else {
            $data['record'] = array();
        }
        
        $data['dataFungsiKK'] = $this->m_referensi->GetFungsiKK();
        $data['dataProv'] = $this->m_referensi->GetAllProvinsi();
        $data['dataSatker'] = $this->m_referensi->GetSatker();

        $this->load->view('kawasan/index.php',$data);
    }

    
    public function add() {
        CheckThenRedirect($_SESSION['sub_role'] != 3, base_url());
        $data['judul'] = "Tambah Data Kawasan Konservasi";
        $data['dataFungsiKK'] = $this->m_referensi->GetFungsiKK();
        $data['dataProv'] = $this->m_referensi->GetAllProvinsi();
        $this->load->view('kawasan/form_create', $data);
    }

    public function insert() {
        CheckThenRedirect($_SESSION['sub_role'] != 3, base_url());
        $now = date("Y-m-d H:i:s");

        $c_provinsi = count($this->input->post('prov_id[]'));
        
        $cekEnd = 0;
        $prov_id = "";
        for ($i=0; $i < $c_provinsi; $i++) { 
            $x=$c_provinsi-1;
            $prov_id .= $this->input->post('prov_id['.$i.']');
            if ($i != $x) {
                $prov_id .= ",";
            }
        }
        $data = array('reg_kk'=>$this->input->post('reg_kk'),
                      'nama_kk'=>$this->input->post('nama_kk'),
                      'wdpa_id'=>$this->input->post('wdpa_id'),
                      'prov_id'=>$prov_id,
                      'fungsi_kk_id'=>$this->input->post('fungsi_kk_id'),
                      'luas_kk'=>$this->input->post('luas_kk'),
                      'luas_zona'=>$this->input->post('luas_zona'),
                      'luas_open_area'=>$this->input->post('luas_open_area'),
                      'created_at'=>$now,
                      'updated_at'=>$now,
                      'user_input'=>$this->session->user_id);
            $insert = $this->db->set($data)->insert('kawasan');
        
        if($insert){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Kawasan Konservasi berhasil dibuat.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Kawasan Konservasi gagal dibuat.')));
            //return false;
        }
    }

    public function edit($regkk) {
        $data['judul'] = "Ubah Data Kawasan Konservasi";
        $query = $this->db->from('kawasan')
                ->where('reg_kk', $regkk)
                ->limit(1)
                ->get();
        if($query->num_rows() > 0){
            $data['record'] = $query->row();
            //$data['record_provinsi'] = $this->m_referensi->GetProvinsiIDKK($regkk);
        } else {
            $data['record'] = array();
            //$data['record_provinsi'] = array();
        }
        $data['dataFungsiKK'] = $this->m_referensi->GetFungsiKK();
        $data['dataProv'] = $this->m_referensi->GetAllProvinsi();
        
        $this->load->view('kawasan/form_edit', $data);
    }

    public function detail($regkk) {
        $data['judul'] = "Detail Data Kawasan Konservasi";
        $query = $this->db->select("*, kawasan.updated_at as last_update")
                    ->join('users', 'kawasan.user_input = users.id_user','left outer')
                    ->from('kawasan')
                    ->where('reg_kk', $regkk)
                    ->limit(1)
                    ->get();
        if($query->num_rows() > 0){
            $data['record'] = $query->row();
            //$data['record_provinsi'] = $this->m_referensi->GetProvinsiIDKK($regkk);
        } else {
            $data['record'] = array();
            //$data['record_provinsi'] = array();
        }
        $data['dataFungsiKK'] = $this->m_referensi->GetFungsiKK();
        $data['dataProv'] = $this->m_referensi->GetAllProvinsi();
        
        $this->load->view('kawasan/form_detail', $data);
    }

    public function update() {
        $now = date("Y-m-d H:i:s");
        $delete_data = $this->db->where("reg_kk", $this->input->post('reg_kk_old'))->delete("kawasan");
        $c_provinsi = count($this->input->post('prov_id[]'));
        
        $cekEnd = 0;
        $prov_id = "";
        for ($i=0; $i < $c_provinsi; $i++) { 
            $x=$c_provinsi-1;
            $prov_id .= $this->input->post('prov_id['.$i.']');
            if ($i != $x) {
                $prov_id .= ",";
            }
        }
        $data = array('reg_kk'=>$this->input->post('reg_kk'),
                      'nama_kk'=>$this->input->post('nama_kk'),
                      'wdpa_id'=>$this->input->post('wdpa_id'),
                      'prov_id'=>$prov_id,
                      'fungsi_kk_id'=>$this->input->post('fungsi_kk_id'),
                      'satker_kode'=>$this->input->post('satker_kode'),
                      'luas_kk'=>$this->input->post('luas_kk'),
                      'luas_zona'=>$this->input->post('luas_zona'),
                      'luas_open_area'=>$this->input->post('luas_open_area'),
                      'created_at'=>$this->input->post('created_old'),
                      'updated_at'=>$now,
                      'user_input'=>$this->session->user_id);
        if ($this->session->sub_role == 4) {
            $data['satker_kode'] = $this->session->satker_kode;
        }
        $insert = $this->db->set($data)->insert('kawasan');
        
        if($insert){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Kawasan Konservasi berhasil disimpan.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Kawasan Konservasi gagal disimpan.')));
            //return false;
        }

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
