<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Satker extends CI_Controller{
    //put your code here
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_referensi','m_referensi');
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        date_default_timezone_set('Asia/Jakarta');
    }    
    
    public function index() {
        $prov_id = $this->input->post('prov_id');
        $data['judul'] = 'Data Referensi - Satuan Kerja';
        
        if (!isset($prov_id)){
            $prov_id = 0;
        }
        $where = array();
        if ($prov_id != 0) {
            $where['prov_id'] = $prov_id;
        } 
        if ($this->session->sub_role == 4 ) {
            $where['kode_satker'] = $this->session->satker_kode;
        }
        $data['prov_exist'] = $prov_id;
        $query = $this->db->select('satker.*, UI.nama_user')
                ->join('users as UI', 'satker.user_input = UI.id_user','left outer')
                ->group_by('kode_satker')
                ->order_by('nama_satker', 'ASC')
                ->get_where("satker", $where);
        if($query->num_rows() > 0){
            $data['record'] = $query->result();
        } else {
            $data['record'] = array();
        }
        
        $data['dataProv'] = $this->m_referensi->GetAllProvinsi();
        
        $this->load->view('satker/index.php',$data);
    }

    
    public function add() {
        CheckThenRedirect($_SESSION['sub_role'] != 3, base_url());
        $data['judul'] = "Tambah Data Satuan Kerja";
        $data['dataKK'] = $this->m_referensi->GetAllKK();
        $data['dataProv'] = $this->m_referensi->GetAllProvinsi();
        $this->load->view('satker/form_create', $data);
    }

    public function insert() {
        CheckThenRedirect($_SESSION['sub_role'] != 3, base_url());
        $now = date("Y-m-d H:i:s");

        $c_kk = count($this->input->post('reg_kk[]'));
        $c_provinsi = count($this->input->post('prov_id[]'));
        if ($c_kk == 0 || $c_kk == 0) {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Provinsi dan Kawasan Konservasi harus diisi minimal 1. Data Satuan Kerja gagal dibuat.')));
        } else {
            
            $cekEnd = 0;
            $prov_id = "";
            for ($i=0; $i < $c_provinsi; $i++) { 
                $x=$c_provinsi-1;
                $prov_id .= $this->input->post('prov_id['.$i.']');
                if ($i != $x) {
                    $prov_id .= ",";
                }
            }
            for ($a=1; $a <= $c_kk; $a++) {
                $y = $a - 1;
                $reg_kk = $this->input->post('reg_kk['.$y.']');
                $dataKK = array('satker_kode'=>$this->input->post('kode_satker'),
                          'updated_at'=>$now,
                          'user_input'=>$this->session->user_id);
                $update = $this->db->where('reg_kk', $reg_kk)
                        ->update("kawasan", $dataKK);
            }
            $data = array('kode_satker'=>$this->input->post('kode_satker'),
                          'nama_satker'=>$this->input->post('nama_satker'),
                          'alamat'=>$this->input->post('alamat'),
                          'prov_id'=>$prov_id,
                          'telp'=>$this->input->post('telp'),
                          'email'=>$this->input->post('email'),
                          'created_at'=>$now,
                          'updated_at'=>$now,
                          'user_input'=>$this->session->user_id);
            $insert = $this->db->set($data)->insert('satker');
            
            
            if($insert){
                die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Satuan Kerja berhasil dibuat.')));
                //return true;
            } else {
                die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Satuan Kerja gagal dibuat.')));
                //return false;
            }
        }
            
    }

    public function edit($kodesatker) {
        $data['judul'] = "Ubah Data Satuan Kerja";
        $query = $this->db->from('satker')
                ->where('kode_satker', $kodesatker)
                ->limit(1)
                ->get();
        if($query->num_rows() > 0){
            $data['record'] = $query->row();
            //$data['record_provinsi'] = $this->m_referensi->GetProvinsiIDSatker($kodesatker);
            $data['record_kk'] = $this->m_referensi->GetRegKKSatker($kodesatker);
        } else {
            $data['record'] = array();
            //$data['record_provinsi'] = array();
            $data['record_kk'] = array();
        }
        
        $data['dataKK'] = $this->m_referensi->GetAllKK();
        $data['dataProv'] = $this->m_referensi->GetAllProvinsi();
        
        $this->load->view('satker/form_edit', $data);
    }

    public function update() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $now = date("Y-m-d H:i:s");

        $c_kk = count($this->input->post('reg_kk[]'));
        $c_provinsi = count($this->input->post('prov_id[]'));
        if ($c_kk == 0 || $c_kk == 0) {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Provinsi dan Kawasan Konservasi harus diisi minimal 1. Data Satuan Kerja gagal dibuat.')));
        } else {
            $delete_data = $this->db->where("kode_satker", $this->input->post('kode_satker_old'))->delete("satker");
            $cekEnd = 0;
            $prov_id = "";
            for ($i=0; $i < $c_provinsi; $i++) { 
                $x=$c_provinsi-1;
                $prov_id .= $this->input->post('prov_id['.$i.']');
                if ($i != $x) {
                    $prov_id .= ",";
                }
            }

            
            //cek data exist kk

            $query = $this->db->select("*")->from('kawasan')->where('satker_kode', $this->input->post('kode_satker'))->get();
            $result = $query->result();
            foreach ($result as $row) {
                $kode_satker = $this->input->post('kode_satker');
                $dataKK = array('satker_kode'=>0,
                          'updated_at'=>$now,
                          'user_input'=>$this->session->user_id);
                $update = $this->db->where('satker_kode', $kode_satker)
                        ->update("kawasan", $dataKK);
            }
            for ($a=1; $a <= $c_kk; $a++) {
                $y = $a - 1;
                $reg_kk = $this->input->post('reg_kk['.$y.']');
                $kode_satker = $this->input->post('kode_satker');
                $dataKK = array('satker_kode'=>$kode_satker,
                          'updated_at'=>$now,
                          'user_input'=>$this->session->user_id);
                $update = $this->db->where('reg_kk', $reg_kk)
                        ->update("kawasan", $dataKK);
            }
            $data = array('kode_satker'=>$this->input->post('kode_satker'),
                          'nama_satker'=>$this->input->post('nama_satker'),
                          'alamat'=>$this->input->post('alamat'),
                          'prov_id'=>$prov_id,
                          'telp'=>$this->input->post('telp'),
                          'email'=>$this->input->post('email'),
                          'created_at'=>$now,
                          'updated_at'=>$now,
                          'user_input'=>$this->session->user_id);
            $insert = $this->db->set($data)->insert('satker');

            
            if($insert){
                die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Satuan Kerja berhasil dibuat.')));
                //return true;
            } else {
                die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Satuan Kerja gagal dibuat.')));
                //return false;
            }
        }

    }

    public function detail($kodesatker) {
        $data['judul'] = "Detail Data Satuan Kerja";
        $query = $this->db->select("*, satker.updated_at as last_update")
                    ->join('users', 'satker.user_input = users.id_user','left outer')
                    ->from('satker')
                    ->where('kode_satker', $kodesatker)
                    ->limit(1)
                    ->get();
        if($query->num_rows() > 0){
            $data['record'] = $query->row();
            //$data['record_provinsi'] = $this->m_referensi->GetProvinsiIDSatker($kodesatker);
            $data['record_kk'] = $this->m_referensi->GetRegKKSatker($kodesatker);
        } else {
            $data['record'] = array();
            //$data['record_provinsi'] = array();
            $data['record_kk'] = array();
        }
        
        $data['dataKK'] = $this->m_referensi->GetAllKK();
        $data['dataProv'] = $this->m_referensi->GetAllProvinsi();
        $this->load->view('satker/form_detail', $data);
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
