<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Galeri extends CI_Controller{
    //put your code here
    public function __construct()
    {
        parent::__construct();
        $this->load->library('pagination');
    }    
    
    public function index() {  
        //CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $data['judul'] = "Galeri Dokumentasi Taman Nasional Kepulauan Seribu";
        $query = $this->db->select('*, DATE_FORMAT(album_galeri.updated_at,\'%d %b %Y\') as newtgl')
                    ->join('users', 'album_galeri.user_input = users.id_user')
                    ->order_by('id_album_galeri', 'DESC')
                    ->get('album_galeri');
        if($query->num_rows() > 0){
            $data['record'] = $query->result();
        } else {
            $data['record'] = array();
        }       
        $this->load->view('galeri/index', $data);
        
    }

    public function kk($id=null) {  
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $where = array();
        if (!isset($id)) {
            redirect('resort');
        } else {
            $where['id_resort'] = $id;
        }

        $data['judul'] = "Galeri Dokumentasi Taman Nasional Kepulauan Seribu";
        $query = $this->db->select('*, DATE_FORMAT(album_galeri.updated_at,\'%d %b %Y\') as newtgl')
                    ->join('users', 'album_galeri.user_input = users.id_user')
                    ->order_by('id_album_galeri', 'DESC')
                    ->get('album_galeri',$where);
        if($query->num_rows() > 0){
            $data['record'] = $query->result();
        } else {
            $data['record'] = array();
        }       
        $this->load->view('galeri/index_resort', $data);
        
    }

    public function createalbum() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());

        $now = date("Y-m-d H:i:s");
        $table = "album_galeri";
        
        $data_album = array('nama_album'=>$this->input->post('nama_album'),
                        'user_input'=>$this->session->user_id,
                        'created_at'=>$now,
                        'updated_at'=>$now);

        $create_album = $this->db->set($data_album)->insert($table);
        $new_id_album = $this->db->insert_id();
        if($create_album){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Album berhasil dibuat.', 'new_id_album' => $new_id_album)));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Album Gagal dibuat.')));
            //return false;
        }
    }

    public function updatealbum() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());

        $now = date("Y-m-d H:i:s");
        $table = "album_galeri";
        $id_album_galeri = $this->input->post('id_album_galeri');
        $data_album = array('nama_album'=>$this->input->post('nama_album'),
                        'user_input'=>$this->session->user_id,
                        'updated_at'=>$now);

        $update_album = $this->db->where("id_album_galeri", $id_album_galeri)
                        ->update($table, $data_album);
        if($update_album){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Album berhasil diubah.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Album Gagal diubah.')));
            //return false;
        }
    }

    public function hapusalbum() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $table = "album_galeri";

        $id_album_galeri = $this->input->post('id_album_galeri');
        $query = $this->db
                ->select('PG.*, AG.*, UA.nama_user as user_album, UP.nama_user as user_photo')
                ->from('photo_galeri as PG')
                ->join('album_galeri as AG', 'PG.album_galeri_id = AG.id_album_galeri')
                ->join('users as UA', 'AG.user_input = UA.id_user')
                ->join('users as UP', 'PG.user_input = UP.id_user')
                ->where('AG.id_album_galeri', $id_album_galeri)
                ->get();
        $hasil = $query->result();
        foreach ($hasil as $rows) {
            unlink('assets/filegaleri/'.$rows->file_name_foto);
        }
        
        $delete_album = $this->db->where("id_album_galeri", $id_album_galeri)->delete($table);
        $delete_foto = $this->db->where("album_galeri_id", $id_album_galeri)->delete('photo_galeri');
        if($delete_album && $delete_foto){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Album berhasil dihapus.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Album gagal dihapus.')));
            //return false;
        }
    }

    public function hapusfoto() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $table = "photo_galeri";

        $id_photo_galeri = $this->input->post('id_photo_galeri');
        $query = $this->db
                ->select('PG.*, AG.*, UA.nama_user as user_album, UP.nama_user as user_photo')
                ->from('photo_galeri as PG')
                ->join('album_galeri as AG', 'PG.album_galeri_id = AG.id_album_galeri')
                ->join('users as UA', 'AG.user_input = UA.id_user')
                ->join('users as UP', 'PG.user_input = UP.id_user')
                ->where('PG.id_photo_galeri', $id_photo_galeri)
                ->get();

        $result = $query->row();
        $filefoto = $result->file_name_foto;
        unlink('assets/filegaleri/'.$filefoto);
        
        $delete_foto = $this->db->where("id_photo_galeri", $id_photo_galeri)->delete('photo_galeri');
        
        if($delete_foto){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Foto berhasil dihapus.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Foto gagal dihapus.')));
            //return false;
        }
    }

    public function createfotogaleri() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $cekEnd = 1;
        $countFile = $this->input->post('countFile');
        $cekForm = $this->input->post('cekForm');
        $id_album_galeri = $this->input->post('id_album_galeri');
        for ($i=1; $i <= $countFile; $i++) { 
            $table = "photo_galeri";
            $now = date("Y-m-d H:i:s");
            $file = 'filefoto'.$i;
            $captionid = 'caption'.$i;
            $config['upload_path']          = './assets/filegaleri/';
            $config['allowed_types']        = 'jpg|jpeg|png';
            $config['file_name'] = 'album'.$id_album_galeri.'_foto'.round(microtime(true));

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            
            if($this->upload->do_upload($file)){
                $filenamefoto = $this->upload->data('file_name');
            } else {
                $filenamefoto = "";
            }

            $caption = $this->input->post($captionid);
            if ($i == 1) {
                $data_album = array('file_photo_album'=>$filenamefoto,
                        'user_input'=>$this->session->user_id,
                        'updated_at'=>$now);
                $update_album = $this->db->where("id_album_galeri", $id_album_galeri)->update("album_galeri", $data_album);
            }

            $data_foto = array('caption'=>$caption,
                        'file_name_foto'=>$filenamefoto,
                        'album_galeri_id'=>$id_album_galeri,
                        'user_input'=>$this->session->user_id,
                        'created_at'=>$now,
                        'updated_at'=>$now);
            $create_foto = $this->db->set($data_foto)->insert($table);
            $cekEnd = $i;
        }
        
        if($cekEnd == $countFile){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Foto Berhasil ditambahkan', 'cekform' => $cekForm, 'id_album' => $id_album_galeri)));
            //return true;
        }
    }
    
    public function album($id) {
        //CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $query = $this->db
                ->select('PG.*, AG.*, UA.nama_user as user_album, UP.nama_user as user_photo')
                ->from('photo_galeri as PG')
                ->join('album_galeri as AG', 'PG.album_galeri_id = AG.id_album_galeri')
                ->join('users as UA', 'AG.user_input = UA.id_user')
                ->join('users as UP', 'PG.user_input = UP.id_user')
                ->where('PG.album_galeri_id', $id)
                ->order_by('id_photo_galeri', 'ASC')
                ->get();
        $query1 = $this->db
                ->from('album_galeri')
                ->where('id_album_galeri', $id)
                ->get();
        $recordAlbum = $query1->row();
        $data['judul'] = $recordAlbum->nama_album;
        $data['id_album_galeri'] = $recordAlbum->id_album_galeri;
        $data['user_input'] = $recordAlbum->user_input;
        if($query->num_rows() > 0){
            $data['record'] = $query->result();
            
        } else {
            $data['record'] = array();
            
        }
        $this->load->view('galeri/album',$data);
    }

    public function formaddfoto($id) {

        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $query = $this->db
                ->select('PG.*, AG.*, UA.nama_user as user_album, UP.nama_user as user_photo')
                ->from('photo_galeri as PG')
                ->join('album_galeri as AG', 'PG.album_galeri_id = AG.id_album_galeri')
                ->join('users as UA', 'AG.user_input = UA.id_user')
                ->join('users as UP', 'PG.user_input = UP.id_user')
                ->where('PG.album_galeri_id', $id)
                ->order_by('id_photo_galeri', 'ASC')
                ->get();
        $query1 = $this->db
                ->from('album_galeri')
                ->where('id_album_galeri', $id)
                ->get();
        
        if($query->num_rows() > 0){
            $data['record'] = $query->result();
            $recordAlbum = $query1->row();
            $data['judul'] = $recordAlbum->nama_album;
            $data['id_album_galeri'] = $recordAlbum->id_album_galeri;
            $data['user_input'] = $recordAlbum->user_input;
        } else {
            $data['record'] = array();
            $data['judul'] = 0;
            $data['id_album_galeri'] = 0;
            $data['user_input'] = 0;
        }
        $this->load->view('galeri/form_tambah_foto',$data);
    }

    public function getgaleri() {
        $id = $this->input->get('id_album_galeri');
        $query = $this->db
                ->select('PG.*, DATE_FORMAT(PG.updated_at,\'%d %b %Y\') as newtgl, AG.*, UA.nama_user as user_album, UP.nama_user as user_photo')
                ->from('photo_galeri as PG')
                ->join('album_galeri as AG', 'PG.album_galeri_id = AG.id_album_galeri')
                ->join('users as UA', 'AG.user_input = UA.id_user')
                ->join('users as UP', 'PG.user_input = UP.id_user')
                ->where('PG.album_galeri_id', $id)
                ->order_by('id_photo_galeri', 'ASC')
                ->get();
        
        if($query->num_rows() > 0){
            $data['record'] = $query->result();
        } else {
            $data['record'] = array();
        }
        die(json_encode($data['record']));
    }

    public function getalbum() {
        $id = $this->input->get('id_album_galeri');
        $query = $this->db
                ->from('album_galeri')
                ->where('id_album_galeri', $id)
                ->get();
        
        if($query->num_rows() > 0){
            $data['record'] = $query->row();
        } else {
            $data['record'] = array();
        }
        die(json_encode($data['record']));
    }

    public function makedefaultfoto() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());

        $now = date("Y-m-d H:i:s");
        $table = "album_galeri";
        $id_album_galeri = $this->input->post('id_album_galeri');
        $data_album = array('file_photo_album'=>$this->input->post('file_photo'),
                        'user_input'=>$this->session->user_id,
                        'updated_at'=>$now);

        $update_album = $this->db->where("id_album_galeri", $id_album_galeri)
                        ->update($table, $data_album);
        if($update_album){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Album berhasil diubah.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Album Gagal diubah.')));
            //return false;
        }
    }

    public function video($page = 1) {
        $data['judul'] = "Galeri Video Taman Nasional Kepulauan Seribu";
        
        if (!$this->session->roles_id == 2) {
            $url = base_url('website/galerivideo');
            $limit  = 6;
            $total = $this->db->count_all('video_galeri');
            $offset = ($page - 1) * $limit;

            //Galeri
            $query4 = $this->db->select('*')
                        ->from('video_galeri')
                        ->join('users', 'video_galeri.user_input = users.id_user')
                        ->order_by('create_date', 'DESC')
                        ->limit($limit,$offset)
                        ->get();
            if($query4->num_rows() > 0){
                $data['record_video'] = $query4->result();
            } else {
                $data['record_video'] = array();
            }
        

            
            //pagination
            $config['base_url']         = $url;
            $config['total_rows']       = $total;
            $config['per_page']         = $limit;
            $config['use_page_numbers'] = true;
            $config['num_links']        = 5;
            $config['full_tag_open']    = '<ul class="pagination">';
            $config['full_tag_close']   = '</ul>';
            $config['first_link']       = 'First';
            $config['last_link']        = 'Last';
            $config['first_tag_open']   = '<li>';
            $config['first_tag_close']  = '</li>';
            $config['prev_link']        = '&laquo';
            $config['prev_tag_open']    = '<li class="prev">';
            $config['prev_tag_close']   = '</li>';
            $config['next_link']        = '&raquo';
            $config['next_tag_open']    = '<li>';
            $config['next_tag_close']   = '</li>';
            $config['last_tag_open']    = '<li>';
            $config['last_tag_close']   = '</li>';
            $config['cur_tag_open']     = '<li class="active"><a href="">';
            $config['cur_tag_close']    = '</a></li>';
            $config['num_tag_open']     = '<li>';
            $config['num_tag_close']    = '</li>';

            $this->pagination->initialize($config);
            $pagination = $this->pagination->create_links();

            $data['pagination'] = $pagination;
            $data['total'] = $total;
            $this->load->view('website/video', $data);
        } else {
            $data['judul'] = "Galeri Video";
            $query = $this->db->select('*')
                        ->from('video_galeri')
                        ->join('users', 'video_galeri.user_input = users.id_user')
                        ->get();
            if($query->num_rows() > 0){
                $data['record'] = $query->result();
            } else {
                $data['record'] = array();
            }       
            $this->load->view('video/index',$data);
        }    
    }

    public function addvideo() {
        CheckThenRedirect($_SESSION['sub_role'] != 7, base_url());

        $data['judul'] = "Tambah Data Galeri Video";
        
        $this->load->view('video/form_create.php',$data);  
    }

    public function createvideo() {
        
        CheckThenRedirect($_SESSION['sub_role'] != 7, base_url());
        header('Content-Type: application/x-www-form-urlencoded');
        $now = date("Y-m-d H:i:s");
        
        $data = array('judul'=>$this->input->post('judul'),
                            'url'=>$this->input->post('url'),
                            'create_date'=>$now,
                            'user_input'=>$this->session->user_id);
        
        $create = $this->db->set($data)->insert("video_galeri");
        $new_id = $this->db->insert_id();
        if($create){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Video berhasil disimpan.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Video gagal disimpan.')));
            //return false;
        }  
            
    }

    public function editvideo($id) {
        CheckThenRedirect($_SESSION['sub_role'] != 7, base_url());

        $query = $this->db->where('id', $id)->get("video_galeri");
        if ($query->num_rows() == 1) {
            $data['record'] = $query->row();
        } else {
           $data['record'] = array();
        }
        
        $data['judul'] = "Ubah Data Galeri Video";

        $this->load->view('video/form_edit',$data);      
    }

    public function updatevideo() {
        CheckThenRedirect($_SESSION['sub_role'] != 7, base_url());
        //header('Content-Type: application/x-www-form-urlencoded');
        $now = date("Y-m-d H:i:s");
        $id = $this->input->post('id');
        
        $data = array('judul'=>$this->input->post('judul'),
                            'url'=>$this->input->post('url'),
                            'create_date'=>$now,
                            'user_input'=>$this->session->user_id);

        $update = $this->db->where("id", $id)
                            ->update("video_galeri", $data);
        if($update){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Video Galeri berhasil diubah.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Video Galeri Gagal diubah.')));
            //return false;
        }
    }

    public function deletevideo() {
        CheckThenRedirect($_SESSION['sub_role'] != 7, base_url());
        $id = $this->input->post('id');
        
        $delete = $this->db->where("id", $id)->delete("video_galeri");
        
        if($delete){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Video Galeri berhasil dihapus.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Video Galeri gagal dihapus.')));
            //return false;
        }
    }

}
