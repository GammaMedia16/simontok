<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Penerimaan extends CI_Controller{
    //put your code here
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('maps');
        $this->load->library('excel');
        date_default_timezone_set('Asia/Jakarta');
    }    
    
    public function target() {  
        $access = $this->session->sub_role;
        if (!$access) { $ok = true; } elseif ($access == 4 || $access == 6 || $access == 7) { $ok = false; } else { $ok = true; }
        CheckThenRedirect($ok, base_url());

        $tahun = $this->input->post('tahun');
        if (!isset($tahun)){
            $tahun = date("Y");
        }
        $data['tahun_exist'] = $tahun;
        $query = $this->db->select('*')->order_by('id_akun_penerimaan','ASC')->where('thn_target_penerimaan',$tahun)->get('target_penerimaan');
        if($query->num_rows() > 0){
            $data['record'] = $query->result();
        } else {
            $data['record'] = array();
        }       
        $this->load->view('penerimaan/index_target_penerimaan.php',$data);
    }

    public function addtarget() {  
        CheckThenRedirect($_SESSION['sub_role'] != 6, base_url());
        $data['judul'] = "Input Data Target Penerimaan";
        $this->load->view('penerimaan/form_createtarget.php',$data);
    }

    public function createtarget() {
        CheckThenRedirect($_SESSION['sub_role'] != 6, base_url());
        $data = array('kode_akun_penerimaan'=>$this->input->post('kode_akun_penerimaan'),
                      'jenis_penerimaan'=>$this->input->post('jenis_penerimaan'),
                      'jml_target_penerimaan'=>$this->input->post('jml_target_penerimaan'),
                      'thn_target_penerimaan'=>$this->input->post('thn_target_penerimaan'),
                      'user_input_target'=>$this->session->user_id,
                      'date_input_target'=>date("Y-m-d H:i:s"));
        
        $insert_data = $this->db->set($data)->insert("target_penerimaan");

        if($insert_data){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Target Penerimaan berhasil dikirim.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Target Penerimaan gagal dikirim.')));
            //return false;
        }
    }

    public function edittarget($id) {
        CheckThenRedirect($_SESSION['sub_role'] != 6, base_url());
        $data['judul'] = "Ubah Data Target Penerimaan";

        $query = $this->db->where('id_akun_penerimaan',$id)->get("target_penerimaan");
        
        if($query->num_rows() == 1){
            $data['row'] = $query->row();
        } else {
            $data['row'] = array();
        }  
        $this->load->view('penerimaan/form_edittarget.php',$data);
    }

    public function updatetarget() {
        CheckThenRedirect($_SESSION['sub_role'] != 6, base_url());
        $id_akun_penerimaan = $this->input->post('id_akun_penerimaan');;
        $data = array('kode_akun_penerimaan'=>$this->input->post('kode_akun_penerimaan'),
                      'jenis_penerimaan'=>$this->input->post('jenis_penerimaan'),
                      'jml_target_penerimaan'=>$this->input->post('jml_target_penerimaan'),
                      'thn_target_penerimaan'=>$this->input->post('thn_target_penerimaan'),
                      'user_input_target'=>$this->session->user_id,
                      'date_input_target'=>date("Y-m-d H:i:s"));
       
        $update_data = $this->db->where("id_akun_penerimaan", $id_akun_penerimaan)->update("target_penerimaan", $data);

        if($update_data){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Target Penerimaan Berhasil disimpan.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Target Penerimaan Gagal disimpan.')));
            //return false;
        }
    }

    public function realisasi() {  
        $access = $this->session->sub_role;
        if (!$access) { $ok = true; } elseif ($access == 4 || $access == 6 || $access == 7) { $ok = false; } else { $ok = true; }
        CheckThenRedirect($ok, base_url());

        $tahun = $this->input->post('tahun');
        if (!isset($tahun)){
            $tahun = date("Y");
        }
        $data['tahun_exist'] = $tahun;
        // joint tabel target_penerimaan dan realisasi_penerimaan
        $where = array();
        $where['target_penerimaan.thn_target_penerimaan'] = $tahun;
        $query = $this->db->select('target_penerimaan.*, COALESCE(SUM(realisasi_penerimaan.jml_rterima),0) as jml_realisasi_penerimaan, COALESCE(SUM(realisasi_penerimaan.jml_pengembalian),0) as jml_pengembalian_realisasi_penerimaan, COALESCE(SUM(realisasi_penerimaan.jml_netto),0) as jml_netto_realisasi_penerimaan',false)
                          ->join('realisasi_penerimaan', 'target_penerimaan.kode_akun_penerimaan = realisasi_penerimaan.kode_akun_penerimaan','left outer')
                          ->group_by('target_penerimaan.kode_akun_penerimaan')
                          ->order_by('target_penerimaan.id_akun_penerimaan','ASC')
                          ->get_where("target_penerimaan", $where);
        if($query->num_rows() > 0){
            $data['record'] = $query->result();
        } else {
            $data['record'] = array();
        }       
        $this->load->view('penerimaan/index_realisasi_penerimaan.php',$data);
    }

    public function addrealisasipenerimaan($kdakun) {  
        $access = $this->session->sub_role;
        if (!$access) { $ok = true; } elseif ($access == 4 || $access == 6 || $access == 7) { $ok = false; } else { $ok = true; }
        CheckThenRedirect($ok, base_url());
        $data['judul'] = "Input Data Realisasi Penerimaan";
        $dateNow = date('Y-m-d');
        $tahun = date('Y');

        $qTarget = $this->db->select('*')
                            ->where("thn_target_penerimaan",$tahun)
                            ->where("kode_akun_penerimaan",$kdakun)->get("target_penerimaan");
        
        $where = array();
        $where['target_penerimaan.thn_target_penerimaan'] = $tahun;
        $where['realisasi_penerimaan.kode_akun_penerimaan'] = $kdakun;
        $qReal = $this->db->select('realisasi_penerimaan.*,users.nama_user',false)
                          ->join('target_penerimaan', 'target_penerimaan.kode_akun_penerimaan = realisasi_penerimaan.kode_akun_penerimaan','left outer')
                          ->join('users', 'realisasi_penerimaan.user_input_rterima = users.id_user')
                          ->order_by('realisasi_penerimaan.id_rterima','ASC')
                          ->get_where("realisasi_penerimaan", $where);
        
        if($qTarget->num_rows() > 0){
            $data['rowTarget'] = $qTarget->row();
        } else {
            $data['rowTarget'] = array();
        }  
        if($qReal->num_rows() > 0){
            $data['recordReal'] = $qReal->result();
        } else {
            $data['recordReal'] = array();
        }  
        $data['tahun_exist'] = $tahun;

        

        $this->load->view('penerimaan/form_input_realisasi_penerimaan.php',$data);
    }

    public function createrealisasipenerimaan() {
        CheckThenRedirect($_SESSION['sub_role'] != 6, base_url());
        $now = date('Y-m-d H:i:s');
        $dateNow = date('Y-m-d');
        $data = array('kode_akun_penerimaan'=>$this->input->post('kode_akun_penerimaan'),
                      'bulan'=>$this->input->post('bulan'),
                      'keterangan'=>$this->input->post('keterangan'),
                      'jml_rterima'=>$this->input->post('jml_rterima'),
                      'jml_netto'=>$this->input->post('jml_rterima'),
                      'tgl_transaksi_rterima'=>$this->input->post('tgl_transaksi_rterima'),
                      'date_input_rterima'=>$now,
                      'user_input_rterima'=>$this->session->user_id);
        
        $insert_data = $this->db->set($data)->insert("realisasi_penerimaan");
        if($insert_data){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Realisasi Target Penerimaan Berhasil disimpan.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Realisasi Target Penerimaan Gagal disimpan.')));
            //return false;
        }
    }

    public function editrealisasipenerimaan($id) {
        CheckThenRedirect($_SESSION['sub_role'] != 6, base_url());
        $data['judul'] = "Ubah Data Realisasi Penerimaan";

        $now = date('Y-m-d H:i:s');
        $dateNow = date('Y-m-d');
        $qReal = $this->db->select('realisasi_penerimaan.*,target_penerimaan.*')
                              ->join('target_penerimaan', 'realisasi_penerimaan.kode_akun_penerimaan = target_penerimaan.kode_akun_penerimaan')
                              ->where("realisasi_penerimaan.id_rterima",$id)
                              ->get("realisasi_penerimaan");
        
        if($qReal->num_rows() == 1){
            $data['rowReal'] = $qReal->row();
        } else {
            $data['rowReal'] = array();
        }  
        $this->load->view('penerimaan/form_edit_realisasi_penerimaan.php',$data);
    }

    public function updaterealisasipenerimaan() {
        CheckThenRedirect($_SESSION['sub_role'] != 6, base_url());
        $now = date('Y-m-d H:i:s');
        $dateNow = date('Y-m-d');
        $kode_akun_penerimaan = $this->input->post('kode_akun_penerimaan');
        $id_rterima = $this->input->post('id_rterima');
        $jml_pengembalian = $this->input->post('jml_pengembalian');
        $jml_rterima = $this->input->post('jml_rterima');
        $jml_netto = $jml_rterima - $jml_pengembalian;
        $data = array('tgl_transaksi_rterima'=>$this->input->post('tgl_transaksi_rterima'),
                      'bulan'=>$this->input->post('bulan'),
                      'jml_rterima'=>$jml_rterima,
                      'jml_netto'=>$jml_netto,
                      'keterangan'=>$this->input->post('keterangan'),
                      'date_input_rterima'=>$now,
                      'user_input_rterima'=>$this->session->user_id);

        $update_data = $this->db->where("id_rterima", $id_rterima)->update("realisasi_penerimaan", $data);

        if($update_data){
            die(json_encode(array('kdakun' => $kode_akun_penerimaan, 'status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Realisasi Penerimaan Berhasil disimpan.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Realisasi Penerimaan Gagal disimpan.')));
            //return false;
        }
    }
    
    public function ubahpengembalian($id) {
        CheckThenRedirect($_SESSION['sub_role'] != 6, base_url());
        $data['judul'] = "Ubah Data Pengembalian Realisasi Penerimaan";

        $now = date('Y-m-d H:i:s');
        $dateNow = date('Y-m-d');
        $qReal = $this->db->select('realisasi_penerimaan.*,target_penerimaan.*')
                              ->join('target_penerimaan', 'realisasi_penerimaan.kode_akun_penerimaan = target_penerimaan.kode_akun_penerimaan')
                              ->where("realisasi_penerimaan.id_rterima",$id)
                              ->get("realisasi_penerimaan");
        
        if($qReal->num_rows() == 1){
            $data['rowReal'] = $qReal->row();
        } else {
            $data['rowReal'] = array();
        }  
        $this->load->view('penerimaan/form_edit_pengembalian.php',$data);
    }

    public function updatepengembalian() {
        CheckThenRedirect($_SESSION['sub_role'] != 6, base_url());
        $now = date('Y-m-d H:i:s');
        $dateNow = date('Y-m-d');
        $kode_akun_penerimaan = $this->input->post('kode_akun_penerimaan');
        $id_rterima = $this->input->post('id_rterima');
        $jml_pengembalian = $this->input->post('jml_pengembalian');
        $jml_rterima = $this->input->post('jml_rterima');
        $jml_netto = $jml_rterima - $jml_pengembalian;
        $data = array('tgl_transaksi_pengembalian'=>$this->input->post('tgl_transaksi_pengembalian'),
                      'jml_pengembalian'=>$jml_pengembalian,
                      'jml_netto'=>$jml_netto,
                      'date_input_pengembalian'=>$now,
                      'user_input_pengembalian'=>$this->session->user_id);

        $update_data = $this->db->where("id_rterima", $id_rterima)->update("realisasi_penerimaan", $data);

        if($update_data){
            die(json_encode(array('kdakun' => $kode_akun_penerimaan, 'status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Pengembalian Realisasi Penerimaan Berhasil disimpan.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Pengembalian Realisasi Penerimaan Gagal disimpan.')));
            //return false;
        }
    }

    public function unduh() {
        $data['judul'] = "Unduh Target Penerimaan";
        $this->load->view('ekspor/index_penerimaan',$data);
    }

    public function eksportarget() {
        define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        
        $tahun = date("Y");
        $query = $this->db->select('*')->order_by('id_akun_penerimaan','ASC')->where('thn_target_penerimaan',$tahun)->get('target_penerimaan');
        if($query->num_rows() > 0){
            $data = $query->result();
        } else {
            $data = array();
        } 
        $filename = 'assets/template/target_penerimaan.xls';
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        
        $objPHPExcel = $objReader->load($filename);

        //GET DATA
        $baseRow = 6;
        $no = 1;
        $grand_total_target = 0;
        foreach($data as $r => $dataRow) {
            $row = $baseRow + $r;
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $no)
                                          ->setCellValue('B'.$row, $dataRow->kode_akun_penerimaan)
                                          ->setCellValue('C'.$row, $dataRow->jenis_penerimaan)
                                          ->setCellValue('D'.$row, $dataRow->jml_target_penerimaan);

        $grand_total_target += $dataRow->jml_target_penerimaan;
        $no++;
            
        }
        $last_row = $baseRow + count($data);
        $base_total = $last_row + 1;
        $border_style= array('borders' => array('allborders' => array('style' =>PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => '000000'),)));
        $objPHPExcel->getActiveSheet()->getStyle("A".$baseRow.":D".$last_row)->applyFromArray($border_style);

        $objPHPExcel->getActiveSheet()->setCellValue('A'.$base_total, 'GRAND TOTAL');
        $objPHPExcel->getActiveSheet()->getStyle('A'.$base_total)->getFont()->setBold( true );
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$base_total, $grand_total_target);
        $objPHPExcel->getActiveSheet()->getStyle('D'.$base_total)->getFont()->setBold( true );
        $objPHPExcel->getActiveSheet()->getStyle("A".$baseRow.":D".$last_row)->getNumberFormat()->setFormatCode('#,###');
        //$objPHPExcel->getActiveSheet()->removeRow($baseRow-1,1);
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="rekap_target_penerimaan_'.date('dmY').'.xls"');
        
        // If you're serving to IE over SSL, then the following may be needed
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        //$objWriter->save(str_replace('.php', '.xls', __FILE__));
        $objWriter->save('php://output');
        exit;
    }

    public function eksporrealisasiakun() {
        define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        
        $tahun = date("Y");
        $bulan = $this->input->post('bulan');
        if (!isset($bulan)){
            $bulan = 0;
        }

        // joint tabel target_penerimaan dan realisasi_penerimaan
        $where = array();
        $where['target_penerimaan.thn_target_penerimaan'] = $tahun;
        if ($bulan != 0) {
            $where['realisasi_penerimaan.bulan <='] = $bulan;
        }
        $query = $this->db->select('target_penerimaan.*, COALESCE(SUM(realisasi_penerimaan.jml_rterima),0) as jml_realisasi_penerimaan, COALESCE(SUM(realisasi_penerimaan.jml_pengembalian),0) as jml_pengembalian_realisasi_penerimaan, COALESCE(SUM(realisasi_penerimaan.jml_netto),0) as jml_netto_realisasi_penerimaan',false)
                          ->join('realisasi_penerimaan', 'target_penerimaan.kode_akun_penerimaan = realisasi_penerimaan.kode_akun_penerimaan','left outer')
                          ->group_by('target_penerimaan.kode_akun_penerimaan')
                          ->order_by('target_penerimaan.id_akun_penerimaan','ASC')
                          ->get_where("target_penerimaan", $where);
        if($query->num_rows() > 0){
            $data = $query->result();
        } else {
            $data = array();
        } 
        $filename = 'assets/template/realisasi_penerimaan.xls';
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        
        $objPHPExcel = $objReader->load($filename);

        //GET DATA
        $baseRow = 6;
        $no = 1;
        $grand_total_target = 0;
        $grand_total_realisasi = 0;
        $grand_total_pengembalian = 0;
        $grand_total_netto = 0;
        $arr_bulan = array("SEMUA DATA", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        $objPHPExcel->getActiveSheet()->setCellValue('A4', 'BULAN');
        $objPHPExcel->getActiveSheet()->setCellValue('B4', $arr_bulan[$bulan]);
        $objPHPExcel->getActiveSheet()->getStyle('A4:B4')->getFont()->setBold(true);
        foreach($data as $r => $dataRow) {
            $row = $baseRow + $r;
            $target = $dataRow->jml_target_penerimaan;
            $real = $dataRow->jml_netto_realisasi_penerimaan;
            $persen = @($real/$target)*100;
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $no)
                                          ->setCellValue('B'.$row, $dataRow->kode_akun_penerimaan)
                                          ->setCellValue('C'.$row, $dataRow->jenis_penerimaan)
                                          ->setCellValue('D'.$row, $dataRow->jml_target_penerimaan)
                                          ->setCellValue('E'.$row, $dataRow->jml_realisasi_penerimaan)
                                          ->setCellValue('F'.$row, $dataRow->jml_pengembalian_realisasi_penerimaan)
                                          ->setCellValue('G'.$row, $dataRow->jml_netto_realisasi_penerimaan)
                                          ->setCellValue('H'.$row, number_format($persen, 2, ',', '.').'%');

        $grand_total_target += $dataRow->jml_target_penerimaan;
        $grand_total_realisasi += $dataRow->jml_realisasi_penerimaan;
        $grand_total_pengembalian += $dataRow->jml_pengembalian_realisasi_penerimaan;
        $grand_total_netto += $dataRow->jml_netto_realisasi_penerimaan;
        $no++;
            
        }
        $last_row = $baseRow + count($data);
        $base_total = $last_row + 1;
        $border_style= array('borders' => array('allborders' => array('style' =>PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => '000000'),)));
        $objPHPExcel->getActiveSheet()->getStyle("A".$baseRow.":H".$last_row)->applyFromArray($border_style);

        $objPHPExcel->getActiveSheet()->setCellValue('A'.$base_total, 'GRAND TOTAL');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$base_total, $grand_total_target);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$base_total, $grand_total_realisasi);
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$base_total, $grand_total_pengembalian);
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$base_total, $grand_total_netto);
        $persen_total = @($grand_total_netto/$grand_total_target)*100;
        $objPHPExcel->getActiveSheet()->setCellValue('H'.$base_total, number_format($persen_total, 2, ',', '.').'%');

        $objPHPExcel->getActiveSheet()->getStyle('A'.$base_total.':H'.$base_total)->getFont()->setBold( true );
        $objPHPExcel->getActiveSheet()->getStyle("A".$baseRow.":H".$last_row)->getNumberFormat()->setFormatCode('#,###');
        //$objPHPExcel->getActiveSheet()->removeRow($baseRow-1,1);
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="rekap_realisasi_penerimaan_per_akun-'.date('dmY').'.xls"');
        
        // If you're serving to IE over SSL, then the following may be needed
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        //$objWriter->save(str_replace('.php', '.xls', __FILE__));
        $objWriter->save('php://output');
        exit;
    }

    public function eksporrealisasidetail() {
        define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        
        $tahun = date("Y");
        $bulan = $this->input->post('bulan');
        if (!isset($bulan)){
            $bulan = 0;
        }

        // joint tabel target_penerimaan dan realisasi_penerimaan
        $where = array();

        if ($bulan != 0) {
            $where['realisasi_penerimaan.bulan <='] = $bulan;
        }
        $where['target_penerimaan.thn_target_penerimaan'] = $tahun;
        $query = $this->db->select('target_penerimaan.*,realisasi_penerimaan.*',false)
                          ->join('target_penerimaan', 'target_penerimaan.kode_akun_penerimaan = realisasi_penerimaan.kode_akun_penerimaan','left outer')
                          ->order_by('realisasi_penerimaan.id_rterima','ASC')
                          ->get_where("realisasi_penerimaan", $where);
        if($query->num_rows() > 0){
            $data = $query->result();
        } else {
            $data = array();
        } 
        $filename = 'assets/template/realisasi_penerimaan_perbulan.xls';
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        
        $objPHPExcel = $objReader->load($filename);

        //GET DATA
        $baseRow = 7;
        $no = 1;
        $grand_total_netto = 0;
        $arr_bulan = array("SEMUA DATA", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        $objPHPExcel->getActiveSheet()->setCellValue('B4', $arr_bulan[$bulan]);
        foreach($data as $r => $dataRow) {
            $row = $baseRow + $r;

            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $no)
                                          ->setCellValue('B'.$row, $dataRow->kode_akun_penerimaan)
                                          ->setCellValue('C'.$row, $dataRow->jenis_penerimaan)
                                          ->setCellValue('D'.$row, $dataRow->tgl_transaksi_rterima)
                                          ->setCellValue('E'.$row, $dataRow->keterangan)
                                          ->setCellValue('F'.$row, $dataRow->jml_netto);

        $grand_total_netto += $dataRow->jml_netto;
        $no++;
            
        }
        $last_row = $baseRow + count($data);
        $base_total = $last_row + 1;
        $border_style= array('borders' => array('allborders' => array('style' =>PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => '000000'),)));
        $objPHPExcel->getActiveSheet()->getStyle("A".$baseRow.":F".$last_row)->applyFromArray($border_style);

        $objPHPExcel->getActiveSheet()->setCellValue('A'.$base_total, 'GRAND TOTAL');
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$base_total, $grand_total_netto);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$base_total.':F'.$base_total)->getFont()->setBold( true );
        $objPHPExcel->getActiveSheet()->getStyle("A".$baseRow.":F".$last_row)->getNumberFormat()->setFormatCode('#,###');
        //$objPHPExcel->getActiveSheet()->removeRow($baseRow-1,1);
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="rekap_realisasi_penerimaan_per_bulan-'.date('dmY').'.xls"');
        
        // If you're serving to IE over SSL, then the following may be needed
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        //$objWriter->save(str_replace('.php', '.xls', __FILE__));
        $objWriter->save('php://output');
        exit;
    }
}
