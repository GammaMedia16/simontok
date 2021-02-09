<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administrasi extends CI_Controller{
    //put your code here
    public function __construct()
    {
        parent::__construct();
        $this->load->library('excel');
        $this->load->model('m_referensi','m_referensi');
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
    }    

    public function index()
    {
        redirect('referensi/administrasi/data');;
    }
    
    public function data($prov=NULL,$kab_kota=NULL,$kec=NULL) {
        $where = array();
        if ($prov == NULL && $kab_kota == NULL && $kec == NULL) {
            $select = 'DISTINCT(id_prov), nama_prov';
            $where['id_prov !='] = 0;
        } else if ($prov != NULL && $kab_kota == NULL && $kec == NULL) {
            $select = 'DISTINCT(id_kab_kota), nama_kab_kota, id_prov, nama_prov';
            $where['id_prov'] = $prov;
        } else if ($prov != NULL && $kab_kota != NULL && $kec == NULL) {
            $select = 'DISTINCT(id_kec), nama_kec, id_kab_kota, nama_kab_kota, id_prov, nama_prov';
            $where['id_prov'] = $prov;
            $where['id_kab_kota'] = $kab_kota;
        } else if ($prov != NULL && $kab_kota != NULL && $kec != NULL) {
            $select = '*';
            $where['id_prov'] = $prov;
            $where['id_kab_kota'] = $kab_kota;
            $where['id_kec'] = $kec;
        }
        $data['prov'] = $prov;
        $data['kab_kota'] = $kab_kota;
        $data['kec'] = $kec;
        $data['judul'] = "Data Referensi - Administrasi Daerah";
        $query = $this->db->select($select)
                    ->order_by('id_desa', 'ASC')
                    ->get_where("adm_daerah", $where);
        if($query->num_rows() > 0){
            $data['record'] = $query->result();
        } else {
            $data['record'] = array();
        }       
        $this->load->view('adm_daerah/index',$data);
    }

    public function add($kategori=NULL,$id=NULL) {
        
        $data['judul'] = "Tambah Data Administrasi Daerah";
        if ($kategori == 'prov' && $id == NULL) {
            $data['nama_form'] = "createProvinsiForm";
            
        } else if ($kategori == 'kabkota' && $id != NULL) {
            $data['nama_form'] = "createKabKotaForm";
            $data['row_data'] = $this->m_referensi->GetProvinsi($id);

        } else if ($kategori == 'kec' && $id != NULL) {
            $data['nama_form'] = "createKecForm";
            $data['row_data'] = $this->m_referensi->GetKabKota($id);
        } else if ($kategori == 'desa' && $id != NULL) {
            $data['nama_form'] = "createDesaForm";
            $data['row_data'] = $this->m_referensi->GetKec($id);
        }  
        $data['kategori'] = $kategori;
        $data['id'] = $id;
        $this->load->view('adm_daerah/form_create.php',$data);  
    }

    public function createprovinsi() {
        $now = date("Y-m-d H:i:s");
        //GET LAST ID PROV
        $query = $this->db->select("DISTINCT(id_prov)")
                    ->order_by('id_prov', 'DESC')
                    ->limit(1)
                    ->get_where("adm_daerah");
        $row = $query->row();   
        $last_id_prov = intval(trim($row->id_prov,"0")) + 1;
        $new_id_prov = $last_id_prov.'0000';

        $data = array('id_prov'=>$new_id_prov,
                            'nama_prov'=>$this->input->post('nama_prov'),
                            'created_at'=>$now,
                            'updated_at'=>$now,
                            'user_input'=>$this->session->user_id);
        
        $create = $this->db->set($data)->insert("adm_daerah");
        if($create){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Provinsi berhasil disimpan.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Provinsi gagal disimpan.')));
            //return false;
        }             
    }

    public function createkabkota() {
        $now = date("Y-m-d H:i:s");
        //GET LAST ID KAB
        $query = $this->db->select("DISTINCT(id_kab_kota)")
                    ->where('id_prov', $this->input->post('id_prov'))
                    ->order_by('id_kab_kota', 'DESC')
                    ->limit(1)
                    ->get_where("adm_daerah");
        $row = $query->row();   
        if ($query->num_rows() == 0) {
            $new_id_kab_kota = trim($this->input->post('id_prov'),"0").'0100';
        } else {
            $kode_prov = trim($this->input->post('id_prov'),"0");
            $kode_kab_kota = trim($row->id_kab_kota,$kode_prov);
            $last_id_kab_kota = intval(trim($kode_kab_kota,'0')) + 1;
            if (strlen($last_id_kab_kota) == 1) {
                $new_id_kab_kota = trim($this->input->post('id_prov'),"0").'0'.$last_id_kab_kota.'00';
            } else if (strlen($last_id_kab_kota) == 2) {
                $new_id_kab_kota = trim($this->input->post('id_prov'),"0").$last_id_kab_kota.'00';
            }
        }
        $data = array('id_kab_kota'=>$new_id_kab_kota,
                        'nama_kab_kota'=>$this->input->post('nama_kab_kota'),
                        'id_prov'=>$this->input->post('id_prov'),
                        'nama_prov'=>$this->input->post('nama_prov'),
                        'updated_at'=>$now,
                        'user_input'=>$this->session->user_id);
        $delete = $this->db->where("id_kab_kota", 0)->where("id_prov", $this->input->post('id_prov'))->delete("adm_daerah");
        $execute = $this->db->set($data)->insert("adm_daerah");
        if($execute){
            die(json_encode(array('id_prov' => $this->input->post('id_prov'), 'status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Kabupaten/Kota berhasil disimpan.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Kabupaten/Kota gagal disimpan.')));
            //return false;
        }             
    }

    public function createkec() {
        $now = date("Y-m-d H:i:s");
        //GET LAST ID KEC
        $query = $this->db->select("DISTINCT(id_kec)")
                    ->where('id_kab_kota', $this->input->post('id_kab_kota'))
                    ->where('id_prov', $this->input->post('id_prov'))
                    ->order_by('id_kec', 'DESC')
                    ->limit(1)
                    ->get_where("adm_daerah");
        $row = $query->row();   
        if ($row->id_kec == 0) {
            $new_id_kec = intval($this->input->post('id_kab_kota')) + 1;
        } else {
            $new_id_kec = intval($row->id_kec) + 1;
        }
        $data = array('id_kec'=>$new_id_kec,
                        'nama_kec'=>$this->input->post('nama_kec'),
                        'id_kab_kota'=>$this->input->post('id_kab_kota'),
                        'nama_kab_kota'=>$this->input->post('nama_kab_kota'),
                        'id_prov'=>$this->input->post('id_prov'),
                        'nama_prov'=>$this->input->post('nama_prov'),
                        'updated_at'=>$now,
                        'user_input'=>$this->session->user_id);
        $delete = $this->db->where("id_kec", 0)->where("id_kab_kota", $this->input->post('id_kab_kota'))->delete("adm_daerah");
        $execute = $this->db->set($data)->insert("adm_daerah");
        if($execute){
            die(json_encode(array('id_kab_kota' => $this->input->post('id_kab_kota'),'id_prov' => $this->input->post('id_prov'), 'status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Kecamatan berhasil disimpan.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Kecamatan gagal disimpan.')));
            //return false;
        }             
    }

    public function createdesa() {
        $now = date("Y-m-d H:i:s");
        //GET LAST ID KEC
        $query = $this->db->select("DISTINCT(id_desa)")
                    ->where('id_kec', $this->input->post('id_kec'))
                    ->where('id_kab_kota', $this->input->post('id_kab_kota'))
                    ->where('id_prov', $this->input->post('id_prov'))
                    ->order_by('id_desa', 'DESC')
                    ->limit(1)
                    ->get_where("adm_daerah");
        $query1 = $this->db->select("DISTINCT(id_desa)")
                    ->where('id_kec', $this->input->post('id_kec'))
                    ->where('id_kab_kota', $this->input->post('id_kab_kota'))
                    ->where('id_prov', $this->input->post('id_prov'))
                    ->order_by('id_desa', 'DESC')
                    ->get_where("adm_daerah");
        $row = $query->row();   
        if ($row->id_desa == '') {
            $new_kode_desa = $this->input->post('id_kec').'1';
        } else {
            $get_new_kode_desa =  intval($query1->num_rows()) + 1;
            $new_kode_desa =  $this->input->post('id_kec').$get_new_kode_desa;
        }
        $data = array('id_desa'=>$new_kode_desa,
                        'nama_desa'=>$this->input->post('nama_desa'),
                        'id_kec'=>$this->input->post('id_kec'),
                        'nama_kec'=>$this->input->post('nama_kec'),
                        'id_kab_kota'=>$this->input->post('id_kab_kota'),
                        'nama_kab_kota'=>$this->input->post('nama_kab_kota'),
                        'id_prov'=>$this->input->post('id_prov'),
                        'nama_prov'=>$this->input->post('nama_prov'),
                        'lat'=>$this->input->post('lat'),
                        'lon'=>$this->input->post('lon'),
                        'sejarah'=>$this->input->post('sejarah'),
                        'updated_at'=>$now,
                        'user_input'=>$this->session->user_id);
        $delete = $this->db->where("id_desa", '')->where("id_kec", $this->input->post('id_kec'))->delete("adm_daerah");
        $execute = $this->db->set($data)->insert("adm_daerah");
        if($execute){
            die(json_encode(array('id_kec' => $this->input->post('id_kec'),'id_kab_kota' => $this->input->post('id_kab_kota'),'id_prov' => $this->input->post('id_prov'), 'status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Desa berhasil disimpan.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Desa gagal disimpan.')));
            //return false;
        }             
    }

    public function edit($kategori=NULL,$id=NULL) {
        if ($kategori == 'prov' && $id != NULL) {
            $data['row_data'] = $this->m_referensi->GetProvinsi($id);
        } else if ($kategori == 'kabkota' && $id != NULL) {
            $data['row_data'] = $this->m_referensi->GetKabKota($id);
        } else if ($kategori == 'kec' && $id != NULL) {
            $data['row_data'] = $this->m_referensi->GetKec($id);
        } else if ($kategori == 'desa' && $id != NULL) {
            $data['row_data'] = $this->m_referensi->GetDesa($id);
        } 
        $data['kategori'] = $kategori;
        $data['id'] = $id;
        
        $data['judul'] = "Ubah Data Administrasi Daerah";

        $this->load->view('adm_daerah/form_edit',$data);      
    }

    public function updatedata() {
        $now = date("Y-m-d H:i:s");
        $id_kec = 0;
        $id_kab_kota = 0;
        $id_prov = 0;

        $kategori = $this->input->post('kategori');

        if ($kategori == 'prov') {
            $id = $this->input->post('id_prov');
            $id_prov = $id;
            $col_id = 'id_prov';
            $data = array('nama_prov'=>$this->input->post('nama_prov'),
                        'updated_at'=>$now,
                        'user_input'=>$this->session->user_id);
        } else if ($kategori == 'kabkota') {
            $id = $this->input->post('id_kab_kota');
            $id_prov = $this->input->post('id_prov');
            $col_id = 'id_kab_kota';
            $data = array('nama_kab_kota'=>$this->input->post('nama_kab_kota'),
                        'updated_at'=>$now,
                        'user_input'=>$this->session->user_id);
        } else if ($kategori == 'kec') {
            $id = $this->input->post('id_kec');
            $col_id = 'id_kec';
            $id_prov = $this->input->post('id_prov');
            $id_kab_kota = $this->input->post('id_kab_kota');
            
            $data = array('nama_kec'=>$this->input->post('nama_kec'),
                        'updated_at'=>$now,
                        'user_input'=>$this->session->user_id);
        } else if ($kategori == 'desa') {
            $id = $this->input->post('id_desa');
            $col_id = 'id_desa';
            $id_prov = $this->input->post('id_prov');
            $id_kab_kota = $this->input->post('id_kab_kota');
            $id_kec = $this->input->post('id_kec');
            $data = array('nama_desa'=>$this->input->post('nama_desa'),
                        'lat'=>$this->input->post('lat'),
                        'lon'=>$this->input->post('lon'),
                        'sejarah'=>$this->input->post('sejarah'),
                        'updated_at'=>$now,
                        'user_input'=>$this->session->user_id);
        }
        $update = $this->db->where($col_id, $id)
                            ->update("adm_daerah", $data);
        if($update){
            die(json_encode(array('kategori' => $kategori,'id_kec' => $id_kec,'id_kab_kota' => $id_kab_kota,'id_prov' => $id_prov,'status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Administrasi Daerah berhasil diubah.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Administrasi Daerah Gagal diubah.')));
            //return false;
        }
    }

    public function detail($id)
    {
        $data['row_data'] = $this->m_referensi->GetDesa($id);
        $data['judul'] = "Detail Data Administrasi Daerah";

        $this->load->view('adm_daerah/form_detail',$data);
    }
    public function delete() {
        CheckThenRedirect($_SESSION['sub_role'] != 7, base_url());
        $id = $this->input->post('id');
        $query = $this->db->where('id', $id)->get("web_berita");
        $row = $query->row();
        $filegambar = $row->gambar;
        if ($filegambar != "") {
            unlink('./assets/image-news/'.$filegambar);
        }
        

        $delete = $this->db->where("id", $id)->delete("web_berita");
        
        if($delete){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Berita berhasil dihapus.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Berita gagal dihapus.')));
            //return false;
        }
    }

    
}
