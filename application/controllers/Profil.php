<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Profil extends CI_Controller{
    //put your code here
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('maps');
        date_default_timezone_set('Asia/Jakarta');
    }    
    
    public function index() {  
        $data['judul'] = "Profil Balai";
        $this->session->resort = NULL;
        $q = $this->db->get("profil_balai");
        if($q->num_rows() > 0){
            $data['record'] = $q->result();
        } else {
            $data['record'] = array();
        }
        $this->load->view('profil/index', $data);
    }

    public function editprofil($id=null) {
        CheckThenRedirect($_SESSION['sub_role'] != 5, base_url());
        if (!isset($id)) {
            redirect('dashboard');
        }
        
        $query = $this->db->where('id', $id)->get("profil_balai");
        if($query->num_rows() > 0){
            $data['record'] = $query->row();
        } else {
            $data['record'] = array();
        }

        $this->load->view('profil/form_edit', $data);
    }

    public function updateprofilbalai() {
        CheckThenRedirect($_SESSION['sub_role'] != 5, base_url());
        $id = $this->input->post('id');
        $data = array('judul'=>$this->input->post('judul'),
                      'isi'=>$this->input->post('isivalue'),
                      'updated_at'=>date("Y-m-d H:i:s"),
                      'user_input'=>$this->session->user_id);
        
        //upload file gambar
        $config1['upload_path']          = './assets/kontensitroom/';
        $config1['allowed_types']        = 'jpg|jpeg|png';
        $config1['file_name'] = 'Image-Profil-Balai_'.$id;
        $config1['overwrite'] = TRUE;
        $this->load->library('upload', $config1);
        $this->upload->initialize($config1);
        if($this->upload->do_upload('filegambar')){

            $filegambar_name = $this->upload->data('file_name');
            $data['file_gambar'] = $filegambar_name;
        }

        $update_data = $this->db->where("id", $id)->update("profil_balai", $data);
        if($update_data){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Profil Berhasil disimpan.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Profil Gagal disimpan.')));
            //return false;
        }
    }

    public function rolemodel() {  
        //CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $data['judul'] = "Role Model";
        $this->session->resort = NULL;

        $this->load->view('profil/rolemodel', $data);
    } 

    public function prioritas() {  
        //CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $table = 'prioritas_pengelolaan';
        $query = $this->db->select('*,'.$table.'.id as id_prioritas, DATE_FORMAT('.$table.'.updated_at,\'%d %b %Y\') as newtgl')
                    ->join('users', $table.'.user_input = users.id_user')
                    ->get($table);
        if($query->num_rows() > 0){
            $data['record'] = $query->result();
        } else {
            $data['record'] = array();
        }

        $this->load->view('profil/prioritas', $data);
    }

    public function addprioritas() {
        $qRes = $this->db->order_by('id', 'ASC')->get("resort");
        $data['dataRes'] = $qRes->result();
        $this->load->view('profil/form_create_prioritas', $data);
    }

    public function editprioritas($id=null) {
        CheckThenRedirect($_SESSION['sub_role'] != 5, base_url());
        if (!isset($id)) {
            redirect('resort');
        }
        $qRes = $this->db->order_by('id', 'ASC')->get("resort");
        $data['dataRes'] = $qRes->result(); 

        $query = $this->db->where('id', $id)->get("prioritas_pengelolaan");
        if($query->num_rows() > 0){
            $data['record'] = $query->row();
        } else {
            $data['record'] = array();
        }

        $this->load->view('profil/form_edit_prioritas', $data);
    }

    public function createprioritas() {
        CheckThenRedirect($_SESSION['sub_role'] != 5, base_url());
        $id = $this->input->post('resort_id');
        $data = array('resort_id'=>$this->input->post('resort_id'),
                      'judul'=>$this->input->post('judul'),
                      'isi'=>$this->input->post('isivalue'),
                      'created_at'=>date("Y-m-d H:i:s"),
                      'updated_at'=>date("Y-m-d H:i:s"),
                      'user_input'=>$this->session->user_id);
        
        //upload file gambar
        $config1['upload_path']          = './assets/fileprofil/';
        $config1['allowed_types']        = 'jpg|jpeg|png';
        $config1['file_name'] = 'Image-Prioritas-Pengelolaan_'.$id;
        $this->load->library('upload', $config1);
        $this->upload->initialize($config1);
        if($this->upload->do_upload('filegambar')){
            $filegambar_name = $this->upload->data('file_name');
            $data['file_gambar'] = $filegambar_name;
        }

        $insert_data = $this->db->set($data)->insert("prioritas_pengelolaan");

        if($insert_data){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Prioritas Pengelolaan Berhasil disimpan.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Prioritas Pengelolaan Gagal disimpan.')));
            //return false;
        }
    }

    public function updateprioritas() {
        CheckThenRedirect($_SESSION['sub_role'] != 5, base_url());
        $id = $this->input->post('resort_id');
        $id_prioritas = $this->input->post('id');
        $data = array('resort_id'=>$this->input->post('resort_id'),
                      'judul'=>$this->input->post('judul'),
                      'isi'=>$this->input->post('isivalue'),
                      'updated_at'=>date("Y-m-d H:i:s"),
                      'user_input'=>$this->session->user_id);
        
        //upload file gambar
        $config1['upload_path']          = './assets/fileprofil/';
        $config1['allowed_types']        = 'jpg|jpeg|png';
        $config1['file_name'] = 'Image-Prioritas-Pengelolaan_'.$id;
        $config1['overwrite'] = TRUE;
        $this->load->library('upload', $config1);
        $this->upload->initialize($config1);
        if($this->upload->do_upload('filegambar')){

            $filegambar_name = $this->upload->data('file_name');
            $data['file_gambar'] = $filegambar_name;
        }

        $update_data = $this->db->where("id", $id_prioritas)->update("prioritas_pengelolaan", $data);

        if($update_data){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Prioritas Pengelolaan Berhasil disimpan.', 'id_resort' => $id)));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Prioritas Pengelolaan Gagal disimpan.')));
            //return false;
        }
    }

    public function hapusprioritas() {
        CheckThenRedirect($_SESSION['sub_role'] != 5, base_url());
        $id_prioritas = $this->input->post('id_prioritas');
        $file_gambar = $this->input->post('file_gambar');
        $id = $this->session->resort;
        $table = "prioritas_pengelolaan";
        if ($file_gambar != NULL || $file_gambar != "") {
            unlink('assets/fileprofil/'.$file_gambar);
        }
        
        $delete_data = $this->db->where("id", $id_prioritas)->delete($table);
        if($delete_data){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data berhasil dihapus.', 'id_resort' => $id)));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data gagal dihapus.')));
            //return false;
        }
    }
    

    public function kemitraan() {
        //CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());  
        $table = 'kemitraan';
        $where =array();
        $query = $this->db->select('*,'.$table.'.id as id_kemitraan, DATE_FORMAT('.$table.'.updated_at,\'%d %b %Y\') as newtgl')
                    ->join('users', $table.'.user_input = users.id_user')
                    ->get($table);
        if($query->num_rows() > 0){
            $data['record'] = $query->result();
        } else {
            $data['record'] = array();
        }

        $this->load->view('profil/kemitraan', $data);
    }

    public function addkemitraan() {
        $qRes = $this->db->order_by('id', 'ASC')->get("resort");
        $data['dataRes'] = $qRes->result();
        $this->load->view('profil/form_create_kemitraan', $data);
    }

    public function createkemitraan() {
        CheckThenRedirect($_SESSION['sub_role'] != 5, base_url());
        $id = $this->input->post('resort_id');
        $data = array('resort_id'=>$this->input->post('resort_id'),
                      'judul'=>$this->input->post('judul'),
                      'isi'=>$this->input->post('isivalue'),
                      'created_at'=>date("Y-m-d H:i:s"),
                      'updated_at'=>date("Y-m-d H:i:s"),
                      'user_input'=>$this->session->user_id);
        
        //upload file gambar
        $config1['upload_path']          = './assets/fileprofil/';
        $config1['allowed_types']        = 'jpg|jpeg|png';
        $config1['file_name'] = 'Image-Kemitraan_'.$id;
        $this->load->library('upload', $config1);
        $this->upload->initialize($config1);
        if($this->upload->do_upload('filegambar')){
            $filegambar_name = $this->upload->data('file_name');
            $data['file_gambar'] = $filegambar_name;
        }

        $insert_data = $this->db->set($data)->insert("kemitraan");

        if($insert_data){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Kemitraan Berhasil disimpan.', 'id_resort' => $id)));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Kemitraan Gagal disimpan.')));
            //return false;
        }
    }

    public function editkemitraan($id=null) {
        CheckThenRedirect($_SESSION['sub_role'] != 5, base_url());
        if (!isset($id)) {
            redirect('resort');
        }
        $qRes = $this->db->order_by('id', 'ASC')->get("resort");
        $data['dataRes'] = $qRes->result();

        $query = $this->db->where('id', $id)->get("kemitraan");
        if($query->num_rows() > 0){
            $data['record'] = $query->row();
        } else {
            $data['record'] = array();
        }

        $this->load->view('profil/form_edit_kemitraan', $data);
    }

    public function updatekemitraan() {
        CheckThenRedirect($_SESSION['sub_role'] != 5, base_url());
        $id = $this->input->post('resort_id');
        $id_kemitraan = $this->input->post('id');
        $data = array('resort_id'=>$this->input->post('resort_id'),
                      'judul'=>$this->input->post('judul'),
                      'isi'=>$this->input->post('isivalue'),
                      'updated_at'=>date("Y-m-d H:i:s"),
                      'user_input'=>$this->session->user_id);

        
        //upload file gambar
        $config1['upload_path']          = './assets/fileprofil/';
        $config1['allowed_types']        = 'jpg|jpeg|png';
        $config1['file_name'] = 'Image-Kemitraan_'.$id;
        $config1['overwrite'] = TRUE;
        $this->load->library('upload', $config1);
        $this->upload->initialize($config1);
        if($this->upload->do_upload('filegambar')){
            $this->upload->overwrite = TRUE;
            $filegambar_name = $this->upload->data('file_name');
            $data['file_gambar'] = $filegambar_name;
        }

        $update_data = $this->db->where("id", $id_kemitraan)->update("kemitraan", $data);

        if($update_data){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Kemitraan Berhasil disimpan.', 'id_resort' => $id)));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Kemitraan Gagal disimpan.')));
            //return false;
        }
    }

    public function hapuskemitraan() {
        CheckThenRedirect($_SESSION['sub_role'] != 5, base_url());
        $id_kemitraan = $this->input->post('id_kemitraan');
        $file_gambar = $this->input->post('file_gambar');
        $id = $this->session->resort;
        $table = "kemitraan";
        if ($file_gambar != NULL || $file_gambar != "") {
            unlink('assets/fileprofil/'.$file_gambar);
        }
        
        $delete_data = $this->db->where("id", $id_kemitraan)->delete($table);
        if($delete_data){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data berhasil dihapus.', 'id_resort' => $id)));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data gagal dihapus.')));
            //return false;
        }
    }

    public function personil() {  
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $table = 'users';
        $query = $this->db->order_by('nama_user', 'ASC')->get_where('users', array('role_id' => 2,'resort_id <>' => 0));
        if($query->num_rows() > 0){
            $data['record'] = $query->result();
        } else {
            $data['record'] = array();
        }

        $this->load->view('profil/personil', $data);
    }

    public function sarpras() {  
        //CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $table = 'sarpras';
        $query = $this->db->select('*,'.$table.'.id as id_sarpras, DATE_FORMAT('.$table.'.updated_at,\'%d %b %Y\') as newtgl')
                    ->join('users', $table.'.user_input = users.id_user')
                    ->where('category', 1)
                    ->order_by('id_sarpras', 'DESC')
                    ->get($table);
        if($query->num_rows() > 0){
            $data_sarpras = $query->result();
            $config['zoom'] = 'auto';
        } else {
            $data_sarpras = array();
        }
        $data['record'] = $data_sarpras;
        foreach ($data_sarpras as $row) {
            $marker = array();
            $marker['position'] = $row->lat.', '.$row->lon;
            $src_gambar = base_url('assets/kontensitroom/'.$row->file_gambar);
            $gambar = "<center><img class=\"img-responsive\" src=\"".$src_gambar."\" style=\"padding-top:10px;max-width:200px\" alt=\"".$row->file_gambar."\"></center>";
            $marker['infowindow_content'] = '<h4>'.$row->nama_sarpras.'</h4>'.$gambar.'<br>Lokasi : '.$row->lat.', '.$row->lon;
            $marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_icon&chld=glyphish_house|00E7F4';
            $this->maps->add_marker($marker);
        }
        $config['map_height'] = '550px';
        
        $this->maps->initialize($config);
        $data['map'] = $this->maps->create_map();
        $this->load->view('profil/sarpras', $data);
    }

    public function divespot() {  
        //CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $table = 'sarpras';
        $query = $this->db->select('*,'.$table.'.id as id_sarpras, DATE_FORMAT('.$table.'.updated_at,\'%d %b %Y\') as newtgl')
                    ->join('users', $table.'.user_input = users.id_user')
                    ->where('category', 2)
                    ->order_by('id_sarpras', 'DESC')
                    ->get($table);
        if($query->num_rows() > 0){
            $data_sarpras = $query->result();
            $config['zoom'] = 'auto';
        } else {
            $data_sarpras = array();
        }
        $data['record'] = $data_sarpras;
        foreach ($data_sarpras as $row) {
            $marker = array();
            $marker['position'] = $row->lat.', '.$row->lon;
            $src_gambar = base_url('assets/kontensitroom/'.$row->file_gambar);
            $gambar = "<center><img class=\"img-responsive\" src=\"".$src_gambar."\" style=\"padding-top:10px;max-width:200px\" alt=\"".$row->file_gambar."\"></center>";
            $marker['infowindow_content'] = '<h4>'.$row->nama_sarpras.'</h4>'.$gambar.'<br>Lokasi : '.$row->lat.', '.$row->lon;
            $marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_icon&chld=glyphish_pin|00E7F4';
            $this->maps->add_marker($marker);
        }
        $config['map_height'] = '550px';
        
        $this->maps->initialize($config);
        $data['map'] = $this->maps->create_map();
        $this->load->view('profil/divespot', $data);
    }

    public function resort($id=null)
    {
        if (!isset($id)) {
            $data['judul'] = "Resort Balai Taman Nasional Kepulauan Seribu";
            $this->session->resort = NULL;
            $this->session->nama_resort = NULL;
            $this->load->view('resort/index_user', $data);
        } else {
            $qKK = $this->db->where('id', $id)->get("resort");
            if($qKK->num_rows() > 0){
                $data_kk = $qKK->row();
                $data['record'] = $data_kk;
                $this->session->nama_resort = $data_kk->nama_resort;
                $this->session->resort = $id;
                $data['judul'] = $data_kk->nama_resort;
                $data['nama_resort'] = $this->session->nama_resort;
                $this->load->view('resort/profil_resort_user', $data);
            } else {
                redirect('profil/resort');
            }

            
        }
        
    }

    public function akses($id=null) {
        //CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        if (!isset($id)){
            redirect('dashboard');
        }
        
        /*if ($id == 1) {
            $titik_gerbang = '-5.649186, 106.568073';
            $sptn = "SPTN Wilayah I Pulau Kelapa";
        } elseif ($id == 2) {
            $titik_gerbang = '-5.653857, 106.578163';
            $sptn = "SPTN Wilayah II Pulau Harapan";
        } elseif ($id == 3) {
            $titik_gerbang = '-5.745352, 106.615181';
            $sptn = "SPTN Wilayah III Pulau Pramuka";
        }*/

        if ($id == 1) {
            $titik_gerbang = 'Jl. Salemba Raya No.9, RT.1/RW.3, Paseban, Senen, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10440';
            $sptn = "SPTN Wilayah I Pulau Kelapa";
        } elseif ($id == 2) {
            $titik_gerbang = 'Jl. Salemba Raya No.9, RT.1/RW.3, Paseban, Senen, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10440';
            $sptn = "SPTN Wilayah II Pulau Harapan";
        } elseif ($id == 3) {
            $titik_gerbang = 'Jl. Salemba Raya No.9, RT.1/RW.3, Paseban, Senen, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10440';
            $sptn = "SPTN Wilayah III Pulau Pramuka";
        }

        $data['judul'] = "Aksesibilitas ".$sptn;
        $config['sensor'] = TRUE;
        $config['zoom'] = 'auto';
        $config['map_height'] = '550px';
        $config['center'] = 'auto';
        $config['zoom'] = 'auto';
        $config['directions'] = TRUE;
        $config['directionsStart'] = 'auto';
        $config['directionsEnd'] = $titik_gerbang;
        $config['directionsDivID'] = 'directionsDiv';
        $this->maps->initialize($config);
        $data['map'] = $this->maps->create_map();
        $this->load->view('profil/akses', $data);
        
    }

    public function pnbp()
    {
        //redirect('dashboard');
        CheckThenRedirect(empty($_SESSION['roles_id']), base_url());
        $tahun = $this->input->post('tahun');
        $data['judul'] = "Data Setoran PNBP";
        $where = array();
        if (!isset($tahun)){
            $tahun = date("Y");
        }
        $where['tahun'] = $tahun;
        $data['tahun_exist'] = $tahun;
        $query = $this->db->join('users', 'master_pnbp.user_input = users.id_user','left outer')
                ->order_by('tanggal_setor', 'ASC')
                ->get_where("master_pnbp", $where);
        if($query->num_rows() > 0){
            $data['record'] = $query->result();
        } else {
            $data['record'] = array();
        }
        $query1 = $this->db->join('tarif_pnbp', 'data_pnbp.tarif_id = tarif_pnbp.id_tarif','left outer')->order_by('id_tarif', 'ASC')->get("data_pnbp");
        if ($query1->num_rows() > 0) {
            $data['recordPNBP'] = $query1->result();
        } else {
           $data['recordPNBP'] = array();
        }
        $this->load->view('profil/pnbp',$data);
    }

    public function addpnbp() {
        $access = $this->session->sub_role;
        $access_tambahan = $this->session->sub_role_tambahan;
        if ($access == 11 || $access_tambahan == 11) { $ok = false; } else { $ok = true; }
        CheckThenRedirect($ok, base_url());
        $data['judul'] = "Tambah Data Setoran PNBP";
        $qSpec = $this->db->get("tarif_pnbp");
        $data['dataPNBP'] = $qSpec->result();
        
        $this->load->view('profil/form_create_pnbp.php',$data);  
    }

    public function createpnbp() {
        $access = $this->session->sub_role;
        $access_tambahan = $this->session->sub_role_tambahan;
        if ($access == 11 || $access_tambahan == 11) { $ok = false; } else { $ok = true; }
        CheckThenRedirect($ok, base_url());
        $now = date("Y-m-d H:i:s");
        $tahun = date("Y");
        
        $data_master = array('tanggal_setor'=>$this->input->post('tanggal_setor'),
                            'tahun'=>$tahun,
                            'user_input'=>$this->session->user_id,
                            'created_at'=>$now);
       
        $create_data_master = $this->db->set($data_master)->insert('master_pnbp');
        $new_id_master = $this->db->insert_id();
        $cekEnd = 1;
        $c_pnbp = $this->input->post('count_pnbp');
        for ($i=1; $i <= $c_pnbp; $i++) {
            $jumlah = $this->input->post('jumlah'.$i);
            if ($jumlah != '0') {
                $tarif = $this->input->post('tarif'.$i);
                $tarif_id = $this->input->post('tarif_id'.$i);
                $total = $jumlah * $tarif;
                $data_pnbp = array('master_id'=>$new_id_master,
                        'tarif_id'=>$tarif_id,
                        'jumlah'=>$jumlah,
                        'total'=>$total);
                $create_pnbp = $this->db->set($data_pnbp)->insert('data_pnbp');
            }
            $cekEnd = $i;
        }

        
        if($cekEnd == $c_pnbp){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data PNBP berhasil disimpan.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data PNBP gagal disimpan.')));
            //return false;
        }

    }

    public function editpnbp($id) {
        $access = $this->session->sub_role;
        $access_tambahan = $this->session->sub_role_tambahan;
        if ($access == 11 || $access_tambahan == 11) { $ok = false; } else { $ok = true; }
        CheckThenRedirect($ok, base_url());
        $data['judul'] = "Ubah Data Setoran PNBP";
        $query = $this->db->join('users', 'master_pnbp.user_input = users.id_user','left outer')
                ->where('id', $id)->get("master_pnbp");
        if ($query->num_rows() == 1) {
            $data['record'] = $query->row();
        } else {
           $data['record'] = array();
        }
        $query1 = $this->db->join('tarif_pnbp', 'data_pnbp.tarif_id = tarif_pnbp.id_tarif','left outer')->where('master_id', $id)->order_by('id_tarif', 'ASC')->get("data_pnbp");
        if ($query1->num_rows() > 0) {
            $data['rowPNBP'] = $query1->result();
        } else {
           $data['rowPNBP'] = array();
        }

        $qSpec = $this->db->get("tarif_pnbp");
        $data['dataPNBP'] = $qSpec->result();

        $this->load->view('profil/form_edit_pnbp.php',$data);      
    }

    public function updatepnbp() {
        $access = $this->session->sub_role;
        $access_tambahan = $this->session->sub_role_tambahan;
        if ($access == 11 || $access_tambahan == 11) { $ok = false; } else { $ok = true; }
        CheckThenRedirect($ok, base_url());
        $now = date("Y-m-d H:i:s");
        $tahun = date("Y");
        $id = $this->input->post('id_master');
        
        $data_master = array('tanggal_setor'=>$this->input->post('tanggal_setor'),
                            'tahun'=>$tahun,
                            'user_input'=>$this->session->user_id,
                            'updated_at'=>$now);
        $update_data_master = $this->db->where("id", $id)->update("master_pnbp", $data_master);
        $delete = $this->db->where("master_id", $id)->delete('data_pnbp');
        $cekEnd = 1;
        $c_pnbp = $this->input->post('count_pnbp');
        for ($i=1; $i <= $c_pnbp; $i++) {
            $jumlah = $this->input->post('jumlah'.$i);
            if ($jumlah != '0') {
                $tarif = $this->input->post('tarif'.$i);
                $tarif_id = $this->input->post('tarif_id'.$i);
                $total = $jumlah * $tarif;
                $data_pnbp = array('master_id'=>$id,
                        'tarif_id'=>$tarif_id,
                        'jumlah'=>$jumlah,
                        'total'=>$total);
                $create_pnbp = $this->db->set($data_pnbp)->insert('data_pnbp');
            }
            $cekEnd = $i;
        }

        
        if($cekEnd == $c_pnbp){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data PNBP berhasil disimpan.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data PNBP gagal disimpan.')));
            //return false;
        }

    }

    public function deletepnbp() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $access = $this->session->sub_role;
        $access_tambahan = $this->session->sub_role_tambahan;
        if ($access == 11 || $access_tambahan == 11) { $ok = false; } else { $ok = true; }
        CheckThenRedirect($ok, base_url());
        $id = $this->input->post('id');
        $delete = $this->db->where("id", $id)->delete('master_pnbp');
        $delete = $this->db->where("master_id", $id)->delete('data_pnbp');
        if($delete){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data berhasil dihapus.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data gagal dihapus.')));
            //return false;
        }
    }

    public function statistikpnbp()
    {
        $query1 = $this->db->select('SUM(jumlah) as total')->join('master_pnbp', 'master_pnbp.id = data_pnbp.master_id')->join('tarif_pnbp', 'tarif_pnbp.id_tarif = data_pnbp.tarif_id')->where('tahun', date('Y'))->like('detail_1', 'orang', 'both')->get('data_pnbp');
        $data1 = $query1->row();
        $query2 = $this->db->select('SUM(jumlah) as total,detail_3 as wn')->join('master_pnbp', 'master_pnbp.id = data_pnbp.master_id')->join('tarif_pnbp', 'tarif_pnbp.id_tarif = data_pnbp.tarif_id')->like('detail_1', 'orang', 'both')->where('tahun', date('Y'))->group_by('detail_3')->get('data_pnbp');
        $data2 = $query2->row();
        $query3 = $this->db->select('SUM(total) as total')->join('master_pnbp', 'master_pnbp.id = data_pnbp.master_id')->where('tahun', date('Y'))->get('data_pnbp');
        $data3 = $query3->row();
        $data['countAllPengunjung'] = $data1->total;
        $data['countAllTotal'] = $data3->total;
        $data['jmlWN'] = $query2->result();
        $this->load->view('statistik/pnbp.php',$data);
    }

    public function countpnbpbln() {
         //chart per Bulan
        $tahun = date("Y");
        $sql  =  "SELECT MONTH(tanggal_setor) as bln, SUM(total) as jml FROM master_pnbp JOIN data_pnbp ON master_pnbp.id = data_pnbp.master_id WHERE tahun = '$tahun' GROUP BY MONTH(tanggal_setor)";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $data['record'] = $query->result();
        } else {
           $data['record'] = array();
        }
             
        die(json_encode($data['record']));
    }

    public function countpnbpjenis() {
         //chart per Bulan
        $tahun = date("Y");
        $sql  =  "SELECT DISTINCT(tarif_id), tarif_pnbp.detail_2 as kategori, jumlah as jml, SUM(total) as total FROM data_pnbp LEFT JOIN tarif_pnbp ON data_pnbp.tarif_id = tarif_pnbp.id_tarif LEFT JOIN master_pnbp ON data_pnbp.master_id = master_pnbp.id WHERE tahun = '$tahun' GROUP BY data_pnbp.tarif_id ORDER BY tarif_pnbp.id_tarif ASC";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $data['record'] = $query->result();
        } else {
           $data['record'] = array();
        }
             
        die(json_encode($data['record']));
    }


    public function pengunjung() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $data['judul'] = "Data Monitoring Pengunjung";
        $lokasi = $this->input->post('lokasi');
        $where = array();
        if (!isset($lokasi)){
            $lokasi = 0;
        }
        $data['lokasi_exist'] = $lokasi;
        if ($lokasi != '0') {
            $where['lokasi_id'] = $lokasi;
        }
        $query = $this->db->select('monitoring_pengunjung.*, lokasi.detail_1 as nama_lokasi, resort.nama_resort, asal_pengunjung.detail_1 as asal_pengunjung, asal_pengunjung.*, users.nama_user')
                ->join('lokasi', 'monitoring_pengunjung.lokasi_id = lokasi.id_reference','left')
                ->join('resort', 'monitoring_pengunjung.resort_id = resort.id','left')
                ->join('asal_pengunjung', 'monitoring_pengunjung.asal_pengunjung_id = asal_pengunjung.id_reference','left')
                ->join('users', 'monitoring_pengunjung.user_input = users.id_user','left outer')
                ->order_by('tanggal', 'DESC')
                ->get_where("monitoring_pengunjung", $where);
        if($query->num_rows() > 0){
            $data['record'] = $query->result();
        } else {
            $data['record'] = array();
        }       
        $qPulau = $this->db->order_by('id_reference', 'ASC')->get("lokasi");
        $data['dataPulau'] = $qPulau->result();
        $this->load->view('profil/pengunjung',$data);

    }

    public function addpengunjung() {
        $access = $this->session->sub_role;
        $access_tambahan = $this->session->sub_role_tambahan;
        if ($access == 11 || $access_tambahan == 11) { $ok = false; } else { $ok = true; }
        CheckThenRedirect($ok, base_url());

        $data['judul'] = "Tambah Data Monitoring Pengunjung";
        $qPulau = $this->db->order_by('id_reference', 'ASC')->not_like('detail_1','Khusus','after')->not_like('detail_1','Desa','after')->not_like('detail_1','Kelurahan','after')->get("lokasi");
        $data['dataPulau'] = $qPulau->result();
        $qAsal = $this->db->order_by('id_reference', 'ASC')->get("asal_pengunjung");
        $data['dataAsal'] = $qAsal->result();
        $qRes = $this->db->where('id <=',8)->order_by('id', 'ASC')->get("resort");
        $data['dataRes'] = $qRes->result();

        $this->load->view('profil/form_create_pengunjung.php',$data);  
    }

    public function createpengunjung() {
        $access = $this->session->sub_role;
        $access_tambahan = $this->session->sub_role_tambahan;
        if ($access == 11 || $access_tambahan == 11) { $ok = false; } else { $ok = true; }
        CheckThenRedirect($ok, base_url());
        $now = date("Y-m-d H:i:s");
        
        $data_pengunjung = array('lokasi_id'=>$this->input->post('lokasi_id'),
                            'resort_id'=>$this->input->post('resort_id'),
                            'tanggal'=>$this->input->post('tanggal'),
                            'waktu'=>$this->input->post('waktu'),
                            'asal_pengunjung_id'=>$this->input->post('asal_pengunjung_id'),
                            'jml_pria'=>$this->input->post('jml_pria'),
                            'jml_wanita'=>$this->input->post('jml_wanita'),
                            'tujuan'=>$this->input->post('tujuan'),
                            'lama'=>$this->input->post('lama'),
                            'keterangan'=>$this->input->post('keterangan'),
                            'user_input'=>$this->session->user_id,
                            'created_at'=>$now);
        //upload file gambar
        $config1['upload_path']          = './assets/filetematik/';
        $config1['allowed_types']        = 'jpg|jpeg|png';
        $config1['file_name'] = 'Image-Pengunjung_'.round(microtime(true));
        $this->load->library('upload', $config1);
        $this->upload->initialize($config1);
        if($this->upload->do_upload('filefoto')){
            $filegambar_name = $this->upload->data('file_name');
            $data_pengunjung['file_foto'] = $filegambar_name;
        }
        $insert_data = $this->db->set($data_pengunjung)->insert('monitoring_pengunjung');
        if($insert_data){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Monitoring Pengunjung berhasil dibuat.')));
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Monitoring Pengunjung gagal dibuat.')));
        }      
    }

    public function editpengunjung($id) {
        $access = $this->session->sub_role;
        $access_tambahan = $this->session->sub_role_tambahan;
        if ($access == 11 || $access_tambahan == 11) { $ok = false; } else { $ok = true; }
        CheckThenRedirect($ok, base_url());
        $data['judul'] = "Ubah Data Monitoring Pengunjung";
        $query = $this->db->where('id', $id)->get("monitoring_pengunjung");
        if ($query->num_rows() == 1) {
            $data['record'] = $query->row();
        } else {
           $data['record'] = array();
        }
        $qPulau = $this->db->order_by('id_reference', 'ASC')->not_like('detail_1','Khusus','after')->not_like('detail_1','Desa','after')->not_like('detail_1','Kelurahan','after')->get("lokasi");
        $data['dataPulau'] = $qPulau->result();
        $qAsal = $this->db->order_by('id_reference', 'ASC')->get("asal_pengunjung");
        $data['dataAsal'] = $qAsal->result();
        $qRes = $this->db->where('id <=',8)->order_by('id', 'ASC')->get("resort");
        $data['dataRes'] = $qRes->result();

        $this->load->view('profil/form_edit_pengunjung.php',$data);      
    }

    public function updatepengunjung() {
        $access = $this->session->sub_role;
        $access_tambahan = $this->session->sub_role_tambahan;
        if ($access == 11 || $access_tambahan == 11) { $ok = false; } else { $ok = true; }
        CheckThenRedirect($ok, base_url());
        $id = $this->input->post('id');
        $now = date("Y-m-d H:i:s");
        
        $data_pengunjung = array('lokasi_id'=>$this->input->post('lokasi_id'),
                            'resort_id'=>$this->input->post('resort_id'),
                            'tanggal'=>$this->input->post('tanggal'),
                            'waktu'=>$this->input->post('waktu'),
                            'asal_pengunjung_id'=>$this->input->post('asal_pengunjung_id'),
                            'jml_pria'=>$this->input->post('jml_pria'),
                            'jml_wanita'=>$this->input->post('jml_wanita'),
                            'tujuan'=>$this->input->post('tujuan'),
                            'lama'=>$this->input->post('lama'),
                            'keterangan'=>$this->input->post('keterangan'),
                            'user_input'=>$this->session->user_id,
                            'updated_at'=>$now);
        //upload file gambar
        $config1['upload_path']          = './assets/filetematik/';
        $config1['allowed_types']        = 'jpg|jpeg|png';
        $config1['file_name'] = 'Image-Pengunjung_'.round(microtime(true));
        $this->load->library('upload', $config1);
        $this->upload->initialize($config1);
        if($this->upload->do_upload('filefoto')){
            $filegambar_name = $this->upload->data('file_name');
            $data_pengunjung['file_foto'] = $filegambar_name;
        }
        $update_data = $this->db->where("id", $id)->update("monitoring_pengunjung", $data_pengunjung);
        if($update_data){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Monitoring Pengunjung berhasil disimpan.')));
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Monitoring Pengunjung gagal disimpan.')));
        }      
    }

    public function deletepengunjung() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $access = $this->session->sub_role;
        $access_tambahan = $this->session->sub_role_tambahan;
        if ($access == 11 || $access_tambahan == 11) { $ok = false; } else { $ok = true; }
        CheckThenRedirect($ok, base_url());
        $id = $this->input->post('id');
        $delete = $this->db->where("id", $id)->delete('monitoring_pengunjung');
        if($delete){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data berhasil dihapus.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data gagal dihapus.')));
            //return false;
        }
    }

    public function statistikpengunjung()
    {
        $awal = date('Y').'-01-01';
        $akhir = date('Y').'-12-31';
        $query1 = $this->db->select('SUM(jml_pria) as pria, SUM(jml_wanita) as wanita, (SUM(jml_pria) + SUM(jml_wanita)) as total')->where('tanggal >=', $awal)->where('tanggal <=', $akhir)->get('monitoring_pengunjung');
        $data1 = $query1->row();
        $query2 = $this->db->select('(SUM(jml_pria) + SUM(jml_wanita)) as total,detail_1 as wn')->join('asal_pengunjung', 'monitoring_pengunjung.asal_pengunjung_id = asal_pengunjung.id_reference')->where('tanggal >=', $awal)->where('tanggal <=', $akhir)->group_by('detail_1')->get('monitoring_pengunjung');
        $data2 = $query2->row();
        $query3 = $this->db->select('SUM(total) as total')->join('master_pnbp', 'master_pnbp.id = data_pnbp.master_id')->where('tahun', date('Y'))->get('data_pnbp');
        $data3 = $query3->row();
        $data['countAllPengunjung'] = $data1->total;
        $data['countAllPria'] = $data1->pria;
        $data['countAllWanita'] = $data1->wanita;
        $data['countAllTotal'] = $data3->total;
        $data['jmlWN'] = $query2->result();
        $this->load->view('statistik/pengunjung.php',$data);
    }

    public function countpengunjungbln() {
         //chart per Bulan
        $awal = date('Y').'-01-01';
        $akhir = date('Y').'-12-31';
        $sql  =  "SELECT MONTH(tanggal) as bln, (SUM(jml_pria) + SUM(jml_wanita)) as jml FROM monitoring_pengunjung WHERE tanggal >= '$awal' AND tanggal <= '$akhir' GROUP BY MONTH(tanggal)";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $data['record'] = $query->result();
        } else {
           $data['record'] = array();
        }
             
        die(json_encode($data['record']));
    }

    public function countpengunjunglokasi() {
         //chart per Bulan
        $tahun = date("Y");
        $awal = date('Y').'-01-01';
        $akhir = date('Y').'-12-31';
        $sql  =  "SELECT DISTINCT(id), lokasi.detail_1 as kategori, (SUM(jml_pria) + SUM(jml_wanita)) as total FROM monitoring_pengunjung LEFT JOIN lokasi ON monitoring_pengunjung.lokasi_id = lokasi.id_reference WHERE tanggal >= '$awal' AND tanggal <= '$akhir' GROUP BY lokasi_id ORDER BY lokasi.id_reference ASC";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $data['record'] = $query->result();
        } else {
           $data['record'] = array();
        }
             
        die(json_encode($data['record']));
    }
}
