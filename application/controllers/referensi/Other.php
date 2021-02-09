<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Other extends CI_Controller{
    //put your code here
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_referensi','m_referensi');
        CheckThenRedirect($_SESSION['sub_role'] != 3, base_url());
    }    
    
    public function index() {
       redirect('referensi/other/data/tahap_pembinaan');
    }

    public function data($get=null) {
        if ($get == null) {
            redirect('referensi/other/index');
        }
        $judul = ucwords(str_replace('_', ' ', $get));
        $tabel = 'ref_'.$get;
        $data['judul'] = "Data Referensi - ".$judul;
        $data['judul_referensi'] = $judul;
        $data['get_referensi'] = $get;
        $query = $this->db->select('*')
                    ->order_by('id_reference', 'ASC')
                    ->get($tabel);
        if($query->num_rows() > 0){
            $data['record'] = $query->result();
        } else {
            $data['record'] = array();
        }       
        $this->load->view('other/index', $data);
       
    }

    
    public function add($get=null) {
        
        if ($get == null) {
            redirect('referensi/other/index');
        }
        $judul = ucwords(str_replace('_', ' ', $get));
        $data['judul'] = "Tambah Data Referensi - ".$judul;
        $data['judul_referensi'] = $judul;
        $data['get_referensi'] = $get;
        $this->load->view('other/form_create', $data);
    }

    public function insert() {      
        $now = date("Y-m-d H:i:s");
        $tabel = 'ref_'.$this->input->post('get_referensi');
        $get = $this->input->post('get_referensi');
        $judul = ucwords(str_replace('_', ' ', $get));
        $data = array('detail_1'=>$this->input->post('detail_1'));
        $insert = $this->db->set($data)->insert($tabel);
        if($insert){
            die(json_encode(array('get_ref' => $get, 'status' => 'success', 'title' => 'Berhasil', 'message' => 'Data '.$judul.' berhasil dibuat.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data '.$judul.' gagal dibuat.')));
            //return false;
        }
    }

    public function edit($get=null,$id) {
        $tabel = 'ref_'.$get;
        $judul = ucwords(str_replace('_', ' ', $get));
        $data['judul'] = "Ubah Data Referensi - ".$judul;
        $data['judul_referensi'] = $judul;
        $data['get_referensi'] = $get;

        
        $query = $this->db->from($tabel)
                ->where('id_reference', $id)
                ->limit(1)
                ->get();
        if($query->num_rows() > 0){
            $data['record'] = $query->row();
        } else {
            $data['record'] = array();
        }
        
        $this->load->view('other/form_edit', $data);
    }

    public function update() {
        
        $now = date("Y-m-d H:i:s");
        $tabel = 'ref_'.$this->input->post('get_referensi');
        $get = $this->input->post('get_referensi');
        $judul = ucwords(str_replace('_', ' ', $get));
        $data = array('detail_1'=>$this->input->post('detail_1'));
        $update = $this->db->where('id_reference', $this->input->post('id_reference'))->update($tabel, $data);
        if($update){
            die(json_encode(array('get_ref' => $get, 'status' => 'success', 'title' => 'Berhasil', 'message' => 'Data '.$judul.' berhasil disimpan.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data '.$judul.' gagal disimpan.')));
            //return false;
        }

    }

    
    
}
