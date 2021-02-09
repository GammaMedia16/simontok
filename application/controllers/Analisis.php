<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Analisis extends CI_Controller{
    //put your code here
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('maps');
        //CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
    }    
    
    public function index() {  
        $data['judul'] = "Profil Balai Taman Nasional Kepulauan Seribu";
        $this->session->kk = NULL;
        $resort = $this->input->get('resort_id');
        $tallysheet = $this->input->get('tallysheet_id');
        $dari = $this->input->get('dari');
        $sampai = $this->input->get('sampai');
        
        
        if (isset($resort) || isset($tallysheet)){
            if ($tallysheet != 0 && $resort == 0) {
                redirect('analisis/hasiltallysheet?t='.$tallysheet.'&d='.$dari.'&s='.$sampai);
            }
            if ($resort != 0 && $tallysheet == 0) {
                redirect('analisis/hasilresort?r='.$resort.'&d='.$dari.'&s='.$sampai);
            }
            if ($tallysheet != 0 && $resort != 0) {
                redirect('analisis/hasilresorttallysheet?t='.$tallysheet.'&r='.$resort.'&d='.$dari.'&s='.$sampai);
            }
            if ($tallysheet == 0 && $resort == 0 && isset($resort) && isset($tallysheet)) {
                redirect('analisis/alldata?d='.$dari.'&s='.$sampai);
            }
        } else {
            $tallysheet = 0;
            $resort = 0;
        }

        $data['tall_exist'] = $tallysheet;
        $data['res_exist'] = $resort;
            

        $qRes = $this->db->order_by('id', 'ASC')->get("resort");
        $data['dataRes'] = $qRes->result();
        $qTallysheet = $this->db->order_by('id', 'ASC')->get("master_tallysheet");
        $data['dataTallysheet'] = $qTallysheet->result();
        $this->load->view('analisis/index', $data);
    }

    public function pegawai() {  
        $this->session->kk = NULL;
        
        $dari = $this->input->get('dari');
        $sampai = $this->input->get('sampai');
        
        if (count($_GET) == 0) {
            $record = array();
            $view = false;
            $petugas_id = $this->session->user_id;
            $data['countPNew'] = 0;
            $data['countPValid'] = 0;
            $data['countPTrash'] = 0;
            $data['countPTotal'] = 0;
            $data['rPotensi'] = array();
            $data['rMasalah'] = array();
            $data['rLain'] = array();
            $data['record'] = array();
        } else {
            //All Data per Resort
            //->like('petugas_id', $petugas_id, 'both')
            $view = true;
            $petugas_id = $this->input->get('petugas_id');
            $qNew = $this->db->where(array('date_time >=' => $dari." 00:00:01",'date_time <=' => $sampai." 23:59:59",'flag_id' => 1))->get('data_monitoring');
            $datacountNew = $qNew->result();
            $qValid = $this->db->where(array('date_time >=' => $dari." 00:00:01",'date_time <=' => $sampai." 23:59:59",'flag_id' => 2))->get('data_monitoring');
            $datacountValid = $qValid->result();
            $qTrash = $this->db->where(array('date_time >=' => $dari." 00:00:01",'date_time <=' => $sampai." 23:59:59",'flag_id' => 3))->get('data_monitoring');
            $datacountTrash = $qTrash->result();
            $cN = 0;
            foreach ($datacountNew as $rNew) {
                $arr_petugas1 = explode(';', $rNew->petugas_id); 
                if (in_array($petugas_id, $arr_petugas1)) { 
                    $cN++;
                }
            }
            $data['countNew'] = $cN;
            $cV = 0;
            foreach ($datacountValid as $rValid) {
                $arr_petugas2 = explode(';', $rValid->petugas_id); 
                if (in_array($petugas_id, $arr_petugas2)) { 
                    $cV++;
                }
            }
            
            $data['countValid'] = $cV;
            $cT = 0;
            foreach ($datacountTrash as $rTrash) {
                $arr_petugas3 = explode(';', $rTrash->petugas_id); 
                if (in_array($petugas_id, $arr_petugas3)) { 
                    $cT++;
                }
            }
            $data['countTrash'] = $cT;

            $data['countTotalData'] = $data['countNew'] + $data['countValid'] + $data['countTrash'];
            if ($data['countTotalData'] != 0) {
                $data['countPNew'] = round(($data['countNew'] / $data['countTotalData']) * 100,2);
                $data['countPValid'] = round(($data['countValid'] / $data['countTotalData']) * 100,2) ;
                $data['countPTrash'] = round(($data['countTrash'] / $data['countTotalData']) * 100,2) ;
                $data['countPTotal'] = round(($data['countTotalData'] / $data['countTotalData']) * 100,0) ;
            } else {
                $data['countPNew'] = 0;
                $data['countPValid'] = 0;
                $data['countPTrash'] = 0;
                $data['countPTotal'] = 0;
            }
            
            $query = $this->db->select('DISTINCT(tallysheet_id), data_monitoring.*,data_monitoring.id as id_data_monitoring,master_tallysheet.*,resort.id,resort.nama_resort,UI.nama_user as nama_user_input')
                ->join('master_tallysheet', 'data_monitoring.tallysheet_id = master_tallysheet.id','left outer')
                ->join('resort', 'data_monitoring.resort_id = resort.id','left outer')
                ->join('users as UI', 'data_monitoring.user_input = UI.id_user','left outer')
                ->where(array('date_time >=' => $dari." 00:00:01",'date_time <=' => $sampai." 23:59:59",'flag_id' => 2))
                ->order_by('date_input', 'ASC')
                ->get("data_monitoring");
            if($query->num_rows() > 0){
                $data['record'] = $query->result();
            } else {
                $data['record'] = array();
            }
            
            
        }

        $qPetugas = $this->db->order_by('id_user', 'ASC')->where(array('role_id'=>2,'resort_id <>'=>0))->get("users");
        $data['dataPetugas'] = $qPetugas->result();
        $qStaf = $this->db->where(array('id_user'=>$petugas_id))->get("users");
        $dataStaf = $qStaf->row();
        $data['petugas_exist'] = $petugas_id;
        $data['nama_petugas'] = $dataStaf->nama_user;
        $data['dari'] = $dari;
        $data['sampai'] = $sampai;
        $data['view'] = $view;
        $this->load->view('analisis/index_pegawai', $data);
    }

    public function hasiltallysheet()
    {
        $id = $this->input->get('t');
        $dari = $this->input->get('d');
        $sampai = $this->input->get('s');
        $qTallysheet = $this->db->where('id',$id)->get("master_tallysheet");
        $dataTallysheet = $qTallysheet->row();
        $data['judul'] = $dataTallysheet->name;
        $data['t_id'] = $id;
        $data['dari'] = $dari;
        $data['sampai'] = $sampai;
        $data['ref_column'] = $dataTallysheet->reference_column;
        if ($dataTallysheet->reference_column == "") {
            $countReff = 0;
        } else {
            $arr_reff_col = explode(';', $dataTallysheet->reference_column);
            $countReff = count($arr_reff_col);
        }
        $data['jml_ref_column'] = $countReff;
        $this->load->view('analisis/index_hasiltallysheet', $data);
    }

    public function hasilresort()
    {
        //$tahun = date("Y");
        //->like('date_time', $tahun, 'after')
        $tahun = date('Y');
        $id_resort = $this->input->get('r');
        $dari = $this->input->get('d');
        $sampai  = $this->input->get('s');
        
        $qResort = $this->db->where('id',$id_resort)->get("resort");
        $dataResort = $qResort->row();
        $data['nama_resort'] = $dataResort->nama_resort;
        $data['r_id'] = $id_resort;
        $data['dari'] = $dari;
        $data['sampai'] = $sampai;

        //All Data per Resort
        $qNew = $this->db->where(array('date_time >=' => $dari." 00:00:01",'date_time <=' => $sampai." 23:59:59",'flag_id' => 1,'resort_id' => $id_resort))->get('data_monitoring');
        $qValid = $this->db->where(array('date_time >=' => $dari." 00:00:01",'date_time <=' => $sampai." 23:59:59",'flag_id' => 2,'resort_id' => $id_resort))->get('data_monitoring');
        $qTrash = $this->db->where(array('date_time >=' => $dari." 00:00:01",'date_time <=' => $sampai." 23:59:59",'flag_id' => 3,'resort_id' => $id_resort))->get('data_monitoring');
        $data['countNew'] = $qNew->num_rows();
        $data['countValid'] = $qValid->num_rows();
        $data['countTrash'] = $qTrash->num_rows();
        $data['countTotalData'] = $data['countNew'] + $data['countValid'] + $data['countTrash'];
        if ($data['countTotalData'] != 0) {
            $data['countPNew'] = round(($data['countNew'] / $data['countTotalData']) * 100,2);
            $data['countPValid'] = round(($data['countValid'] / $data['countTotalData']) * 100,2) ;
            $data['countPTrash'] = round(($data['countTrash'] / $data['countTotalData']) * 100,2) ;
            $data['countPTotal'] = round(($data['countTotalData'] / $data['countTotalData']) * 100,0) ;
        } else {
            $data['countPNew'] = 0;
            $data['countPValid'] = 0;
            $data['countPTrash'] = 0;
            $data['countPTotal'] = 0;
        }
        
        //select tallysheet
        $sql1 = "SELECT DISTINCT(tallysheet_id), master_tallysheet.* FROM data_monitoring LEFT JOIN master_tallysheet ON data_monitoring.tallysheet_id = master_tallysheet.id WHERE date_time >= '$dari 23:59:00' AND date_time <= '$sampai 23:59:00' AND resort_id = ".$id_resort." AND flag_id = 2";
        $query1 = $this->db->query($sql1);
        if($query1->num_rows() > 0){
            $data['rTallysheet'] = $query1->result();
        } else {
            $data['rTallysheet'] = array();
        }

        $this->load->view('analisis/index_hasilresort', $data);
    }
        //'date_time >=' => $dari." 00:00:01",'date_time <=' => $sampai." 23:59:59",
    public function alldata()
    {
        $tahun = date('Y');
        $dari = $this->input->get('d');
        $sampai  = $this->input->get('s');
        $data['dari'] = $dari;
        $data['sampai'] = $sampai;

        //All Data Rekap
        $qNew = $this->db->where(array('date_time >=' => $dari." 00:00:01",'date_time <=' => $sampai." 23:59:59",'flag_id' => 1))->get('data_monitoring');
        $qValid = $this->db->where(array('date_time >=' => $dari." 00:00:01",'date_time <=' => $sampai." 23:59:59",'flag_id' => 2))->get('data_monitoring');
        $qTrash = $this->db->where(array('date_time >=' => $dari." 00:00:01",'date_time <=' => $sampai." 23:59:59",'flag_id' => 3))->get('data_monitoring');
        $data['countNew'] = $qNew->num_rows();
        $data['countValid'] = $qValid->num_rows();
        $data['countTrash'] = $qTrash->num_rows();
        $data['countTotalData'] = $data['countNew'] + $data['countValid'] + $data['countTrash'];
        if ($data['countTotalData'] != 0) {
            $data['countPNew'] = round(($data['countNew'] / $data['countTotalData']) * 100,2);
            $data['countPValid'] = round(($data['countValid'] / $data['countTotalData']) * 100,2) ;
            $data['countPTrash'] = round(($data['countTrash'] / $data['countTotalData']) * 100,2) ;
            $data['countPTotal'] = round(($data['countTotalData'] / $data['countTotalData']) * 100,0) ;
        } else {
            $data['countPNew'] = 0;
            $data['countPValid'] = 0;
            $data['countPTrash'] = 0;
            $data['countPTotal'] = 0;
        }

        //select tallysheet
        $sql1 = "SELECT DISTINCT(tallysheet_id), master_tallysheet.* FROM data_monitoring LEFT JOIN master_tallysheet ON data_monitoring.tallysheet_id = master_tallysheet.id WHERE date_time >= '$dari 23:59:00' AND date_time <= '$sampai 23:59:00' AND flag_id = 2";
        $query1 = $this->db->query($sql1);
        if($query1->num_rows() > 0){
            $data['rTallysheet'] = $query1->result();
            $data['rTallysheet1'] = $query1->result();
        } else {
            $data['rTallysheet'] = array();
            $data['rTallysheet1'] = array();
        }

        

        $this->load->view('analisis/index_alldata', $data);
    }

    public function selecttallyall()
    {
        $tahun = date('Y');
        $dari = $this->input->get('d');
        $sampai = $this->input->get('s');
        $sql1 = "SELECT DISTINCT(tallysheet_id), master_tallysheet.* FROM data_monitoring LEFT JOIN master_tallysheet ON data_monitoring.tallysheet_id = master_tallysheet.id WHERE date_time >= '$dari 23:59:00' AND date_time <= '$sampai 23:59:00' AND flag_id = 2";
        $query1 = $this->db->query($sql1);
        if($query1->num_rows() > 0){
            $data['rTallysheet'] = $query1->result();
        } else {
            $data['rTallysheet'] = array();
        }
        die(json_encode($data['rTallysheet']));
    }

    public function selecttallyresort()
    {
        $tahun = date('Y');
        $id_resort = $this->input->get('r');
        $dari = $this->input->get('d');
        $sampai = $this->input->get('s');
        $sql1 = "SELECT DISTINCT(tallysheet_id), master_tallysheet.* FROM data_monitoring LEFT JOIN master_tallysheet ON data_monitoring.tallysheet_id = master_tallysheet.id WHERE date_time >= '$dari 23:59:00' AND date_time <= '$sampai 23:59:00' AND resort_id = $id_resort AND flag_id = 2";
        $query1 = $this->db->query($sql1);
        if($query1->num_rows() > 0){
            $data['rTallysheet'] = $query1->result();
        } else {
            $data['rTallysheet'] = array();
        }
        die(json_encode($data['rTallysheet']));
    }

    public function countperblnall() {
        $tahun = date("Y");
        $dari = $this->input->get('d');
        $sampai = $this->input->get('s');
        $sql  =  "SELECT MONTH(date_time) as bln, COUNT(MONTH(date_time)) as jml FROM data_monitoring WHERE date_time >= '$dari 23:59:00' AND date_time <= '$sampai 23:59:00' AND flag_id = 2 GROUP BY MONTH(date_time)";
        $qCount = $this->db->query($sql);
        if ($qCount->num_rows() > 0) {
            $data['cRekap'] = $qCount->result();
        } else {
           $data['cRekap'] = array();
        }
        die(json_encode($data['cRekap']));
    }

    public function countperblnresort() {
        $tahun = date("Y");
        $id_resort = $this->input->get('r');
        $dari = $this->input->get('d');
        $sampai = $this->input->get('s');
        $sql  =  "SELECT MONTH(date_time) as bln, COUNT(MONTH(date_time)) as jml FROM data_monitoring WHERE date_time >= '$dari 23:59:00' AND date_time <= '$sampai 23:59:00' AND resort_id = $id_resort  AND flag_id = 2  GROUP BY MONTH(date_time)";
        $qCount = $this->db->query($sql);
        if ($qCount->num_rows() > 0) {
            $data['cRekap'] = $qCount->result();
        } else {
           $data['cRekap'] = array();
        }
        die(json_encode($data['cRekap']));
    }

    public function hasilresorttallysheet()
    {
        $id = $this->input->get('t');
        $id_resort = $this->input->get('r');
        $dari = $this->input->get('d');
        $sampai = $this->input->get('s');
        $qTallysheet = $this->db->where('id',$id)->get("master_tallysheet");
        $dataTallysheet = $qTallysheet->row();
        $qResort = $this->db->where('id',$id_resort)->get("resort");
        $dataResort = $qResort->row();
        $data['judul'] = $dataTallysheet->name;
        $data['nama_resort'] = $dataResort->nama_resort;
        $data['t_id'] = $id;
        $data['r_id'] = $id_resort;
        $data['dari'] = $dari;
        $data['sampai'] = $sampai;
        $data['ref_column'] = $dataTallysheet->reference_column;
        if ($dataTallysheet->reference_column == "") {
            $countReff = 0;
        } else {
            $arr_reff_col = explode(';', $dataTallysheet->reference_column);
            $countReff = count($arr_reff_col);
        }
        $data['jml_ref_column'] = $countReff;
        $this->load->view('analisis/index_hasilresorttallysheet', $data);
    }

    


    

    

    

    public function peta() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());

        $tallysheet = $this->input->post('tallysheet');
        $resort = $this->input->post('kk');
        $dari = $this->input->post('dari');
        $sampai = $this->input->post('sampai');
        if (!isset($resort)){
            $resort = 0;
        }
        if (!isset($tallysheet)){
            $tallysheet = 0;
        }
        $data['tall_exist'] = $tallysheet;
        $data['res_exist'] = $resort;
        $config['map_height'] = '550px';
        $config['zoom'] = 11.25;
        $where = array();
        if ($tallysheet != '0') {
            $where['tallysheet_id'] = $tallysheet;
        }
        if ($resort != '0') {
            $where['resort_id'] = $resort;
            $file_kml = "KML_".$resort.".kml";
            $config['kmlLayerURL'] = base_url('assets/kmlresort/'.$file_kml);
        } else {
            $config['kmlLayerURL'] = base_url('assets/template/Resort_TNKpS.kml');
        }
        
        
        
        if (count($_POST) == 0) {
            $data_tallysheet = array();
        } else {
            $where['flag_id'] = 2;
            $where['date_time >='] = $dari." 23:59:00";
            $where['date_time <='] = $sampai." 23:59:00";
            $query = $this->db->select('DISTINCT (data_monitoring.id) as id_data_monitoring,data_monitoring.*,master_tallysheet.name,master_tallysheet.id as id_tallysheet,master_tallysheet.reference_column as reference_column_tallysheet,master_tallysheet.description as description_tallysheet,resort.id as id_resort,resort.nama_resort,flag.*')
                ->join('master_tallysheet', 'data_monitoring.tallysheet_id = master_tallysheet.id','left outer')
                ->join('resort', 'data_monitoring.resort_id = resort.id','left outer')
                ->join('flag', 'data_monitoring.flag_id = flag.id_flag','left outer')
                ->order_by('date_input', 'ASC')
                ->get_where("data_monitoring", $where);
                if($query->num_rows() > 0){
                $data_tallysheet = $query->result();
                $config['zoom'] = 'auto';
            } else {
                $data_tallysheet = array();
            }
        }
        
        $data['record'] = $data_tallysheet;
        foreach ($data_tallysheet as $row) {
            $marker = array();
            $marker['position'] = $row->lat.', '.$row->lon;
            $src_gambar = base_url('assets/filemonitoring/'.$row->file_foto);
            $gambar = "<center><img class=\"img-responsive\" src=\"".$src_gambar."\" style=\"padding-top:10px;max-width:200px\" alt=\"".$row->file_foto."\"></center>";
            $infowindow_content = '<h4>'.ucwords($row->name).'</h4>'.$gambar.'<br>Lokasi : '.$row->nama_resort.' ('.$row->lat.', '.$row->lon.')<br>';
            $hasil_kegiatan = "";
            if ($row->reference_column_tallysheet != "") {
                $ref_col = explode(";", $row->reference_column_tallysheet);
                $ref_val = explode(";", $row->reference_column);
                $x=0;
                foreach ($ref_col as $colref) {
                    $hasil_kegiatan .= ucwords(str_replace("_", " ", $colref))." : ";
                    if (!isset($ref_val[$x]) || $ref_val[$x] == '' || $ref_val[$x] == 0) {
                        $hasil_kegiatan .= '***Kosong/Nihil***';
                    } else {
                        $hasil_kegiatan .= $this->getdatareff($colref,$ref_val[$x]);
                    }
                    $hasil_kegiatan .= "<br>";
                    $x++;
                }
            }
                $des_col = explode(";", $row->description_tallysheet);
                $des_val = explode(";", $row->description);
                $y=0;
                foreach ($des_col as $coldes) {
                    $hasil_kegiatan .= ucwords(str_replace("_", " ", $coldes)).": ";
                    $hasil_kegiatan .= preg_replace("/[\\n\\r]+/", "", $des_val[$y])."<br>";
                    $y++;
                }
            $infowindow_content .= $hasil_kegiatan;
            $marker['infowindow_content'] = $infowindow_content;
            $marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_icon&chld=glyphish_pin|00EB39';
            $this->maps->add_marker($marker);
        }
        
        $this->maps->initialize($config);
        $data['map'] = $this->maps->create_map();
        $qRes = $this->db->order_by('id', 'ASC')->get("resort");
        $data['dataRes'] = $qRes->result();
        $qTallysheet = $this->db->order_by('id', 'ASC')->get("master_tallysheet");
        $data['dataTallysheet'] = $qTallysheet->result();
        $this->load->view('analisis/index_peta', $data);
    }

    public function detail() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
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

    public function getgrafikreference() {
         //chart per Bulan
        $tahun = date('Y');
        $tabel = $this->input->get('tabel');
        $indeks = $this->input->get('indeks');
        $tallysheet_id = $this->input->get('t_id');
        $dari = $this->input->get('d');
        $sampai = $this->input->get('s');
        $sql  =  "SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(reference_column, ';', ".$indeks."), ';', -1) as id_reff, ";
        $sql  .=  "COUNT(*) as jml, ".$tabel.".* ";
        $sql  .=  "FROM data_monitoring LEFT JOIN ".$tabel." ";
        $sql  .=  "ON SUBSTRING_INDEX(SUBSTRING_INDEX(reference_column, ';', ".$indeks."), ';', -1) = id_reference ";
        $sql  .=  "WHERE date_time >= '".$dari." 23:59:00' AND date_time <= '".$sampai." 23:59:00' AND tallysheet_id = ".$tallysheet_id." AND flag_id = 2 GROUP BY id_reff";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $data['cReffCol'] = $query->result();
        } else {
           $data['cReffCol'] = array();
        }
             
        die(json_encode($data['cReffCol']));
    }

    public function getdatapetugas() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $data_petugas = $this->input->get('data_petugas');
        $arr_petugas = explode(';', $data_petugas);
        $query = $this->db->select('id_user,nama_user')->order_by('id_user', 'ASC')
                ->where(array('role_id'=>2,'sub_role'=>3))->get("users");
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
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $value = $this->input->get('val');
        $tabel = $this->input->get('tabel');
        $query = $this->db->where(array('id_reference'=>$value))->get($tabel);
        $row = $query->row();
        if (!isset($value) || $value == '' || $value == 0) {
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

    public function getdatareff($tabel,$value) {
        $query = $this->db->where('id_reference',$value)->get($tabel);
        $row = $query->row();
        if (!isset($value) || $value == '' || $value == 0 || $query->num_rows() == 0) {
            $c_col = 1;
        } else {
            $c_col = $query->num_fields();
        }
        switch ($c_col) {
            case 1:
                $value_referensi = "***Kosong/Nihil***";
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
        //$value_referensi = $c_col.' - '.$tabel.' - '.$value;
        return $value_referensi;
    }

    public function countperpegawai() {
        $tahun = date("Y");
        $dari = $this->input->get('d');
        $sampai = $this->input->get('s');
        $petugas_id = $this->input->get('p');
        $qperpeg = $this->db->select('MONTH(date_time) as bln,data_monitoring.*,data_monitoring.id as id_data_monitoring,master_tallysheet.*')
                ->join('master_tallysheet', 'data_monitoring.tallysheet_id = master_tallysheet.id','left outer')
                ->where(array('date_time >=' => $dari." 00:00:01",'date_time <=' => $sampai." 23:59:59"))->get("data_monitoring");
        if ($qperpeg->num_rows() > 0) {
            $record = $qperpeg->result();
            $x = 0;
            $arr_bln = [];
            foreach ($record as $row) {
                $arr_petugas = explode(';', $row->petugas_id); 
                if (in_array($petugas_id, $arr_petugas)) { 
                    array_push($arr_bln, $row->bln);
                    $x++;
                }
            }
            $arr_bln_ok = array_count_values($arr_bln);
        } else {
           $arr_bln_ok = array();
        }
        $data['cRekap'] = $arr_bln_ok;
        die(json_encode($data['cRekap']));
    }


    public function countperbln() {
        $tahun = date("Y");
        $tallysheet_id = $this->input->get('id');
        $dari = $this->input->get('d');
        $sampai = $this->input->get('s');
        $sql  =  "SELECT MONTH(date_time) as bln, COUNT(MONTH(date_time)) as jml FROM data_monitoring WHERE date_time >= '$dari 23:59:00' AND date_time <= '$sampai 23:59:00' AND tallysheet_id = $tallysheet_id AND flag_id = 2 GROUP BY MONTH(date_time)";
        $qCount = $this->db->query($sql);
        if ($qCount->num_rows() > 0) {
            $data['cRekap'] = $qCount->result();
        } else {
           $data['cRekap'] = array();
        }
        die(json_encode($data['cRekap']));
    }

    public function countperthn() {
        $tahun = date("Y");
        $tallysheet_id = $this->input->get('id');
        $dari = $this->input->get('d');
        $sampai = $this->input->get('s');
        $sql  =  "SELECT YEAR(date_time) as thn, COUNT(YEAR(date_time)) as jml FROM data_monitoring WHERE date_time >= '$dari 23:59:00' AND date_time <= '$sampai 23:59:00' AND tallysheet_id = $tallysheet_id AND flag_id = 2 GROUP BY YEAR(date_time)";
        $qCount = $this->db->query($sql);
        if ($qCount->num_rows() > 0) {
            $data['cRekap'] = $qCount->result();
        } else {
           $data['cRekap'] = array();
        }
        die(json_encode($data['cRekap']));
    }

    public function countperresort() {
        $tahun = date("Y");
        $tallysheet_id = $this->input->get('id');
        $dari = $this->input->get('d');
        $sampai = $this->input->get('s');
        $sql  =  "SELECT resort_id as resort, COUNT(resort_id) as jml FROM data_monitoring WHERE date_time >= '$dari 23:59:00' AND date_time <= '$sampai 23:59:00' AND tallysheet_id = $tallysheet_id AND flag_id = 2 GROUP BY resort_id";
        $qCount = $this->db->query($sql);
        if ($qCount->num_rows() > 0) {
            $data['cRekap'] = $qCount->result();
        } else {
           $data['cRekap'] = array();
        }
        die(json_encode($data['cRekap']));
    }

    public function dataresort() {
        $sql  =  "SELECT * FROM resort WHERE id < 9 ORDER BY id ASC";
        $qCount = $this->db->query($sql);
        if ($qCount->num_rows() > 0) {
            $data['cRekap'] = $qCount->result();
        } else {
           $data['cRekap'] = array();
        }
        die(json_encode($data['cRekap']));
    }

    public function getgrafikreferenceresort() {
         //chart per Bulan
        $tahun = date('Y');
        $tabel = $this->input->get('tabel');
        $indeks = $this->input->get('indeks');
        $tallysheet_id = $this->input->get('t_id');
        $id_resort = $this->input->get('id_resort');
        $dari = $this->input->get('d');
        $sampai = $this->input->get('s');
        $sql  =  "SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(reference_column, ';', ".$indeks."), ';', -1) as id_reff, ";
        $sql  .=  "COUNT(*) as jml, ".$tabel.".* ";
        $sql  .=  "FROM data_monitoring LEFT JOIN ".$tabel." ";
        $sql  .=  "ON SUBSTRING_INDEX(SUBSTRING_INDEX(reference_column, ';', ".$indeks."), ';', -1) = id_reference ";
        $sql  .=  "WHERE date_time >= '".$dari." 23:59:00' AND date_time <= '".$sampai." 23:59:00' AND tallysheet_id = ".$tallysheet_id." AND resort_id = ".$id_resort." AND flag_id = 2 GROUP BY id_reff";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $data['cReffCol'] = $query->result();
        } else {
           $data['cReffCol'] = array();
        }
             
        die(json_encode($data['cReffCol']));
    }

    public function countperblntr() {
        $tahun = date("Y");
        $tallysheet_id = $this->input->get('id');
        $id_resort = $this->input->get('id_resort');
        $dari = $this->input->get('d');
        $sampai = $this->input->get('s');
        $sql  =  "SELECT MONTH(date_time) as bln, COUNT(MONTH(date_time)) as jml FROM data_monitoring WHERE date_time >= '$dari 23:59:00' AND date_time <= '$sampai 23:59:00' AND tallysheet_id = $tallysheet_id AND resort_id = $id_resort AND flag_id = 2 GROUP BY MONTH(date_time)";
        $qCount = $this->db->query($sql);
        if ($qCount->num_rows() > 0) {
            $data['cRekap'] = $qCount->result();
        } else {
           $data['cRekap'] = array();
        }
        die(json_encode($data['cRekap']));
    }

    public function countperthntr() {
        $tahun = date("Y");
        $tallysheet_id = $this->input->get('id');
        $id_resort = $this->input->get('id_resort');
        $dari = $this->input->get('d');
        $sampai = $this->input->get('s');
        $sql  =  "SELECT YEAR(date_time) as thn, COUNT(YEAR(date_time)) as jml FROM data_monitoring WHERE  date_time >= '$dari 23:59:00' AND date_time <= '$sampai 23:59:00' AND tallysheet_id = $tallysheet_id AND resort_id = $id_resort AND flag_id = 2 GROUP BY YEAR(date_time)";
        $qCount = $this->db->query($sql);
        if ($qCount->num_rows() > 0) {
            $data['cRekap'] = $qCount->result();
        } else {
           $data['cRekap'] = array();
        }
        die(json_encode($data['cRekap']));
    }

    


}
