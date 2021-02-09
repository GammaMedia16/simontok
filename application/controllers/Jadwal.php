<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Jadwal extends CI_Controller{
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
        set_time_limit(0);
        ini_set("memory_limit","1024M");
        ini_set('allow_url_fopen','1');
        ini_set('allow_url_include','1');
    }    
    

    public function index() {
        redirect('dashboard');
    }

    public function kelola()
    {
      $access = $this->session->sub_role;
      if (!$access) { $ok = true; } elseif ($access >= 3 && $access <= 6) { $ok = false; } else { $ok = true; }
      CheckThenRedirect($ok, base_url());
      $variable = get_variable_mclass();

      $data['judul'] = "Kelola Jadwal Ruang Kelas";
      $warna = "";
      if ($_SESSION['sub_role'] == 3) {
        $kode_progdi = $this->input->post('kodeprogdi');
        if (!isset($kode_progdi)){
            $kode_progdi = 0;
            $where_add = "AND `f_kodeprogdi` = '".$kode_progdi."'";
        }
        if ($kode_progdi != 0) {
            $where_add = "AND `f_kodeprogdi` = '".$kode_progdi."'";
        }
      }
      if ($_SESSION['sub_role'] == 4 || $_SESSION['sub_role'] == 5) {
        $qProgdi = $this->db->where('f_kodeprogdi',$this->session->user_kdprogdi)->where('f_status',1)->limit(1)->get("ms_progdi");
        $r_progdi = $qProgdi->row();
        $kode_progdi = $r_progdi->f_kodeprogdi;
        $where_add = "AND `f_kodeprogdi` = '".$kode_progdi."'";
        $warna = $r_progdi->f_progdiwarna;
        $data['r_progdi'] = $r_progdi;
      } 
      if ($_SESSION['sub_role'] == 6) {
        $kode_progdi = 0;
        $kode_dosen = $_SESSION['user_kddosen'];
        $where_add = "AND FIND_IN_SET('".$kode_dosen."' ,REPLACE(`f_kodedosen`, ';', ','))";
      } 

      $where['f_thajaran'] = $variable['thajaran'];
      $data['thajaran_view'] = $variable['thajaran_view'];

      
        $sql = "SELECT `f_kodeprogdi`,`f_kodematkul`,`f_namamatkul`,`f_namadosen`, MAX(CASE WHEN `pertemuan_ke` = 1 THEN CONCAT_WS(';',CONCAT_WS('|',`tgl_kuliah_fix`,`jam_kuliah_start`,`jam_kuliah_end`),`f_koderuang`,`f_namaruang`,`id_mkelas`,`nama_status_kelas`,`btn_status`,`jml_sks`) END) AS ke_1, MAX(CASE WHEN `pertemuan_ke` = 2 THEN CONCAT_WS(';',CONCAT_WS('|',`tgl_kuliah_fix`,`jam_kuliah_start`,`jam_kuliah_end`),`f_koderuang`,`f_namaruang`,`id_mkelas`,`nama_status_kelas`,`btn_status`,`jml_sks`) END) AS ke_2, MAX(CASE WHEN `pertemuan_ke` = 3 THEN CONCAT_WS(';',CONCAT_WS('|',`tgl_kuliah_fix`,`jam_kuliah_start`,`jam_kuliah_end`),`f_koderuang`,`f_namaruang`,`id_mkelas`,`nama_status_kelas`,`btn_status`,`jml_sks`) END) AS ke_3, MAX(CASE WHEN `pertemuan_ke` = 4 THEN CONCAT_WS(';',CONCAT_WS('|',`tgl_kuliah_fix`,`jam_kuliah_start`,`jam_kuliah_end`),`f_koderuang`,`f_namaruang`,`id_mkelas`,`nama_status_kelas`,`btn_status`,`jml_sks`) END) AS ke_4, MAX(CASE WHEN `pertemuan_ke` = 5 THEN CONCAT_WS(';',CONCAT_WS('|',`tgl_kuliah_fix`,`jam_kuliah_start`,`jam_kuliah_end`),`f_koderuang`,`f_namaruang`,`id_mkelas`,`nama_status_kelas`,`btn_status`,`jml_sks`) END) AS ke_5, MAX(CASE WHEN `pertemuan_ke` = 6 THEN CONCAT_WS(';',CONCAT_WS('|',`tgl_kuliah_fix`,`jam_kuliah_start`,`jam_kuliah_end`),`f_koderuang`,`f_namaruang`,`id_mkelas`,`nama_status_kelas`,`btn_status`,`jml_sks`) END) AS ke_6, MAX(CASE WHEN `pertemuan_ke` = 7 THEN CONCAT_WS(';',CONCAT_WS('|',`tgl_kuliah_fix`,`jam_kuliah_start`,`jam_kuliah_end`),`f_koderuang`,`f_namaruang`,`id_mkelas`,`nama_status_kelas`,`btn_status`,`jml_sks`) END) AS ke_7, MAX(CASE WHEN `pertemuan_ke` = 8 THEN CONCAT_WS(';',CONCAT_WS('|',`tgl_kuliah_fix`,`jam_kuliah_start`,`jam_kuliah_end`),`f_koderuang`,`f_namaruang`,`id_mkelas`,`nama_status_kelas`,`btn_status`,`jml_sks`) END) AS ke_8, MAX(CASE WHEN `pertemuan_ke` = 9 THEN CONCAT_WS(';',CONCAT_WS('|',`tgl_kuliah_fix`,`jam_kuliah_start`,`jam_kuliah_end`),`f_koderuang`,`f_namaruang`,`id_mkelas`,`nama_status_kelas`,`btn_status`,`jml_sks`) END) AS ke_9, MAX(CASE WHEN `pertemuan_ke` = 10 THEN CONCAT_WS(';',CONCAT_WS('|',`tgl_kuliah_fix`,`jam_kuliah_start`,`jam_kuliah_end`),`f_koderuang`,`f_namaruang`,`id_mkelas`,`nama_status_kelas`,`btn_status`,`jml_sks`) END) AS ke_10, MAX(CASE WHEN `pertemuan_ke` = 11 THEN CONCAT_WS(';',CONCAT_WS('|',`tgl_kuliah_fix`,`jam_kuliah_start`,`jam_kuliah_end`),`f_koderuang`,`f_namaruang`,`id_mkelas`,`nama_status_kelas`,`btn_status`,`jml_sks`) END) AS ke_11, MAX(CASE WHEN `pertemuan_ke` = 12 THEN CONCAT_WS(';',CONCAT_WS('|',`tgl_kuliah_fix`,`jam_kuliah_start`,`jam_kuliah_end`),`f_koderuang`,`f_namaruang`,`id_mkelas`,`nama_status_kelas`,`btn_status`,`jml_sks`) END) AS ke_12, MAX(CASE WHEN `pertemuan_ke` = 13 THEN CONCAT_WS(';',CONCAT_WS('|',`tgl_kuliah_fix`,`jam_kuliah_start`,`jam_kuliah_end`),`f_koderuang`,`f_namaruang`,`id_mkelas`,`nama_status_kelas`,`btn_status`,`jml_sks`) END) AS ke_13, MAX(CASE WHEN `pertemuan_ke` = 14 THEN CONCAT_WS(';',CONCAT_WS('|',`tgl_kuliah_fix`,`jam_kuliah_start`,`jam_kuliah_end`),`f_koderuang`,`f_namaruang`,`id_mkelas`,`nama_status_kelas`,`btn_status`,`jml_sks`) END) AS ke_14, MAX(CASE WHEN `pertemuan_ke` = 15 THEN CONCAT_WS(';',CONCAT_WS('|',`tgl_kuliah_fix`,`jam_kuliah_start`,`jam_kuliah_end`),`f_koderuang`,`f_namaruang`,`id_mkelas`,`nama_status_kelas`,`btn_status`,`jml_sks`) END) AS ke_15, MAX(CASE WHEN `pertemuan_ke` = 16 THEN CONCAT_WS(';',CONCAT_WS('|',`tgl_kuliah_fix`,`jam_kuliah_start`,`jam_kuliah_end`),`f_koderuang`,`f_namaruang`,`id_mkelas`,`nama_status_kelas`,`btn_status`,`jml_sks`) END) AS ke_16, MAX(CASE WHEN `pertemuan_ke` = 17 THEN CONCAT_WS(';',CONCAT_WS('|',`tgl_kuliah_fix`,`jam_kuliah_start`,`jam_kuliah_end`),`f_koderuang`,`f_namaruang`,`id_mkelas`,`nama_status_kelas`,`btn_status`,`jml_sks`) END) AS ke_17 FROM `management_kelas` JOIN `master_jam_kuliah` ON `management_kelas`.`jam_kuliah_id` = `master_jam_kuliah`.`id_jam_kuliah` JOIN `master_status_kelas` ON `management_kelas`.`status_kelas_id` = `master_status_kelas`.`id_status_kelas` WHERE `f_thajaran` = '".$variable['thajaran']."' ".$where_add." GROUP BY `f_kodematkul`;";
      
      $query = $this->db->query($sql);
      if($query->num_rows() > 0){
          $data['record'] = $query->result();
      } else {
          $data['record'] = array();
      }
      $data['warna'] = $warna;
      $data['prodi_exist'] = $kode_progdi;
      
      $data['start_kuliah'] = $variable['start_kuliah'];
      $qProgdi = $this->db->where('f_kodekampus',1)->where('f_status',1)->group_by('f_kodeprogdi')->order_by('ms_progdi.id', 'ASC')->get("ms_progdi");
      $data['dataProgdi'] = $qProgdi->result();
      $this->load->view('jadwal/kelola_jadwal.php',$data); 
    }

    public function checkin()
    {
      $access = $this->session->sub_role;
      if (!$access) { $ok = true; } elseif ($access == 5) { $ok = false; } else { $ok = true; }
      CheckThenRedirect($ok, base_url());
      $variable = get_variable_mclass();

      $data['judul'] = "Check In Ruangan";
      $kode_ruang = $this->input->post('kode_ruang');
      if (!isset($kode_ruang)){
          $kode_progdi = "";
      }
      if ($kode_ruang != "") {
        $query = $this->db->where('f_koderuangnew',$kode_ruang)->get("ms_ruang");
        if($query->num_rows() == 1){
            $row = $query->row();
            $id_ruang = $row->id;
            redirect('jadwal/ruang/'.$id_ruang);
        } else {
            $data['error'] = "Data Ruang tidak ditemukan";  
        }
      }
      $this->load->view('jadwal/form_checkin.php',$data); 
    }

    public function request()
    {
      $access = $this->session->sub_role;
      if (!$access) { $ok = true; } elseif ($access == 5) { $ok = false; } else { $ok = true; }
      CheckThenRedirect($ok, base_url());
      $variable = get_variable_mclass();

      $data['judul'] = "Data Request Perubahan Jadwal";
      $where = array();
      $where['komting_id'] = $this->session->user_id;
      $query = $this->db->order_by('date_request','ASC')->get_where('request_ganti_jadwal', $where);
      if($query->num_rows() > 0){
          $result = $query->result();
      } else {
          $result = array();
      }    
      $data['record'] = $result;
      $this->load->view('jadwal/data_request.php',$data);
    }

    public function submitcheckin()
    {
        $access = $this->session->sub_role;
        if (!$access) { $ok = true; } elseif ($access == 5) { $ok = false; } else { $ok = true; }
        CheckThenRedirect($ok, base_url());
        $variable = get_variable_mclass();
        $thajaran = $variable['thajaran'];
        $f_kodeprogdi = $this->input->post('f_kodeprogdi');
        $f_koderuang = $this->input->post('f_koderuang');
        $f_kodematkul = $this->input->post('f_kodematkul');
        $pertemuan_ke = $this->input->post('pertemuan_ke');

        $data = array('namadosen_real'=>$this->input->post('namadosen_real'),
                    'kddosen_real'=>$this->input->post('dosen_real'),
                    'jml_mhs_real'=>$this->input->post('jml_mhs'),
                    'status_kelas_id'=>3,
                    'tgl_mkelas_2'=>date("Y-m-d H:i:s"),
                    'timestamp'=>date("Y-m-d H:i:s"),
                    'komting_id'=>$this->session->user_id);
        $update_data = $this->db->where("f_thajaran", $thajaran)
                                ->where("f_kodeprogdi", $f_kodeprogdi)
                                ->where("f_koderuang", $f_koderuang)
                                ->where("f_kodematkul", $f_kodematkul)
                                ->where("pertemuan_ke", $pertemuan_ke)
                                ->update("management_kelas", $data);
        if($update_data){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Check In Ruangan Berhasil.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Check In Ruangan Gagal.')));
            //return false;
        }
    }

    public function ruang($id)
    {
      $access = $this->session->sub_role;
      if (!$access) { $ok = true; } elseif ($access == 5) { $ok = false; } else { $ok = true; }
      CheckThenRedirect($ok, base_url());
      $variable = get_variable_mclass();
      $now = date("Y-m-d H:i:s");

      $data['judul'] = "Form Check In Ruangan";
      //data progdi
      $kode_progdi = $this->session->user_kdprogdi;
      $qProgdi = $this->db->where('f_kodeprogdi',$kode_progdi)->limit(1)->get("ms_progdi");
      $r_progdi = $qProgdi->row();
      $progdi = $r_progdi->f_jenisprog.' - '.$r_progdi->f_kota;
      $data['progdi'] = $progdi;

      //cek ruangan
      $query = $this->db->where('id',$id)->get("ms_ruang");
      $row = $query->row();
      $id_ruang = $row->id;
      $kode_ruang = $row->f_koderuang;
      $nama_ruang = $row->f_namaruang;
      $data['ruang'] = $kode_ruang.'   |   '.$nama_ruang;
      
      //CEK PERTEMUAN KE
      $date_exist = strtotime("now");
      $start = strtotime($variable['start_kuliah']);
      $end   = $date_exist; 
      $diff  = $end - $start;
      $selisih_hari = floor($diff / (60 * 60 * 24));
      $hasil_bagi_minggu = $selisih_hari / 7;
      $pertemuan_ke = ceil($hasil_bagi_minggu);
      
      //cek id jam kuliah
      $hari_ini = date('l');
      $jam_skrg = date('H:i:s');
      $q_jam = $this->db->where('hari',$hari_ini)
                        ->where('jam_kuliah_start <=',$jam_skrg)
                        ->where('jam_kuliah_end >=',$jam_skrg)
                        ->limit(1)
                        ->get("master_jam_kuliah");
      $row_jam = $q_jam->row();
        if($q_jam->num_rows() == 1){
            $id_jam_kuliah = $row_jam->id_jam_kuliah;
        } else {
            $id_jam_kuliah = "";  
        }

      //cek sekarang jadwal apa
      if ($id_jam_kuliah != "") {
        $query = $this->db->join('master_status_kelas', 'management_kelas.status_kelas_id = master_status_kelas.id_status_kelas','left outer')
                          ->where('f_kodeprogdi',$kode_progdi)
                          ->where('f_koderuang',$kode_ruang)
                          ->where('pertemuan_ke',$pertemuan_ke)
                          ->where('jam_kuliah_id',$id_jam_kuliah)
                          ->limit(1)
                          ->get("management_kelas");
        if($query->num_rows() == 1){
            $row = $query->row();
        } else {
            $row = array();  
        }
      } else {
        $row = array();
      }
        
      $data['result'] = $row;

      $this->load->view('jadwal/form_checkin_ruangan.php',$data); 
    }

    public function formganti($id)
    {
      $access = $this->session->sub_role;
      if (!$access) { $ok = true; } elseif ($access == 5) { $ok = false; } else { $ok = true; }
      CheckThenRedirect($ok, base_url());
      $variable = get_variable_mclass();
      $now = date("Y-m-d H:i:s");

      $data['judul'] = "Form Request Perubahan Jadwal";
      //data progdi
      $kode_progdi = $this->session->user_kdprogdi;
      $qProgdi = $this->db->where('f_kodeprogdi',$kode_progdi)->limit(1)->get("ms_progdi");
      $r_progdi = $qProgdi->row();
      $progdi = $r_progdi->f_jenisprog.' - '.$r_progdi->f_kota;
      $data['progdi'] = $progdi;

      //get data jadwal
      $query = $this->db->join('master_status_kelas', 'management_kelas.status_kelas_id = master_status_kelas.id_status_kelas','left outer')
                        ->join('master_jam_kuliah', 'management_kelas.jam_kuliah_id = master_jam_kuliah.id_jam_kuliah','left outer')
                        ->where('status_kelas_id <',3)
                        ->where('id_mkelas',$id)
                        ->get("management_kelas");
      $row = $query->row();
      
      $query1 = $this->db->join('master_status_kelas', 'management_kelas.status_kelas_id = master_status_kelas.id_status_kelas','left outer')
                        ->join('master_jam_kuliah', 'management_kelas.jam_kuliah_id = master_jam_kuliah.id_jam_kuliah','left outer')
                        ->where('f_koderuang',$row->f_koderuang)
                        ->where('f_kodematkul',$row->f_kodematkul)
                        ->where('tgl_kuliah_fix',$row->tgl_kuliah_fix)
                        ->order_by('id_mkelas','ASC')
                        ->get("management_kelas");
      $row1 = $query1->result();
        
      $data['result'] = $row;
      $data['result1'] = $row1;

      $q_ruang = $this->db->select('ms_ruang.*')->where('ms_ruang.f_kodekampus', '1')->where('ms_ruang.f_jeniskelas', 1)->where('f_koderuangnew !=', "")->get("ms_ruang");
      $data['dataRuang'] = $q_ruang->result();

      $this->load->view('jadwal/form_ganti_jadwal.php',$data); 
    }

    public function submitrequestgantijadwal()
    {
      $access = $this->session->sub_role;
        if (!$access) { $ok = true; } elseif ($access == 5) { $ok = false; } else { $ok = true; }
        CheckThenRedirect($ok, base_url());
        $variable = get_variable_mclass();
        $thajaran = $variable['thajaran'];
        
        $data = array('kode_matkul'=>$this->input->post('f_kodematkul'),
                    'tgl_kuliah_semula'=>$this->input->post('tgl_kuliah_fix'),
                    'tgl_kuliah_menjadi'=>$this->input->post('tgl_request'),
                    'kode_ruang_semula'=>$this->input->post('f_koderuang'),
                    'kode_ruang_menjadi'=>$this->input->post('req_ruang'),
                    'jam_kuliah_semula'=>$this->input->post('jam_semula'),
                    'jam_kuliah_menjadi'=>$this->input->post('jam_kuliah_id_request'),
                    'alasan'=>$this->input->post('alasan'),
                    'komting_id'=>$this->session->user_id,
                    'date_request'=>date("Y-m-d H:i:s"),
                    'status_request'=>1);
        $create_data = $this->db->set($data)->insert('request_ganti_jadwal');
        if($create_data){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Request Perubahan Jadwal Kuliah Berhasil dikirim.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Request Perubahan Jadwal Kuliah Gagal dikirim.')));
            //return false;
        }
    }

    public function getdatajamkosong() {
        $tgl = $this->input->get('tgl');
        $jml_sks = $this->input->get('jml_sks');
        $koderuang = $this->input->get('kdruang');
        $hari = date('l', strtotime($tgl));
        //cek jam kuliah yg kosong dg kode matkul dan ruangan tsb 
        $sql_jk = "SELECT t1.* FROM `master_jam_kuliah` AS t1 LEFT JOIN `management_kelas` AS mk1 ON mk1.jam_kuliah_id = t1.id_jam_kuliah AND mk1.`tgl_kuliah_fix` = '$tgl' AND mk1.`f_koderuang` = '$koderuang' WHERE mk1.jam_kuliah_id IS NULL AND t1.`hari` = '$hari' AND t1.`flag_istirahat` = 0 LIMIT $jml_sks";
        $q_jk = $this->db->query($sql_jk);
        //$result = $q_jk->result_array();
        if ($q_jk->num_rows() == $jml_sks) {
          $result = $q_jk->result();
        } else {
          $result = array();
        }
        die(json_encode($result));
    }

    public function pengaturan($error=null) {
        $access = $this->session->sub_role;
        if (!$access) { $ok = true; } elseif ($access == 3 || $access == 4) { $ok = false; } else { $ok = true; }
        CheckThenRedirect($ok, base_url());

        $data['judul'] = "Form Input Jadwal Ruang Kelas";
        $where = array();
        if ($_SESSION['sub_role'] == 4) {
          $where['kode_progdi'] = $_SESSION['user_kdprogdi'];
          
        } 
        $where['ms_progdi.f_status'] = 1;
        $query = $this->db->select('master_mkelas.*, ms_progdi.f_jenisprog, ms_progdi.f_kota, UI.nama_user')->join('ms_progdi', 'master_mkelas.kode_progdi = ms_progdi.f_kodeprogdi','left outer')->join('users as UI', 'master_mkelas.user_pembuat = UI.id_user','left outer')->order_by('waktu_dibuat', 'DESC')->get_where("master_mkelas", $where);
        if($query->num_rows() > 0){
            $data['record'] = $query->result();
        } else {
            $data['record'] = array();
        }
        $qProgdi = $this->db->where('f_kodekampus',1)->where('f_status',1)->group_by('f_kodeprogdi')->order_by('ms_progdi.id', 'ASC')->get("ms_progdi");
        $data['dataProgdi'] = $qProgdi->result();
        $data['error'] = $error;
        $this->load->view('jadwal/pengaturan.php',$data);   
    }

    public function getdatamakul() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $kodeprogdi = $this->input->get('kodeprogdi');
        $tahun_ajaran = $this->input->get('tahun_ajaran');
        $semester = $this->input->get('semester');
        if ($semester == 'Ganjil') {
          $smstr = 1;
        } else {
          $smstr = 2;
        }
        $thaj= $tahun_ajaran.'-'.$smstr;
        $sql_matkul = "SELECT a.f_kodematkul, b.f_namamatkul FROM tr_jadwalmatakuliah as a LEFT JOIN ms_matakuliah AS b ON b.f_kodematkul = a.f_kodematkul WHERE a.f_thajaran = '$thaj' AND a.f_kodeprogdi = '$kodeprogdi' AND a.f_jeniskelas = 1 GROUP BY a.f_kodematkul";
        $q_matkul = $this->db->query($sql_matkul);
        $result = $q_matkul->result();
        $main = array();
        $list = array('f_kodematkul' => 'id', 'f_namamatkul' => 'text');
        foreach ($result as $index => $item){ 
            foreach ($item as $key => $value) {
                $main[$index][$list[$key]] = $value; 
            }
        }
        die(json_encode($main));
    }

    public function execute() {
        $access = $this->session->sub_role;
        if (!$access) { $ok = true; } elseif ($access == 3 || $access == 4) { $ok = false; } else { $ok = true; }
        CheckThenRedirect($ok, base_url());


        $now = date("Y-m-d H:i:s");
        //Field Data Monitoring
        $tahun_ajaran = $this->input->post('tahun_ajaran');
        $semester = $this->input->post('semester');
        $kodeprogdi = $this->input->post('kodeprogdi');
        if ($semester == 'Ganjil') {
          $smstr = 1;
        } else {
          $smstr = 2;
        }
        $data_master = array('tahun_ajaran'=>$tahun_ajaran,
                                'kode_progdi'=>$kodeprogdi,
                                'semester'=>$semester,
                                'waktu_dibuat'=>$now,
                                'user_pembuat'=>$this->session->user_id);
        $qfp = $this->db->get("master_mkelas");
        if($qfp->num_rows() > 0){
            $this->db->where("tahun_ajaran", $tahun_ajaran)->where("semester", $semester)->where("kode_progdi", $kodeprogdi)->update("master_mkelas", array('status_master' => 0));
        }

        $create_data_master = $this->db->set($data_master)->insert('master_mkelas');
        $new_id_master = $this->db->insert_id();

        //EXECUTE JADWAL RUANG
        $thaj= $tahun_ajaran.'-'.$smstr;
        $sql_matkul = "SELECT * FROM tr_jadwalmatakuliah as a LEFT JOIN ms_matakuliah AS b ON b.f_kodematkul = a.f_kodematkul WHERE a.f_thajaran = '$thaj' AND a.f_kodeprogdi = '$kodeprogdi' AND a.f_jeniskelas = 1 GROUP BY a.f_kodematkul";
        $q_matkul = $this->db->query($sql_matkul);
        if ($q_matkul->num_rows() > 0) {
            $r_matkul = $q_matkul->result();
        } else {
            $r_matkul = array();
        }
        $c_matkul = count($r_matkul);
        //die(print_r([$c_matkul]));
        $cekEnd = 0;
        if ($c_matkul > 0) {
          foreach ($r_matkul as $row_matkul) {
            //get jml mahasiswa per matkul - jadwal
            $kd_jadwal = $row_matkul->f_kodejadwal;
            $kd_matkul = $row_matkul->f_kodematkul;
            $nama_matkul = $row_matkul->f_namamatkul;
            $kdfakultas = $row_matkul->f_kodefakultas;
            $kdjurusan = $row_matkul->f_kodejurusan;
            $kdprogdi = $row_matkul->f_kodeprogdi;
            $kdkurikulum = $row_matkul->f_kodekurikulum;
            $kdpaketkurikulum = $row_matkul->f_kodepaketkurikulum;
            //get data dosen
            $sql_dosen = "SELECT a.*,b.f_namadosen FROM tr_jadwaldosen AS a LEFT JOIN ms_datadosen AS b ON a.f_kodedosen = b.f_kodedosen WHERE a.f_kodejadwal = '$kd_jadwal' AND a.f_jeniskelas ='1' AND a.f_kodematkul ='$kd_matkul' AND f_thajaran = '$thaj'";
            $q_dosen = $this->db->query($sql_dosen);
            $r_dosen = $q_dosen->result();
            $jml_dosen = $q_dosen->num_rows();
            $kode_dosen = "";
            $nama_dosen = "";
            $a=0;
            foreach ($r_dosen as $val_dosen) {
                $x=$jml_dosen-1;
                $kode_dosen .= $val_dosen->f_kodedosen;
                $nama_dosen .= $val_dosen->f_namadosen;
                if ($a != $x) {
                    $kode_dosen .= ";";
                    $nama_dosen .= ";";
                }
                $a++;
            }


            $sql_jml_mhs = "SELECT a.*, b.*, c.f_kodematkul, c.f_namamatkul, c.f_sks_t,c.f_sks_p, c.f_sks_l, c.f_sks_d, c.f_sks_k FROM tr_jadwalmahasiswa AS a   LEFT JOIN tr_jadwalmatakuliah AS b ON b.f_kodejadwal = a.f_kodejadwal LEFT JOIN ms_matakuliah AS c ON c.f_kodematkul = b.f_kodematkul WHERE b.f_kodematkul = '$kd_matkul'  AND b.f_kodejadwal = '$kd_jadwal' AND a.f_thajaran = '$thaj' GROUP BY a.f_kodemahasiswa";
            $q_jml_mhs = $this->db->query($sql_jml_mhs);
            $jml_mhs = $q_jml_mhs->num_rows();

            for ($x=1; $x <= 17 ; $x++) { 
              $jml_sks = $row_matkul->f_sks_t;
              for ($i=1; $i <= $jml_sks; $i++) { 
                $data_mkelas = array('f_kodefakultas'=>$kdfakultas,
                            'f_kodejurusan'=>$kdjurusan,
                            'f_kodeprogdi'=>$kodeprogdi,
                            'f_kodekurikulum'=>$kdkurikulum,
                            'f_kodepaketkurikulum'=>$kdpaketkurikulum,
                            'f_kodejadwal'=>$kd_jadwal,
                            'f_kodematkul'=>$kd_matkul,
                            'f_namamatkul'=>$nama_matkul,
                            'f_kodedosen'=>$kode_dosen,
                            'f_namadosen'=>$nama_dosen,
                            'f_thajaran'=>$thaj,
                            'f_realkelas'=>$jml_mhs,
                            'jml_sks'=>$jml_sks,
                            'pertemuan_ke'=>$x,
                            'tgl_mkelas_1'=>$now,
                            'tgl_mkelas_2'=>$now,
                            'tgl_mkelas_3'=>$now,
                            'tgl_mkelas_4'=>$now,
                            'status_kelas_id'=>0,
                            'id_user'=>$this->session->user_id,
                            'timestamp'=>$now,
                            'master_mkelas_id'=>$new_id_master);
                $this->db->set($data_mkelas)->insert('management_kelas');
                /*if ($i == $jml_sks) {
                  break;
                }*/
              }
            }
              

            if(++$cekEnd === $c_matkul) {
              redirect('jadwal/pengaturan');
            }  
            
          }
        } else {
          $this->db->where("id_master_mkelas", $new_id_master)->delete('master_mkelas');
          $error = "Data jadwal kuliah pada Progdi tersebut tidak ada di SIMADU. Silahkan isi terlebih dahulu.";
          $this->pengaturan($error);
          //redirect('jadwal/pengaturan');
        }
    }

    public function aturruangan()
    {
      $access = $this->session->sub_role;
        if (!$access) { $ok = true; } elseif ($access == 3 || $access == 4) { $ok = false; } else { $ok = true; }
        CheckThenRedirect($ok, base_url());
      $now = date("Y-m-d H:i:s");
      $id_master_mkelas = $this->input->post('id_master_mkelas');
      
      //GET MASTER KELAS PROGDI
      $q_master_mkelas = $this->db->where('id_master_mkelas', $id_master_mkelas)->get("master_mkelas");
      $r_master_mkelas = $q_master_mkelas->row();
      $kode_progdi = $r_master_mkelas->kode_progdi;
      $tahun_ajaran = $r_master_mkelas->tahun_ajaran;
      $semester = $r_master_mkelas->semester;

      for ($x=1; $x <= 17 ; $x++) { 
        //GET MANEGEMENT KELAS PROGDI
        $q_mkelas = $this->db->where('master_mkelas_id', $id_master_mkelas)
            ->where('pertemuan_ke', $x)
            ->group_by('f_kodematkul')
            ->order_by('id_mkelas', 'ASC')
            ->get("management_kelas");
        $r_mkelas = $q_mkelas->result();
        $c_mkelas = count($r_mkelas);
        $cekEnd = 0;
        foreach ($r_mkelas as $row_mkelas) {
          $jml_mhs = $row_mkelas->f_realkelas;
          //GET KAMPUS
          /*$q_kampus = $this->db->where('f_kodeprogdi', $kode_progdi)->limit(1)->get("ms_ruang");
          $row_kampus = $q_kampus->row();
          $kodekampus = $row_kampus->f_kodekampus;*/
          $kodekampus = 1;

          //GET RUANG   
          //->where('f_kodeprogdi', $kode_progdi)
          $q_ruang = $this->db->where('f_kodekampus', $kodekampus)
              ->where('f_kapkuliah >=', $jml_mhs)
              ->where('f_kapkuliah <=', intval($jml_mhs+10))
              ->where('f_jeniskelas', 1)
              ->where('f_koderuangnew !=', "")
              ->order_by('f_kapkuliah', 'ASC')
              ->get("ms_ruang");
          $row_ruang = $q_ruang->result_array();
          $c_ruang = count($row_ruang);
          $random_ruang = rand(0, $c_ruang-1);

          $data_mkelas = array('f_koderuang'=>$row_ruang[$random_ruang]['f_koderuangnew'],
                            'f_namaruang'=>$row_ruang[$random_ruang]['f_namaruangnew'],
                            'f_kapruang'=>$row_ruang[$random_ruang]['f_kapkuliah'],
                            'timestamp'=>$now);
            $this->db->where('master_mkelas_id', $id_master_mkelas)
                    ->where('f_kodematkul', $row_mkelas->f_kodematkul)
                    ->where('pertemuan_ke', $row_mkelas->pertemuan_ke)
                    ->update("management_kelas", $data_mkelas);

          /*if ($jml_mhs <= $row_ruang[$random_ruang]['f_kapkuliah']) {
            
            //continue;
          } else if ($jml_mhs >= $row_ruang[$random_ruang]['f_kapkuliah']) {
            $data_mkelas = array('f_koderuang'=>$row_ruang[$random_ruang]['f_koderuangnew'],
                            'f_namaruang'=>$row_ruang[$random_ruang]['f_namaruangnew'],
                            'f_kapruang'=>$row_ruang[$random_ruang]['f_kapkuliah'],
                            'timestamp'=>$now);
            $this->db->where('master_mkelas_id', $id_master_mkelas)
                    ->where('f_kodematkul', $row_mkelas->f_kodematkul)
                    ->where('pertemuan_ke', $row_mkelas->pertemuan_ke)
                    ->where('f_koderuang', '')
                    ->update("management_kelas", $data_mkelas);
            //continue;
          }*/



          /*$i = 1;
          foreach ($r_ruang as $row_ruang) {
            $random_ruang = rand(1, $c_ruang);
            if ($i == $random_ruang){
              //$slsh_ruang = $row_ruang->f_kapkuliah - $jml_mhs;
              
              continue;
            } else {
              continue;
            }
               
            $i++;
          }*/
           
        }

        if($x == 17) {
          //redirect('jadwal/pengaturan');
          $data_master = array('status_master'=>2,
                            'waktu_dibuat'=>$now);
          $this->db->where('id_master_mkelas', $id_master_mkelas)
                    ->update("master_mkelas", $data_master);
          die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Pengaturan Ruangan - Progdi berhasil disimpan.')));
        } 
      }
    }

    public function aturjadwal()
    {
      $access = $this->session->sub_role;
        if (!$access) { $ok = true; } elseif ($access == 3 || $access == 4) { $ok = false; } else { $ok = true; }
        CheckThenRedirect($ok, base_url());
      $now = date("Y-m-d H:i:s");
      $id_master_mkelas = $this->input->post('id_master_mkelas');
      
      //while ($c_mkelas_real >= 0) {
      for ($x=1; $x <= 17 ; $x++) {  
        //cek manage kelas by kode makul
        $q_mkelas = $this->db->where('master_mkelas_id', $id_master_mkelas)->where('pertemuan_ke', $x)->group_by('f_kodematkul')->limit(0)->get("management_kelas");
        $r_mkelas = $q_mkelas->result();
        $c_mkelas = count($r_mkelas);
        $cekEnd = 0;

        $variable = get_variable_mclass();
        $start_kuliah = $variable['start_kuliah'];
          
        foreach ($r_mkelas as $row_mkelas) {
          $jml_mhs = $row_mkelas->f_realkelas;
          $jml_sks = $row_mkelas->jml_sks;
          $thajaran = $row_mkelas->f_thajaran;
          $pertemuan_ke = $row_mkelas->pertemuan_ke;
          $koderuang = $row_mkelas->f_koderuang;
          $kodematkul = $row_mkelas->f_kodematkul;

          //startrandom
          $random_jam = rand(0, 50);

          //cek jam kuliah yg kosong dg kode matkul dan ruangan tsb 
          $sql_jk = "SELECT t1.* FROM `master_jam_kuliah` AS t1 LEFT JOIN `management_kelas` AS mk1 ON mk1.jam_kuliah_id = t1.id_jam_kuliah AND mk1.`f_thajaran` = '$thajaran' AND mk1.`f_koderuang` = '$koderuang' AND mk1.`pertemuan_ke` = '$pertemuan_ke' WHERE mk1.jam_kuliah_id IS NULL AND t1.`id_jam_kuliah` > $random_jam AND t1.`flag_istirahat` = 0 LIMIT $jml_sks";
          $q_jk = $this->db->query($sql_jk);
          $r_jk = $q_jk->result_array();
          //loop update data 
          $q_d_mkelas = $this->db->where('master_mkelas_id', $id_master_mkelas)
                                 ->where('f_kodematkul', $kodematkul)
                                 ->where('pertemuan_ke', $x)
                                 ->get("management_kelas");
          $r_d_mkelas = $q_d_mkelas->result();
          $y=0;
          foreach ($r_d_mkelas as $row_d_mkelas) {
            $jam_kuliah_real = $r_jk[$y]['id_jam_kuliah'];
            $hari_real = $r_jk[$y]['hari'];
            //cek jam kuliah tgl brp
            $pkhr = 7 * ($x-1);
            $hr = intval(date('N', strtotime($hari_real)));
            $hari_plus = $pkhr + $hr;
            $start = strtotime($start_kuliah);
            $tgl_ok = date('Y-m-d',strtotime($start_kuliah." +".$hari_plus." day"));

            $data_mkelas = array('jam_kuliah_id'=>$jam_kuliah_real,'tgl_kuliah_fix'=>$tgl_ok,'status_kelas_id'=>1,'timestamp'=>$now);
            $this->db->where('id_mkelas', $row_d_mkelas->id_mkelas)
                     ->update("management_kelas", $data_mkelas);
            $y++;
          }

          
          /*if(++$cekEnd === $c_mkelas) {
            //redirect('jadwal/pengaturan');
            $data_master = array('status_master'=>3,
                              'waktu_dibuat'=>$now);
            $this->db->where('id_master_mkelas', $id_master_mkelas)
                      ->update("master_mkelas", $data_master);
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Pengaturan Jadwal Kuliah - Progdi berhasil disimpan.'.$cekEnd)));
          }*/

        }
        
        //$c_mkelas_real--;
        if($x == 17) {
          //redirect('jadwal/pengaturan');
          $data_master = array('status_master'=>3,
                            'waktu_dibuat'=>$now);
          $this->db->where('id_master_mkelas', $id_master_mkelas)
                    ->update("master_mkelas", $data_master);
          die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Pengaturan Jadwal Kuliah - Progdi berhasil disimpan.')));
        }
      }   
          
      //} 
      

    }

    public function create() {
        CheckThenRedirect($_SESSION['sub_role'] != 5, base_url());
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
        
        $data_monitoring = $data_monitoring + array('petugas_id'=>$petugas_id,'user_input'=>$this->session->user_id,'date_created'=>$now,'flag_id'=>1);


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

    public function keluar()
    {
      die();
    }



    

}
