<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Desabinaan extends CI_Controller{
    //put your code here
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_referensi','m_referensi');
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
    }    
    
    public function index() {
        $prov_id = $this->input->post('prov_id');
        $data['judul'] = 'Desa Binaan';
        
        if (!isset($prov_id)){
            $prov_id = 0;
        }
        $where = array();
        if ($prov_id != 0) {
            $where['id_prov'] = $prov_id;
        } 
        
        $where['status_binaan'] = 1;
        $data['prov_exist'] = $prov_id;
        if ($this->session->sub_role == 4 ) {
            $where['satker.kode_satker'] = $this->session->satker_kode;
            $query = $this->db->select('*')
                ->join('kelompok', 'FIND_IN_SET(adm_daerah.id_desa, kelompok.desa_id)','left outer', false)
                ->join('pdskk', 'kelompok.id_kelompok = pdskk.kelompok_id','left outer')
                ->join('satker', 'kelompok.satker_kode = satker.kode_satker','left outer')
                ->group_by('adm_daerah.id_desa')
                ->order_by('nama_desa', 'ASC')
                ->get_where("adm_daerah", $where);
        } else {
            $query = $this->db->order_by('nama_desa', 'ASC')
                ->get_where("adm_daerah", $where);
        }
        /**/
        
        if($query->num_rows() > 0){
            $data['record'] = $query->result();
        } else {
            $data['record'] = array();
        }
        
        $data['dataProv'] = $this->m_referensi->GetAllProvinsi();
        
        $this->load->view('desabinaan/index.php',$data);
    }

    public function edit($id) {
        $data['judul'] = "Ubah Data Desa Binaan";
        $data['row_data'] = $this->m_referensi->GetDesa($id);
        $this->load->view('desabinaan/form_edit',$data); 
    }

    public function update() {
        $now = date("Y-m-d H:i:s");
        $id = $this->input->post('id_desa');
        $data = array('nama_desa'=>$this->input->post('nama_desa'),
                    'lat'=>$this->input->post('lat'),
                    'lon'=>$this->input->post('lon'),
                    'sejarah'=>$this->input->post('sejarah'),
                    'updated_at'=>$now,
                    'user_input'=>$this->session->user_id);
        $update = $this->db->where('id_desa', $id)
                            ->update("adm_daerah", $data);
        if($update){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Desa Binaan berhasil diubah.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Desa Binaan Gagal diubah.')));
            //return false;
        }
    }
    
   
}
