<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Laporan extends CI_Controller{
    //put your code here
    public function __construct()
    {
        parent::__construct();
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
    }    
    
    public function data() {
        $access = $this->session->sub_role;
        if (!$access) { $ok = true; } elseif ($access == 3 || $access == 4 || $access == 5 || $access == 7) { $ok = false; } else { $ok = true; }
        CheckThenRedirect($ok, base_url());
        $tahun = $this->input->post('tahun');
        $kode_jur = $this->input->get('jurusan');
        //$keg = $this->input->post('kegiatan');
        if (!isset($tahun)){
            $tahun = date("Y");
        }
        if (!isset($kode_jur)){
            $kode_jur = '001';
        }
        /*if (!isset($keg)){
            $keg = "0";
        }*/
        $data['tahun_exist'] = $tahun;
        $data['jur_exist'] = $kode_jur;
        $where = array();
        if ($tahun != '1') {
            $where['tahun_file'] = $tahun;
        }
        if ($kode_jur != '0') {
            $where['laporan.kode_jur'] = $kode_jur;
        }
        /*if ($keg != "0") {
            $where['kegiatan'] = $keg;
        }*/
        $query = $this->db->select('DISTINCT(laporan.id_laporan),laporan.*, laporan.created_at as dibuat, users.nama_user')
                ->join('jurusan', 'laporan.kode_jur = jurusan.kode_jur','left outer')
                ->join('users', 'laporan.user_input = users.id_user','left outer')
                ->order_by('id_laporan', 'DESC')
                ->get_where("laporan", $where);
        if($query->num_rows() > 0){
            $data['record'] = $query->result();
        } else {
            $data['record'] = array();
        }       
        $query1 = $this->db->select('id, nama_jur')->where('kode_jur',$kode_jur)->get("jurusan");
        $rowjur = $query1->row();
        $data['jurusan_exist'] = ' - '.$rowjur->nama_jur;
        $qJur = $this->db->order_by('kode_jur', 'ASC')->get("jurusan");
        $data['datajur'] = $qJur->result();
        $data['judul'] = "Laci File Dokumen";
        $this->load->view('laporan/index_data',$data);
    }

    public function createlaporan() {
                    
        CheckThenRedirect(empty($_SESSION['roles_id']), base_url());
        $tahun = date("Y");
        $data['tahun_exist'] = $tahun;
        $now = date("Y-m-d H:i:s");
        $kode_jur = $this->input->post('kode_jur');
        $table = "laporan";
        $config['upload_path']          = './assets/filelaporan/';
        $config['allowed_types']        = 'pdf|jpg|jpeg|png|doc|docx|xls|xlsx|ppt|pptx';
        $config['file_name'] = 'file_laporan_'.$kode_jur.'-'.round(microtime(true));

        
        $data_laporan = array('judul_file'=>$this->input->post('judul_file'),
                        'kode_jur'=>$kode_jur,
                        'tahun_file'=>$this->input->post('tahun_file'),
                        'user_input'=>$this->session->user_id,
                        'created_at'=>$now);
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        
        if($this->upload->do_upload('filelaporan')){
            $file_laporan = $this->upload->data('file_name');
            $data_laporan['file_laporan'] = $file_laporan;
        } 

        $create_laporan = $this->db->set($data_laporan)->insert($table);
        $new_id_laporan = $this->db->insert_id();
        if($create_laporan){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'File Laporan berhasil diunggah.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'File Laporan Gagal diunggah.')));
            //return false;
        }

    }

    public function update() {
        $now = date("Y-m-d H:i:s");
        $id_laporan = $this->input->post('id_laporan');
        $jurusan = $this->input->post('jurusan');
        $file_old = $this->input->post('file_old');
        $table = "laporan";
        $config['upload_path']          = './assets/filelaporan/';
        $config['allowed_types']        = 'pdf';
        $config['file_name'] = 'laporan_'.$jurusan.'-'.round(microtime(true));

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        $data_laporan = array('judul_file'=>$this->input->post('judul_file'),
                        'jurusan_id'=>$jurusan,
                        'user_input'=>$this->session->user_id,
                        'updated_at'=>$now);
        if($this->upload->do_upload('filelaporan')){
            unlink('assets/filelaporan/'.$file_old);
            $file_laporan = $this->upload->data('file_laporan');
            $data['file_laporan'] = $file_laporan;
        } 

        $update_laporan = $this->db->where("id_laporan", $id_laporan)
                            ->update($table, $data_laporan);
        if($update_laporan){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'File Laporan berhasil diubah.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'File Laporan Gagal diubah.')));
            //return false;
        }
    }

    public function hapuslaporan() {
        CheckThenRedirect($_SESSION['sub_role'] != 3, base_url());
        $id_laporan = $this->input->post('id_laporan');
        $query = $this->db->where('id_laporan', $id_laporan)->get('laporan');
        $row = $query->row();
        $file_laporan = $row->file_laporan;
        unlink('./assets/filelaporan/'.$file_laporan);

        $delete_laporan = $this->db->where("id_laporan", $id_laporan)->delete('laporan');
        
        if($delete_laporan){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'File Laporan berhasil dihapus.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'File Laporan gagal dihapus.')));
            //return false;
        }

    }

}
