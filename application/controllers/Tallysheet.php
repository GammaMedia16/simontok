<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Tallysheet extends CI_Controller{
    //put your code here
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        //$this->load->library('session');
        $this->load->library('maps');
        $this->load->library('compress');
        $this->load->library('excel');
        $this->load->library('word');
        $this->session->kk = NULL;
        $this->session->nama_resort = NULL;
        set_time_limit(0);
        ini_set("memory_limit","1024M");
        ini_set('allow_url_fopen','1');
        ini_set('allow_url_include','1');
    }    
    

    public function index() {
        redirect('tallysheet/validasi');
    }

    public function baru() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());

        $tallysheet = $this->input->post('tallysheet');
        $resort = $this->input->post('resort');
        
        if (!isset($resort)){
            $resort = 0;
        }

        if (!isset($tallysheet)){
            $tallysheet = 0;
        }
        
        $where = array();
        if ($tallysheet != 0) {
            $where['tallysheet_id'] = $tallysheet;
        }
        if ($resort != 0) {
            $where['data_monitoring.resort_id'] = $resort;
        }
        $data['tall_exist'] = $tallysheet;
        $data['res_exist'] = $resort;
        $where['flag_id'] = 1;
        $query = $this->db->select('DISTINCT(tallysheet_id), data_monitoring.*,data_monitoring.id as id_data_monitoring,master_tallysheet.*,resort.id,resort.nama_resort,UI.nama_user as nama_user_input')
                ->join('master_tallysheet', 'data_monitoring.tallysheet_id = master_tallysheet.id','left outer')
                ->join('resort', 'data_monitoring.resort_id = resort.id','left outer')
                ->join('users as UI', 'data_monitoring.user_input = UI.id_user','left outer')
                ->order_by('date_input', 'ASC')
                ->get_where("data_monitoring", $where);
        if($query->num_rows() > 0){
            $data['record'] = $query->result();
        } else {
            $data['record'] = array();
        }
        $qRes = $this->db->where('id <=',8)->order_by('id', 'ASC')->get("resort");
        $data['dataRes'] = $qRes->result();
        $qTallysheet = $this->db->order_by('id', 'ASC')->get("master_tallysheet");
        $data['dataTallysheet'] = $qTallysheet->result();

        $this->load->view('tallysheet/index_baru.php',$data);   
    }

    public function valid() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());

        $tallysheet = $this->input->post('tallysheet');
        $resort = $this->input->post('resort');
        if (!isset($resort)){
            $resort = 0;
        }if (!isset($tallysheet)){
            $tallysheet = 0;
        }
        
        $where = array();
        if ($tallysheet != '0') {
            $where['tallysheet_id'] = $tallysheet;
        }
        if ($resort != '0') {
            $where['data_monitoring.resort_id'] = $resort;
        }
        $data['tall_exist'] = $tallysheet;
        $data['res_exist'] = $resort;
        $where['flag_id'] = 2;
        $query = $this->db->select('DISTINCT(tallysheet_id), data_monitoring.*,data_monitoring.id as id_data_monitoring,master_tallysheet.*,resort.id,resort.nama_resort,UI.nama_user as nama_user_input')
                ->join('master_tallysheet', 'data_monitoring.tallysheet_id = master_tallysheet.id','left outer')
                ->join('resort', 'data_monitoring.resort_id = resort.id','left outer')
                ->join('users as UI', 'data_monitoring.user_input = UI.id_user','left outer')
                ->order_by('date_input', 'ASC')
                ->get_where("data_monitoring", $where);
        if($query->num_rows() > 0){
            $data['record'] = $query->result();
        } else {
            $data['record'] = array();
        }
        $qRes = $this->db->where('id <=',8)->order_by('id', 'ASC')->get("resort");
        $data['dataRes'] = $qRes->result();
        $qTallysheet = $this->db->order_by('id', 'ASC')->get("master_tallysheet");
        $data['dataTallysheet'] = $qTallysheet->result();

        $this->load->view('tallysheet/index_valid.php',$data);   
    }

    public function trash() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());

        $tallysheet = $this->input->post('tallysheet');
        $resort = $this->input->post('resort');
        if (!isset($resort)){
            $resort = 0;
        }if (!isset($tallysheet)){
            $tallysheet = 0;
        }
        $data['tall_exist'] = $tallysheet;
        $data['res_exist'] = $resort;
        $where = array();
        if ($tallysheet != '0') {
            $where['tallysheet_id'] = $tallysheet;
        }
        if ($resort != '0') {
            $where['data_monitoring.resort_id'] = $resort;
        }
        $where['flag_id'] = 3;
        $query = $this->db->select('DISTINCT(tallysheet_id), data_monitoring.*,data_monitoring.id as id_data_monitoring,master_tallysheet.*,resort.id,resort.nama_resort,UI.nama_user as nama_user_input')
                ->join('master_tallysheet', 'data_monitoring.tallysheet_id = master_tallysheet.id','left outer')
                ->join('resort', 'data_monitoring.resort_id = resort.id','left outer')
                ->join('users as UI', 'data_monitoring.user_input = UI.id_user','left outer')
                ->order_by('date_input', 'ASC')
                ->get_where("data_monitoring", $where);
        if($query->num_rows() > 0){
            $data['record'] = $query->result();
        } else {
            $data['record'] = array();
        }
        $qRes = $this->db->where('id <=',8)->order_by('id', 'ASC')->get("resort");
        $data['dataRes'] = $qRes->result();
        $qTallysheet = $this->db->order_by('id', 'ASC')->get("master_tallysheet");
        $data['dataTallysheet'] = $qTallysheet->result();

        $this->load->view('tallysheet/index_trash.php',$data);   
    }

    public function ekspor() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $data['judul'] = "Ekspor";
        $qForm = $this->db->order_by('id', 'ASC')->get("master_tallysheet");
        $data['dataTallysheet'] = $qForm->result();
        $qFlag = $this->db->order_by('id_flag', 'ASC')->get("flag");
        $data['dataFlag'] = $qFlag->result();
        $qRes = $this->db->where('id <=',8)->order_by('id', 'ASC')->get("resort");
        $data['dataResort'] = $qRes->result();
        
        $this->load->view('tallysheet/index_ekspor.php',$data);   
    }

    public function formadd() {
        CheckThenRedirect(!$_SESSION['loggedIn'], base_url());
        $access = $this->session->roles_id;
        $tahun = date("Y");
        $data['tahun_exist'] = $tahun;
        $qRes = $this->db->where('id <=',8)->order_by('id', 'ASC')->get("resort");
        $data['dataRes'] = $qRes->result();
        $qForm = $this->db->order_by('id', 'ASC')->get("master_tallysheet");
        $qPetugas = $this->db->order_by('id_user', 'ASC')->where(array('role_id'=>2,'resort_id <>'=>0))->get("users");
        $data['dataTallysheet'] = $qForm->result();
        $data['dataPetugas'] = $qPetugas->result();
        $this->load->view('tallysheet/form_create.php',$data);
    }

    public function create() {
        CheckThenRedirect(!$_SESSION['loggedIn'], base_url());
        $tahun = date("Y");
        $data['tahun_exist'] = $tahun;
        $now = date("Y-m-d H:i:s");
        //Field Data Monitoring
        $tallysheet_id = $this->input->post('tallysheet_id');
        $resort_id = $this->input->post('resort_id');
        $c_petugas = count($this->input->post('petugas_id[]'));
        $petugas_id = "";
        for ($i=0; $i < $c_petugas; $i++) { 
            $x=$c_petugas-1;
            $petugas_id .= $this->input->post('petugas_id['.$i.']');
            if ($i != $x) {
                $petugas_id .= ";";
            }
        }
        $lat = $this->input->post('lat');
        $lon = $this->input->post('lon');
        $date_tallysheet = $this->input->post('date_tallysheet');
        $time_tallysheet = $this->input->post('time_tallysheet');
        $date_time = $date_tallysheet.' '.$time_tallysheet;
        $no_reg = 'REG-'.$tallysheet_id.'-'.$resort_id.'-'.round(microtime(true));

        $data_monitoring = array('no_reg'=>$no_reg,
                                'tallysheet_id'=>$tallysheet_id,
                                'resort_id'=>$resort_id,
                                'lat'=>$lat,
                                'lon'=>$lon,
                                'date_time'=>$date_time);

        $where['id'] = $tallysheet_id;
        $qTallysheet = $this->db->get_where("master_tallysheet", $where);
        $r_tallysheet = $qTallysheet->row();
        $reference_column = $r_tallysheet->reference_column;
        $arr_reff_col = explode(';', $reference_column);
        $description = $r_tallysheet->description;
        $arr_description = explode(';', $description);
        $field_reff = "";
        $a=0;
        $c_reff = count($arr_reff_col) - 1;
        foreach ($arr_reff_col as $val_reff) {
            $field_reff .= $this->input->post($val_reff);
            if ($a != $c_reff) {
                $field_reff .= ";";
            }
            $a++;
        }
        $field_des = "";
        $b=0;
        $c_des = count($arr_description) - 1;
        foreach ($arr_description as $val_des) {
            $field_des .= $this->input->post($val_des);
            if ($b != $c_des) {
                $field_des .= ";";
            }
            $b++;
        }
        $value_reff = $field_reff;
        $value_des = $field_des;

        //add reff & dess
        $data_monitoring = $data_monitoring + array('reference_column' => $value_reff, 'description' => $value_des);
        //array_push($data_monitoring, ['reference_column' => $post_reff, 'description' => $post_des]);
        
        $config['upload_path']          = './assets/filemonitoring/';
        $config['allowed_types']        = 'jpg|jpeg|png';
        $config['file_name'] = 'foto_'.$no_reg;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        
        if($this->upload->do_upload('file_foto')){
            $file_foto_name = $this->upload->data('file_name');
            $data_monitoring = $data_monitoring + array('file_foto' => $file_foto_name);
        } 
        
        $data_monitoring = $data_monitoring + array('petugas_id'=>$petugas_id,'user_input'=>$this->session->user_id,'date_input'=>$now,'flag_id'=>1);


        $create_data_monitoring = $this->db->set($data_monitoring)->insert('data_monitoring');
        $new_id = $this->db->insert_id();
        if($create_data_monitoring){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Monitoring berhasil disimpan.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Monitoring gagal disimpan.')));
            //return false;
        }

    }

    public function getmastertallysheet() {
        CheckThenRedirect(!$_SESSION['loggedIn'], base_url());
        $id_tallysheet = $this->input->get('id_tallysheet');
        $where['id'] = $id_tallysheet;
        $query = $this->db->get_where("master_tallysheet", $where);
        if($query->num_rows() > 0){
            $data['record'] = $query->row();
        } else {
            $data['record'] = array();
        }       
        die(json_encode(array("row" => $data['record'])));
    }

    public function getreferencetallysheet() {
        CheckThenRedirect(!$_SESSION['loggedIn'], base_url());
        $tabel = $this->input->get('table_name');
        $query = $this->db->get($tabel);
        $data['count_field'] = $query->num_fields();
        if($query->num_rows() > 0){
            $data['record_reff'] = $query->result();
        } else {
            $data['record_reff'] = array();
        }       
        die(json_encode(array("row_reff" => $data['record_reff'],"c_field" => $data['count_field'])));
    }

    public function edit($id) {
        CheckThenRedirect(!$_SESSION['loggedIn'], base_url());
        $tahun = date("Y");
        $data['tahun_exist'] = $tahun;
        $where = array('data_monitoring.id'=>$id);
        $query = $this->db->select('data_monitoring.*,data_monitoring.id as id_data_monitoring,master_tallysheet.name,master_tallysheet.id as id_tallysheet,master_tallysheet.reference_column as reference_column_tallysheet,master_tallysheet.description as description_tallysheet,resort.id as id_resort,resort.nama_resort')
                ->join('master_tallysheet', 'data_monitoring.tallysheet_id = master_tallysheet.id','left outer')
                ->join('resort', 'data_monitoring.resort_id = resort.id','left outer')
                ->order_by('date_time', 'DESC')
                ->get_where("data_monitoring", $where);
        if($query->num_rows() > 0){
            $data['record'] = $query->row();
        } else {
            $data['record'] = array();
        }
        $qRes = $this->db->where('id <=',8)->order_by('id', 'ASC')->get("resort");
        $data['dataRes'] = $qRes->result();
        $qForm = $this->db->order_by('id', 'ASC')->get("master_tallysheet");
        $data['dataTallysheet'] = $qForm->result();
        $qPetugas = $this->db->order_by('id_user', 'ASC')->where(array('role_id'=>2,'resort_id <>'=>0))->get("users");
        $data['dataPetugas'] = $qPetugas->result();
        $this->load->view('tallysheet/form_edit.php',$data);
    }

    public function update() {
        CheckThenRedirect(!$_SESSION['loggedIn'], base_url());
        $tahun = date("Y");
        $now = date("Y-m-d H:i:s");
        //Field Data Monitoring
        $id_data_monitoring = $this->input->post('id_data_monitoring');
        $file_foto_old = $this->input->post('file_foto_old');
        $tallysheet_id = $this->input->post('tallysheet_id');
        $resort_id = $this->input->post('resort_id');
        $c_petugas = count($this->input->post('petugas_id[]'));
        $petugas_id = "";
        for ($i=0; $i < $c_petugas; $i++) { 
            $x=$c_petugas-1;
            $petugas_id .= $this->input->post('petugas_id['.$i.']');
            if ($i != $x) {
                $petugas_id .= ";";
            }
        }
        $lat = $this->input->post('lat');
        $lon = $this->input->post('lon');
        $date_tallysheet = $this->input->post('date_tallysheet');
        $time_tallysheet = $this->input->post('time_tallysheet');
        $date_time = $date_tallysheet.' '.$time_tallysheet;
        $no_reg = 'REG-'.$tallysheet_id.'-'.$resort_id.'-'.round(microtime(true));

        $data_monitoring = array('resort_id'=>$resort_id,
                                'lat'=>$lat,
                                'lon'=>$lon,
                                'date_time'=>$date_time);

        $where['id'] = $tallysheet_id;
        $qTallysheet = $this->db->get_where("master_tallysheet", $where);
        $r_tallysheet = $qTallysheet->row();
        $reference_column = $r_tallysheet->reference_column;
        $arr_reff_col = explode(';', $reference_column);
        $description = $r_tallysheet->description;
        $arr_description = explode(';', $description);
        $field_reff = "";
        $a=0;
        $c_reff = count($arr_reff_col) - 1;
        foreach ($arr_reff_col as $val_reff) {
            $field_reff .= $this->input->post($val_reff);
            if ($a != $c_reff) {
                $field_reff .= ";";
            }
            $a++;
        }
        $field_des = "";
        $b=0;
        $c_des = count($arr_description) - 1;
        foreach ($arr_description as $val_des) {
            $field_des .= $this->input->post($val_des);
            if ($b != $c_des) {
                $field_des .= ";";
            }
            $b++;
        }
        $value_reff = $field_reff;
        $value_des = $field_des;

        //add reff & dess
        $data_monitoring = $data_monitoring + array('reference_column' => $value_reff, 'description' => $value_des);
        //array_push($data_monitoring, ['reference_column' => $post_reff, 'description' => $post_des]);
        
        $config['upload_path']          = './assets/filemonitoring/';
        $config['allowed_types']        = 'jpg|jpeg|png';
        $config['file_name'] = 'foto_'.$no_reg;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        
        if($this->upload->do_upload('file_foto')){
            $file_foto_name = $this->upload->data('file_name');
            unlink('assets/filemonitoring/'.$file_foto_old);
            $data_monitoring = $data_monitoring + array('file_foto' => $file_foto_name);
        } 
        
        $data_monitoring = $data_monitoring + array('petugas_id'=>$petugas_id,'user_input'=>$this->session->user_id,'date_input'=>$now);


        $update_data_monitoring = $this->db->where("id", $id_data_monitoring)->update("data_monitoring", $data_monitoring);
        if($update_data_monitoring){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Monitoring berhasil disimpan.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Monitoring gagal disimpan.')));
            //return false;
        }
    }

    public function detail() {
        CheckThenRedirect(!$_SESSION['loggedIn'], base_url());
        $id = $this->input->get('id_data_monitoring');
        $where = array('data_monitoring.id'=>$id);
        $query = $this->db->select('data_monitoring.*,data_monitoring.id as id_data_monitoring,master_tallysheet.name,master_tallysheet.id as id_tallysheet,master_tallysheet.reference_column as reference_column_tallysheet,master_tallysheet.description as description_tallysheet,resort.id as id_resort,resort.nama_resort,UI.nama_user as nama_user_input,UV.nama_user as nama_user_verifikasi,flag.flag_name as status')
                ->join('master_tallysheet', 'data_monitoring.tallysheet_id = master_tallysheet.id','left outer')
                ->join('resort', 'data_monitoring.resort_id = resort.id','left outer')
                ->join('users as UI', 'data_monitoring.user_input = UI.id_user','left outer')
                ->join('users as UV', 'data_monitoring.user_verifikasi = UV.id_user','left outer')
                ->join('flag', 'data_monitoring.flag_id = flag.id_flag','left outer')
                ->order_by('date_time', 'DESC')
                ->get_where("data_monitoring", $where);
        if($query->num_rows() > 0){
            $data['record'] = $query->row();
        } else {
            $data['record'] = array();
        }
        die(json_encode(array("row" => $data['record'])));
    }

    public function validasi($id) {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $tahun = date("Y");
        $data['tahun_exist'] = $tahun;
        $where = array('data_monitoring.id'=>$id);
        $query = $this->db->select('data_monitoring.*,data_monitoring.id as id_data_monitoring,master_tallysheet.name,master_tallysheet.id as id_tallysheet,master_tallysheet.reference_column as reference_column_tallysheet,master_tallysheet.description as description_tallysheet,resort.id as id_resort,resort.nama_resort')
                ->join('master_tallysheet', 'data_monitoring.tallysheet_id = master_tallysheet.id','left outer')
                ->join('resort', 'data_monitoring.resort_id = resort.id','left outer')
                ->order_by('date_time', 'DESC')
                ->get_where("data_monitoring", $where);
        if($query->num_rows() > 0){
            $data['record'] = $query->row();
        } else {
            $data['record'] = array();
        }
        $RecordData = $data['record'];
        $qRes = $this->db->where('id <=',40)->order_by('id', 'ASC')->get("resort");
        $data['dataRes'] = $qRes->result();
        $qForm = $this->db->order_by('id', 'ASC')->get("master_tallysheet");
        $data['dataTallysheet'] = $qForm->result();
        $qPetugas = $this->db->order_by('id_user', 'ASC')->where(array('role_id'=>2))->get("users");
        $data['dataPetugas'] = $qPetugas->result();

        //maps
        $config['map_height'] = '300px';
        //$config['zoom'] = 12;
        $config['center'] = $RecordData->lat.', '.$RecordData->lon;
        $kmllayers = array();
        if ($RecordData->resort_id == 6) {
            $config['kmlLayerURL'] = base_url('assets/template/Resort_TNKpS.kml');
        } else {
            $config['kmlLayerURL'] = base_url('assets/kmlresort/KML_'.$RecordData->resort_id.'.kml');
        }
        $this->maps->initialize($config);

        $marker = array();
        $marker['position'] = $RecordData->lat.', '.$RecordData->lon;
        $this->maps->add_marker($marker);
        $data['map'] = $this->maps->create_map();
        $this->load->view('tallysheet/form_validasi.php',$data);
    }

    public function validation() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $tahun = date("Y");
        $now = date("Y-m-d H:i:s");
        //Field Data Monitoring
        $id_data_monitoring = $this->input->post('id_data_monitoring');
        $file_foto_old = $this->input->post('file_foto_old');
        $tallysheet_id = $this->input->post('tallysheet_id');
        $resort_id = $this->input->post('resort_id');
        $c_petugas = count($this->input->post('petugas_id[]'));
        $petugas_id = "";
        for ($i=0; $i < $c_petugas; $i++) { 
            $x=$c_petugas-1;
            $petugas_id .= $this->input->post('petugas_id['.$i.']');
            if ($i != $x) {
                $petugas_id .= ";";
            }
        }
        $lat = $this->input->post('lat');
        $lon = $this->input->post('lon');
        $date_tallysheet = $this->input->post('date_tallysheet');
        $time_tallysheet = $this->input->post('time_tallysheet');
        $date_time = $date_tallysheet.' '.$time_tallysheet;
        $no_reg = 'REG-'.$tallysheet_id.'-'.$resort_id.'-'.round(microtime(true));

        $data_monitoring = array('resort_id'=>$resort_id,
                                'lat'=>$lat,
                                'lon'=>$lon,
                                'date_time'=>$date_time);

        $where['id'] = $tallysheet_id;
        $qTallysheet = $this->db->get_where("master_tallysheet", $where);
        $r_tallysheet = $qTallysheet->row();
        $reference_column = $r_tallysheet->reference_column;
        $arr_reff_col = explode(';', $reference_column);
        $description = $r_tallysheet->description;
        $arr_description = explode(';', $description);
        $field_reff = "";
        $a=0;
        $c_reff = count($arr_reff_col) - 1;
        foreach ($arr_reff_col as $val_reff) {
            $field_reff .= $this->input->post($val_reff);
            if ($a != $c_reff) {
                $field_reff .= ";";
            }
            $a++;
        }
        $field_des = "";
        $b=0;
        $c_des = count($arr_description) - 1;
        foreach ($arr_description as $val_des) {
            $field_des .= $this->input->post($val_des);
            if ($b != $c_des) {
                $field_des .= ";";
            }
            $b++;
        }
        $value_reff = $field_reff;
        $value_des = $field_des;

        //add reff & dess
        $data_monitoring = $data_monitoring + array('reference_column' => $value_reff, 'description' => $value_des);
        //array_push($data_monitoring, ['reference_column' => $post_reff, 'description' => $post_des]);
        
        $config['upload_path']          = './assets/filemonitoring/';
        $config['allowed_types']        = 'jpg|jpeg|png';
        $config['file_name'] = 'foto_'.$no_reg;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        
        if($this->upload->do_upload('file_foto')){
            $file_foto_name = $this->upload->data('file_name');
            unlink('assets/filemonitoring/'.$file_foto_old);
            $data_monitoring = $data_monitoring + array('file_foto' => $file_foto_name);
        } 
        
        $data_monitoring = $data_monitoring + array('petugas_id'=>$petugas_id,'user_verifikasi'=>$this->session->user_id,'date_verifikasi'=>$now,'flag_id'=>2);


        $update_data_monitoring = $this->db->where("id", $id_data_monitoring)->update("data_monitoring", $data_monitoring);
        if($update_data_monitoring){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Monitoring berhasil disimpan.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Monitoring gagal disimpan.')));
            //return false;
        }
    }

    public function gagalvalidation() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $tahun = date("Y");
        $now = date("Y-m-d H:i:s");
        //Field Data Monitoring
        $id_data_monitoring = $this->input->post('id_data_monitoring');
        $data_monitoring = array('user_verifikasi'=>$this->session->user_id,'date_verifikasi'=>$now,'flag_id'=>3);

        $update_data_monitoring = $this->db->where("id", $id_data_monitoring)->update("data_monitoring", $data_monitoring);
        if($update_data_monitoring){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Monitoring berhasil disimpan.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Monitoring gagal disimpan.')));
            //return false;
        }
    }

    public function getdatapetugas() {
        CheckThenRedirect(!$_SESSION['loggedIn'], base_url());
        $data_petugas = $this->input->get('data_petugas');
        $arr_petugas = explode(';', $data_petugas);
        $query = $this->db->select('id_user,nama_user')->order_by('id_user', 'ASC')
                ->where(array('role_id'=>2))->get("users");
        $record = $query->result();
        $val_petugas = "";
        $x = count($arr_petugas);
        foreach ($record as $row) {
            for ($i=0; $i < $x; $i++) { 
                if ($row->id_user == $arr_petugas[$i]) {
                    $val_petugas .= $row->nama_user;
                    if ($i != $x) {
                        $val_petugas .= "; ";
                    }
                }
            }
        }     
        die(json_encode(array("value_petugas" => $val_petugas)));
    }

    public function getdatareferensi() {
        CheckThenRedirect(!$_SESSION['loggedIn'], base_url());
        $value = $this->input->get('val');
        $tabel = $this->input->get('tabel');
        $query = $this->db->where(array('id_reference'=>$value))->get($tabel);
        $row = $query->row();
        if ($value == '' || $value == 0) {
            $c_col = 1;
        } else {
            $c_col = $query->num_fields();
        }
        switch ($c_col) {
            case 1:
                $value_referensi = "***Kosong***";
                break;
            case 2:
                $value_referensi = $row->detail_1;
                break;
            case 3:
                $value_referensi = $row->detail_1.' / '.$row->detail_2;
                break;
            case 4:
                $value_referensi = $row->detail_1.' / '.$row->detail_2.' / '.$row->detail_3;
                break;
            default:
                $value_referensi = $row->detail_1;
                break;
        }  
              
        die(json_encode(array("value_data" => $value_referensi)));
    }

    

    public function countperbln() {
        $tahun = date("Y");
        $sql  =  "SELECT MONTH(date_time) as bln, COUNT(MONTH(date_time)) as jml FROM data_monitoring WHERE date_time LIKE '$tahun%' GROUP BY MONTH(date_time)";
        $qCount = $this->db->query($sql);
        if ($qCount->num_rows() > 0) {
            $data['cRekap'] = $qCount->result();
        } else {
           $data['cRekap'] = array();
        }
        die(json_encode($data['cRekap']));
    }

    public function getdatareff($tabel,$value) {
        $query = $this->db->where('id_reference',$value)->get($tabel);
        $row = $query->row();
        $c_col = $query->num_fields();
        if($query->num_rows() > 0){
            switch ($c_col) {
                case 2:
                    $value_referensi = $row->detail_1;
                    break;
                case 3:
                    $value_referensi = $row->detail_1.' / '.$row->detail_2;
                    break;
                case 4:
                    $value_referensi = $row->detail_1.' / '.$row->detail_2.' / '.$row->detail_3;
                    break;
                default:
                    $value_referensi = $row->detail_1;
                    break;
            }
        } else {
            $value_referensi = "";
        }  
        echo $value_referensi;
    }

    public function getdatareffekspor($tabel,$value) {
        $query = $this->db->where('id_reference',$value)->get($tabel);
        $row = $query->row();
        $c_col = $query->num_fields();
        if($query->num_rows() > 0){
            switch ($c_col) {
                case 2:
                    $value_referensi = $row->detail_1;
                    break;
                case 3:
                    $value_referensi = $row->detail_1.' / '.$row->detail_2;
                    break;
                case 4:
                    $value_referensi = $row->detail_1.' / '.$row->detail_2.' / '.$row->detail_3;
                    break;
                default:
                    $value_referensi = $row->detail_1;
                    break;
            }
        } else {
            $value_referensi = "";
        }  
        return $value_referensi;
    }

    
    public function getdataresort($value="") {
        $query = $this->db->where(array('nama_resort'=>$value))->get('resort');
        $row = $query->row();
        if($query->num_rows() > 0){
            $id = $row->id;
        } else {
            $id = 0;
        }
        return $id;
    }

    public function getdatareffimport($tabel,$value) {
        $query = $this->db->where(array('detail_1'=>$value))->get($tabel);
        $row = $query->row();
        if($query->num_rows() > 0){
            $id = $row->id_reference;
        } else {
            $id = 0;
        }
        return $id;
    }
    public function getdatajeniskegiatan($value="") {
        $arrtallysheet = explode(",", $value);
        $a=0;
        $c_tall = count($arrtallysheet) - 1;
        $field_id = "";
        foreach ($arrtallysheet as $val_tall) {
            $query = $this->db->where('name', trim($val_tall))->get('master_tallysheet');
            $row = $query->row();
            if($query->num_rows() == 1){
                $field_id .= $row->id;
            } else {
                $field_id .= 0;
            }
            if ($a != $c_tall) {
                $field_id .= ";";
            }
            $a++;
        }
        return $field_id;
    }

    public function getdatapeg($value) {
        $arr_petugas = explode(';', $value);
        $query = $this->db->select('id_user,nama_user')
                ->where(array('role_id'=>2))->get("users");
        $record = $query->result();
        $val_petugas = "";
        $x = count($arr_petugas);
        foreach ($record as $row) {
            for ($i=0; $i < $x; $i++) { 
                if ($row->id_user == $arr_petugas[$i]) {
                    $val_petugas .= $row->nama_user;
                    if ($i != $x) {
                        $val_petugas .= "; ";
                    }
                }
            }
        }     
        echo $val_petugas;
    }

    public function getdatapegekspor($value) {
        $arr_petugas = explode(';', $value);
        $query = $this->db->select('id_user,nama_user')
                ->where(array('role_id'=>2))->get("users");
        $record = $query->result();
        $val_petugas = "";
        $x = count($arr_petugas);
        foreach ($record as $row) {
            for ($i=0; $i < $x; $i++) { 
                if ($row->id_user == $arr_petugas[$i]) {
                    $val_petugas .= $row->nama_user;
                    if ($i != $x) {
                        $val_petugas .= ";";
                    }
                }
            }
        }     
        return $val_petugas;
    }

    public function getdatapegimport($value) {
        $arr_petugas = explode(',', $value);
        $query = $this->db->select('id_user,nama_user')
                ->where(array('role_id'=>2))->get("users");
        $record = $query->result();
        $val_petugas = "";
        $x = count($arr_petugas);
        foreach ($record as $row) {
            for ($i=0; $i < $x; $i++) { 
                if ($row->nama_user == $arr_petugas[$i]) {
                    $val_petugas .= $row->id_user;
                    if ($i != $x) {
                        $val_petugas .= ";";
                    }
                }
            }
        }     
        return $val_petugas;
    }

    public function import() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $data['judul'] = "Import";
        $data['dari'] = $this->input->post('dari');
        $data['sampai'] = $this->input->post('sampai');
        $record = array();
        if (empty($_FILES['fileimport']['name'])){
            $view = false;
            $data['highestColumn'] = 0;
            $data['highestRow'] = 0;
            $jenis_unggah = 0;
            $record = array();
            $dataMemento = "";
            $dataReffCol = "";
            $dataDesCol = "";
            $id_tallysheet = 0;
            $jenis_kegiatan = "";
        } else {
            $view = true;
            $inputFileName = $_FILES['fileimport']['tmp_name']; 
            $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
            $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
            $data['highestColumn'] = PHPExcel_Cell::columnIndexFromString($objWorksheet->getHighestColumn());
            $data['highestRow'] = $objWorksheet->getHighestRow();
            $record = $objWorksheet->toArray();

            $recm = implode(";", $record[0]);
            $qMemento = $this->db->where('field_memento',$recm)->get("master_tallysheet");
            $rMemento = $qMemento->row();
            $dataMemento = $rMemento->field_memento;
            $dataReffCol = $rMemento->reference_column;
            $dataDesCol = $rMemento->description;
            $jenis_kegiatan = $rMemento->name;
            $id_tallysheet = $rMemento->id;
            //echo $recm;
        }
        $data['id_tallysheet'] = $id_tallysheet;
        $data['jenis_kegiatan'] = $jenis_kegiatan;
        $data['dataReffCol'] = $dataReffCol;
        $data['dataDesCol'] = $dataDesCol;
        $data['dataMemento'] = $dataMemento;
        $data['record'] = $record;
        $data['view'] = $view;
        $this->load->view('tallysheet/index_import.php',$data);   
    }

    public function importdata() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $tahun = date("Y");
        $data['tahun_exist'] = $tahun;
        $now = date("Y-m-d H:i:s");
        $jmldata = $this->input->post('jmldata');
        $cekEnd = 0;
        
        for ($i=1; $i <= $jmldata; $i++) {
            $resort_id = $this->input->post('resort_id'.$i);
            $lat = $this->input->post('lat'.$i);
            $lon = $this->input->post('lon'.$i);
            $date_time = $this->input->post('date_time'.$i);
            $tallysheet_id = $this->input->post('tallysheet_id'.$i);
            $petugas_id = $this->input->post('petugas_id'.$i);
            $foto = $this->input->post('foto'.$i);
            $no_reg = 'REG-'.$tallysheet_id.'-'.$resort_id.'-'.round(microtime(true)).$i;
            $query = $this->db->where('id', $tallysheet_id)->get('master_tallysheet');
            $row = $query->row();
            if($query->num_rows() == 1){
                $field_reff = $row->reference_column;
                $description = $row->description;
                $arr_reff_col = explode(';', $field_reff);
                $arr_description = explode(';', $description);
                $field_reff = "";
                $a=0;
                $c_reff = count($arr_reff_col) - 1;
                foreach ($arr_reff_col as $val_reff) {
                    $field_reff .= $this->input->post($val_reff.$i);
                    if ($a != $c_reff) {
                        $field_reff .= ";";
                    }
                    $a++;
                }
                $field_des = "";
                $b=0;
                $c_des = count($arr_description) - 1;
                foreach ($arr_description as $val_des) {
                    $field_des .= $this->input->post($val_des.$i);
                    if ($b != $c_des) {
                        $field_des .= ";";
                    }
                    $b++;
                }
                $data_monitoring = array('no_reg'=>$no_reg,
                                        'tallysheet_id'=>$tallysheet_id,
                                        'resort_id'=>$resort_id,
                                        'lat'=>$lat,
                                        'lon'=>$lon,
                                        'date_time'=>$date_time,
                                        'reference_column' => $field_reff,
                                        'description' => $field_des,
                                        'petugas_id' => $petugas_id,
                                        'user_input'=>$this->session->user_id,
                                        'date_input'=>$now,
                                        'flag_id'=>1);
                if ( $foto != "" || strpos( $foto,'http' ) !== false || strpos( $foto,'https' ) !== false ){
                    //compress image
                    $file = base_url('assets/cacheimage/image'.$i.'.jpg');
                    $new_name_image = $no_reg; 
                    $quality = 10; // Value that I chose
                    $destination = base_url('assets/filemonitoring/'); // This destination 

                    $compress = new Compress();
                    $compress->file_url = $file;
                    $compress->new_name_image = $new_name_image;
                    $compress->quality = $quality;
                    $compress->destination = $destination;
                    $result = $compress->compress_image();
                    $data_monitoring['file_foto'] = $new_name_image.'.jpg';
                    if (file_exists('assets/cacheimage/image'.$i.'.jpg')) { 
                        unlink('assets/cacheimage/image'.$i.'.jpg');
                    }
                }
                $this->db->set($data_monitoring)->insert('data_monitoring');
            }
            $cekEnd++;
        }
        if($cekEnd == $jmldata){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Monitoring berhasil disimpan.')));
            //return true;
        } else {
           die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Monitoring gagal disimpan.')));
            //return false;
        }
    }

    public function getdatatallysheet() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $id = $this->input->get('id');
        $query = $this->db->where('id',$id)->get('master_tallysheet');
        $row = $query->row();
        $value = str_replace(" ", "_", $row->name);
        die(json_encode(array("value_data" => $value)));
    }

    public function ekspordata() {
        define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        
        $dari = $this->input->post('dari');
        $sampai = $this->input->post('sampai');
        $tgldari = date_create($dari); 
        $tgl_dari = date_format($tgldari, 'd F Y');
        $tglsmp = date_create($sampai); 
        $tgl_sampai = date_format($tglsmp, 'd F Y');
        //-----------
        $periode = $tgl_dari.' - '.$tgl_sampai;
        
        $tahun = date("Y");
        $tallysheet_id = $this->input->post('tallysheet_id');
        $resort_id = $this->input->post('resort_id');
        $flag_id = $this->input->post('flag_id');
        $where = array();
        $where['tallysheet_id'] = $tallysheet_id;
        $where['date_time >='] = $dari." 00:00:01";
        $where['date_time <='] = $sampai." 23:59:59";
        if ($resort_id != '0') {
            $where['resort_id'] = $resort_id;
        }
        if ($flag_id != '0') {
            $where['flag_id'] = $flag_id;
        }
        $query = $this->db->select('data_monitoring.*,data_monitoring.id as id_data_monitoring,master_tallysheet.name,master_tallysheet.id as id_tallysheet,master_tallysheet.reference_column as reference_column_tallysheet,master_tallysheet.description as description_tallysheet,resort.id as id_resort,resort.nama_resort,flag.*')
                ->join('master_tallysheet', 'data_monitoring.tallysheet_id = master_tallysheet.id','left outer')
                ->join('resort', 'data_monitoring.resort_id = resort.id','left outer')
                ->join('flag', 'data_monitoring.flag_id = flag.id_flag','left outer')
                ->order_by('date_input', 'ASC')
                ->get_where("data_monitoring", $where);
        if($query->num_rows() > 0){
            $record = $query->result();
        } else {
            $record = array();
        }
        $qTallysheet = $this->db->order_by('id', 'ASC')->where('id',$tallysheet_id)->get("master_tallysheet");
        $dataCol = $qTallysheet->row();
        $ColName = $dataCol->name;
        $ColReff = $dataCol->reference_column;
        $ColDes = $dataCol->description;
        $ReffCol = explode(';', $ColReff);
        $DesCol = explode(';', $ColDes);
        ($ColReff != "") ? $cReff = count($ReffCol) : $cReff = 0;
        $cDes = count($DesCol);

        $filename = 'assets/template/ekspor/'.strtolower(str_replace(" ", "_", $ColName)).'.xls';

        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        
        $objPHPExcel = $objReader->load($filename);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 4, $periode);
        //GET DATA
        $baseRow = 7;
        $baseCol = 1;
        $no = 1;
        foreach($record as $r => $dataRow) {
            $row = $baseRow + $r;
            $ReffVal = explode(';', $dataRow->reference_column);
            $DesVal = explode(';', $dataRow->description);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $no)
                          ->setCellValueByColumnAndRow(2, $row, $dataRow->name)
                          ->setCellValueByColumnAndRow(3, $row, $dataRow->nama_resort)
                          ->setCellValueByColumnAndRow(4, $row, $dataRow->lat)
                          ->setCellValueByColumnAndRow(5, $row, $dataRow->lon)
                          ->setCellValueByColumnAndRow(6, $row, $dataRow->date_time);
                for ($i=7; $i <= ($cReff + $cDes + 6); $i++) { 
                    $batas_reff = $cReff + 6;
                    if ($i <= $batas_reff && $cReff != 0) {
                        $a = $i - 7;
                        $value = $ReffVal[$a];
                        $tabel = $ReffCol[$a];
                        $getReff = $this->getdatareffekspor($tabel,$value);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i, $row, $getReff);
                    } else {
                        $b = $i - $cReff - 7;
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i, $row, $DesVal[$b]); 
                    }
                }
            $pPetugas = $cReff + $cDes + 6 + 1;
            $getPetugas = $this->getdatapegekspor($dataRow->petugas_id);
            $pStatus = $cReff + $cDes + 6 + 2;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($pPetugas, $row, $getPetugas);
            $no++;
        }
        //$objPHPExcel->getActiveSheet()->removeRow($baseRow-1,1);
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="Data_'.str_replace(" ", "_", $ColName).'_'.date('dmY').'.xls"');
        
        // If you're serving to IE over SSL, then the following may be needed
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        //$objWriter->save(str_replace('.php', '.xls', __FILE__));
        $objWriter->save('php://output');
        exit;
    }

    public function cetaklaporan($id,$user) {
        CheckThenRedirect($_SESSION['user_id'] != $user, base_url());
        $query = $query = $this->db->select('data_monitoring.*,data_monitoring.id as id_data_monitoring,master_tallysheet.name,master_tallysheet.id as id_tallysheet,master_tallysheet.reference_column as reference_column_tallysheet,master_tallysheet.description as description_tallysheet,resort.id as id_resort,resort.nama_resort,flag.*')
                ->join('master_tallysheet', 'data_monitoring.tallysheet_id = master_tallysheet.id','left outer')
                ->join('resort', 'data_monitoring.resort_id = resort.id','left outer')
                ->join('flag', 'data_monitoring.flag_id = flag.id_flag','left outer')
                ->where('data_monitoring.id',$id)->get('data_monitoring');
        if($query->num_rows() > 0){
            $data = $query->row();
        } else {
            redirect('dashboard');
        }
        $query1 = $this->db->where('id_user',$user)->get('users');
        if($query1->num_rows() > 0){
            $user = $query1->row();
        } else {
            redirect('dashboard');
        }

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $templateProcessor = $phpWord->loadTemplate('assets/template/format_laporan.docx');

        /*$section = $phpWord->addSection();
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $myHtml, true);*/

        // Variables on different parts of document
        $datetime = date_create($data->date_time);
        $waktu = date_format($datetime, 'd M Y H:i:s');
        $titik_koordinat = $data->lat.', '.$data->lon;
        $hasil_kegiatan = "";

        if ($data->reference_column_tallysheet != "") {
            $ref_col = explode(";", $data->reference_column_tallysheet);
            $ref_val = explode(";", $data->reference_column);
            $x=0;
            foreach ($ref_col as $colref) {
                $hasil_kegiatan .= ucwords(str_replace("_", " ", $colref))." : ";
                $hasil_kegiatan .= $this->getdatareffekspor($colref,$ref_val[$x])."<w:br/>";
                $x++;
            }
        }
        $des_col = explode(";", $data->description_tallysheet);
        $des_val = explode(";", $data->description);
        $y=0;
        foreach ($des_col as $coldes) {
            $hasil_kegiatan .= ucwords(str_replace("_", " ", $coldes)).": ";
            $hasil_kegiatan .= preg_replace("/[\\n\\r]+/", "", $des_val[$y])."<w:br/>";
            $y++;
        }
        

        $templateProcessor->setValue('nama_user', $user->nama_user); 
        $templateProcessor->setValue('nip', $user->nip); 
        $templateProcessor->setValue('tallysheet', strtoupper($data->name)); 
        $templateProcessor->setValue('datetime', $waktu); 
        $templateProcessor->setValue('titik_koordinat', $titik_koordinat); 
        $templateProcessor->setValue('resort', $data->nama_resort); 
        $templateProcessor->setValue('hasil_kegiatan', $hasil_kegiatan); 
        $templateProcessor->setValue('date_now', date('d F Y')); 
        

        if ($data->file_foto != "") {
            $pathfoto = base_url('assets/filemonitoring/'.$data->file_foto);

            //$templateProcessor->setValue('selector_foto', file_get_contents($pathfoto));
            /*$templateProcessor->setImg('selector_foto', array(
                'src'  => '../assets/filemonitoring/'.$data->file_foto //px
            ));*/
            $templateProcessor->setValue('selector_foto', '');
        } else {
            $templateProcessor->setValue('selector_foto', '');
        }
            

        $fnnip = str_replace(" ", "", $user->nip);
        $temp_filename = 'Laporan_Petugas_'.$fnnip.'.docx';
        $templateProcessor->saveAs($temp_filename);

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.$temp_filename);
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: '.filesize($temp_filename));
        flush();
        readfile($temp_filename);
        unlink($temp_filename);
        exit;                
    }

    public function delete() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $tahun = date("Y");
        $data['tahun_exist'] = $tahun;
        $table = "surat_masuk_".$tahun;

        $id_surat = $this->input->post('id_surat');
        $query = $this->db->where('id', $id_surat)->get($table);
        $row = $query->row();
        $filesurat = $row->filesurat;
        unlink('./assets/filesurat/surat_masuk/'.$tahun.'/'.$filesurat);

        $delete_surat = $this->db->where("id", $id_surat)->delete($table);
        
        if($delete_surat){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Surat Masuk berhasil dihapus.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Surat Masuk gagal dihapus.')));
            //return false;
        }
    }

}
