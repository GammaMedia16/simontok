<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Pengeluaran extends CI_Controller{
    //put your code here
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('maps');
        $this->load->library('excel');
        date_default_timezone_set('Asia/Jakarta');
    }    
    
    public function pagu() {  
        $access = $this->session->sub_role;
        if (!$access) { $ok = true; } elseif ($access == 3 || $access == 4 || $access == 5 || $access == 7) { $ok = false; } else { $ok = true; }
        CheckThenRedirect($ok, base_url());

        $dateNow = date('Y-m-d');
        $tahun = $this->input->post('tahun');
        $filepagu = $this->input->post('filepagu');
        if (!isset($tahun)){
            $tahun = date("Y");
        }
        if (!isset($filepagu)){
            $qFile = $this->db->where('file_aktif', 1)->where('tahun_file', $tahun)->get('file_pagu');
            if($qFile->num_rows() > 0){
                $rFile = $qFile->row();
                $filepagu = $rFile->id_file;
                $flag_aktif = 1;
            } else {
                $filepagu = 0;
                $flag_aktif = 0;
            }  
        } else {
            $qFile1 = $this->db->where('id_file', $filepagu)->where('tahun_file', $tahun)->get('file_pagu');
            if($qFile1->num_rows() > 0){
                $rFile1 = $qFile1->row();
                $flag_aktif = $rFile1->file_aktif;
            } else {
                $filepagu = 0;
                $flag_aktif = 0;
            } 
        }
        
        $where = array();

        $where['thang'] = $tahun;
        $where['file_id'] = $filepagu;
        $query = $this->db->select('*')->order_by('id_pagu','ASC')->get_where("pagu_anggaran", $where);
        
        if($query->num_rows() > 0){
            $data['record'] = $query->result();
        } else {
            $data['record'] = array();
            $data['flag_exist'] = 0;
        }       
        $data['tahun_exist'] = $tahun;
        $data['file_exist'] = $filepagu;
        $data['flag_exist'] = $flag_aktif;
        $qFile = $this->db->where('tahun_file', $tahun)->order_by('id_file', 'DESC')->get('file_pagu');
        $data['dataFile'] = $qFile->result();
        $this->load->view('pengeluaran/index_pagu_anggaran.php',$data);
    }

    public function unduh() {
        $access = $this->session->sub_role;
        if (!$access) { $ok = true; } elseif ($access == 3 || $access == 4 || $access == 5 || $access == 7) { $ok = false; } else { $ok = true; }
        CheckThenRedirect($ok, base_url());
        $data['judul'] = "Unduh Data Pengeluaran";
        $this->load->view('ekspor/index_pengeluaran',$data);
    }

    public function import() {
        $access = $this->session->sub_role;
        if (!$access) { $ok = true; } elseif ($access == 4 || $access == 5) { $ok = false; } else { $ok = true; }
        CheckThenRedirect($ok, base_url());

        $data['judul'] = "Import";
        $data['tahun'] = $this->input->post('tahun');
        
        $record = array();
        if (empty($_FILES['fileimport']['name'])){
            $view = false;
            $data['highestColumn'] = 0;
            $data['highestRow'] = 0;
            $record = array();
            $dataColPagu = array();
            $nama_file = "";
        } else {
            $view = true;
            $inputFileName = $_FILES['fileimport']['tmp_name']; 
            $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
            $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
            $data['highestColumn'] = PHPExcel_Cell::columnIndexFromString($objWorksheet->getHighestColumn());
            $data['highestRow'] = $objWorksheet->getHighestRow();
            $record = $objWorksheet->toArray();

            $qColPagu = $this->db->get("master_pagu_anggaran");
            $dataColPagu = $qColPagu->result();
            //echo $recm;
            $config['upload_path']          = './assets/filepagu/';
            $config['allowed_types']        = 'xls';
            $config['overwrite']        = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            
            if($this->upload->do_upload('fileimport')){
                $nama_file = $this->upload->data('file_name');
            }
        }
        $data['nama_file'] = $nama_file;
        $data['dataColPagu'] = $dataColPagu;
        $data['record'] = $record;
        $data['view'] = $view;
        $this->load->view('pengeluaran/index_import.php',$data);   
    }

    public function importdata() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $tahun = date("Y");
        $data['tahun_exist'] = $tahun;
        $now = date("Y-m-d H:i:s");
        $jmldata = $this->input->post('jmldata');
        $cekEnd = 0;
        $qColPagu = $this->db->get("master_pagu_anggaran");
        $dataColPagu = $qColPagu->result();

        //insert file pagu
        $qfp = $this->db->get("file_pagu");
        if($qfp->num_rows() > 0){
            $this->db->update("file_pagu", array('file_aktif' => 0));
        }
       
        $data_file = array('tahun_file'=>$this->input->post('tahun'),
                            'nama_file'=>$this->input->post('namafile'),
                            'date_input_pagu'=>$now,
                            'user_input_pagu'=>$this->session->user_id,
                            'file_aktif'=>1);
        $this->db->set($data_file)->insert('file_pagu');
        $new_file_id = $this->db->insert_id();

        for ($i=1; $i <= $jmldata; $i++) {
            $data_pagu = array();
            foreach ($dataColPagu as $rColPagu) {
                $data_pagu[$rColPagu->kolom] = $this->input->post($rColPagu->kolom.$i);
                    
            }
            $data_pagu['file_id'] = $new_file_id;
            $this->db->set($data_pagu)->insert('pagu_anggaran');

            $cekEnd++;
        }
        if($cekEnd == $jmldata){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Pagu Anggaran berhasil disimpan.')));
            //return true;
        } else {
           die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Pagu Anggaran gagal disimpan.')));
            //return false;
        }
    }

    public function eksporrealisasipagu() {
        define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        $access = $this->session->sub_role;
        $dateNow = date('Y-m-d');
        $tahun = date('Y');
        $where = array();
        $where['file_pagu.file_aktif'] = 1;
        $where['pagu_anggaran.level'] = 7;

        $hari = $this->input->post('tanggal');
        if (!isset($hari)){
            $hari = 0;
            $tgl_exist = "";
        }
        if ($hari != 0) {
            $where['realisasi_pagu.tgl_transaksi_rpagu'] = $hari;
            $tglx = date_create($hari); 
            $tgl_hari = date_format($tglx, 'd F Y');
            $tgl_exist = " (Filter Tanggal: ".$tgl_hari.")";
        }
        if ($access != 4) {
            $where['realisasi_pagu.user_input_rpagu'] = $this->session->user_id;
        }
        $data['filter_tgl_exist'] = $tgl_exist;

        $query = $this->db->select('pagu_anggaran.*, realisasi_pagu.ket_rpagu, file_pagu.file_aktif, realisasi_pagu.jml_rpagu as jml_realisasi_pagu, (pagu_anggaran.pagu - COALESCE(SUM(realisasi_pagu.jml_rpagu),0)) as sisa_pagu, users.nama_user as nama_user',false)
                          ->join('pagu_anggaran', 'realisasi_pagu.kdindex = pagu_anggaran.kdindex','left outer')
                          ->join('file_pagu', 'pagu_anggaran.file_id = file_pagu.id_file')
                          ->join('users', 'realisasi_pagu.user_input_rpagu = users.id_user', 'left outer')
                          ->group_by('realisasi_pagu.id_rpagu')
                          ->order_by('realisasi_pagu.id_rpagu','ASC')
                          ->get_where("realisasi_pagu", $where);
        if($query->num_rows() > 0){
            $data = $query->result();
        } else {
            $data = array();
        } 
        $filename = 'assets/template/realisasi_pagu.xls';
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        
        $objPHPExcel = $objReader->load($filename);

        //GET DATA
        $baseRow = 6;
        $no = 1;
        $grand_total_pagu = 0;
        $grand_total_realisasi = 0;
        $grand_total_sisa = 0;
        $grand_total_presentase = 0;
        
        $objPHPExcel->getActiveSheet()->setCellValue('A4', 'TANGGAL');
        $objPHPExcel->getActiveSheet()->setCellValue('B4', $tgl_hari);
        $objPHPExcel->getActiveSheet()->getStyle('A4:B4')->getFont()->setBold(true);

        foreach($data as $r => $dataRow) {
            $row = $baseRow + $r;
            $target = $dataRow->pagu;
            $real = $dataRow->jml_realisasi_pagu;
            $persen = @($real/$target)*100;
            if (strstr($dataRow->ket, '] ')) {
              $keterangan = str_replace('] ', '', strstr($dataRow->ket, '] '));
            } else {
              $keterangan = $dataRow->ket;
            }
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $no)
                                          ->setCellValue('B'.$row, $dataRow->kdgiat)
                                          ->setCellValue('C'.$row, $dataRow->kdoutput)
                                          ->setCellValue('D'.$row, $dataRow->kdsoutput)
                                          ->setCellValue('E'.$row, $dataRow->kdkmpnen)
                                          ->setCellValue('F'.$row, $dataRow->kdskmpnen)
                                          ->setCellValue('G'.$row, $dataRow->jnsbel)
                                          ->setCellValue('H'.$row, $dataRow->kdbeban)
                                          ->setCellValue('I'.$row, $keterangan)
                                          ->setCellValue('J'.$row, $dataRow->ket_rpagu)
                                          ->setCellValue('K'.$row, $dataRow->pagu)
                                          ->setCellValue('L'.$row, $dataRow->jml_realisasi_pagu)
                                          ->setCellValue('M'.$row, $dataRow->sisa_pagu)
                                          ->setCellValue('N'.$row, $dataRow->nama_user);

        $grand_total_pagu += $dataRow->pagu;
        $grand_total_realisasi += $dataRow->jml_realisasi_pagu;
        $grand_total_sisa += $dataRow->sisa_pagu;
        $no++;
            
        }
        $last_row = $baseRow + count($data);
        $base_total = $last_row + 1;
        $border_style= array('borders' => array('allborders' => array('style' =>PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => '000000'),)));
        $objPHPExcel->getActiveSheet()->getStyle("A".$baseRow.":N".$last_row)->applyFromArray($border_style);

        $objPHPExcel->getActiveSheet()->setCellValue('A'.$base_total, 'GRAND TOTAL');
        $objPHPExcel->getActiveSheet()->setCellValue('K'.$base_total, $grand_total_pagu);
        $objPHPExcel->getActiveSheet()->setCellValue('L'.$base_total, $grand_total_realisasi);
        $objPHPExcel->getActiveSheet()->setCellValue('M'.$base_total, $grand_total_sisa);

        $objPHPExcel->getActiveSheet()->getStyle('A'.$base_total.':N'.$base_total)->getFont()->setBold( true );
        $objPHPExcel->getActiveSheet()->getStyle("K".$baseRow.":M".$last_row)->getNumberFormat()->setFormatCode('#,###');
        //$objPHPExcel->getActiveSheet()->removeRow($baseRow-1,1);
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="rekap_realisasi_pagu-'.date('dmY').'.xls"');
        
        // If you're serving to IE over SSL, then the following may be needed
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        //$objWriter->save(str_replace('.php', '.xls', __FILE__));
        $objWriter->save('php://output');
        exit;
    }

    public function eksporrealisasisah() {
        define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        $access = $this->session->sub_role;
        $dateNow = date('Y-m-d');
        $tahun = date('Y');
        $where = array();
        $where['file_pagu.file_aktif'] = 1;
        $where['pagu_anggaran.level'] = 7;

        $hari = $this->input->post('tanggal');
        if (!isset($hari)){
            $hari = 0;
            $tgl_exist = "";
        }
        if ($hari != 0) {
            $where['realisasi_pagu.tgl_transaksi_rpagu'] = $hari;
            $tglx = date_create($hari); 
            $tgl_hari = date_format($tglx, 'd F Y');
            $tgl_exist = " (Filter Tanggal: ".$tgl_hari.")";
        }
        if ($access != 4) {
            $where['realisasi_pagu.user_input_rpagu'] = $this->session->user_id;
        }
        $data['filter_tgl_exist'] = $tgl_exist;

        $query = $this->db->select('pagu_anggaran.*, realisasi_sah.*, realisasi_pagu.ket_rpagu, file_pagu.file_aktif, realisasi_pagu.jml_rpagu as jml_realisasi_pagu, (pagu_anggaran.pagu - COALESCE(SUM(realisasi_pagu.jml_rpagu),0)) as sisa_pagu, users.nama_user as nama_user',false)
                          ->join('pagu_anggaran', 'realisasi_pagu.kdindex = pagu_anggaran.kdindex','left outer')
                          ->join('realisasi_sah', 'realisasi_pagu.id_rpagu = realisasi_sah.rpagu_id','left outer')
                          ->join('file_pagu', 'pagu_anggaran.file_id = file_pagu.id_file')
                          ->join('users', 'realisasi_sah.user_input_rsah = users.id_user', 'left outer')
                          ->group_by('realisasi_pagu.id_rpagu')
                          ->order_by('realisasi_pagu.id_rpagu','ASC')
                          ->get_where("realisasi_pagu", $where);
        if($query->num_rows() > 0){
            $data = $query->result();
        } else {
            $data = array();
        } 
        $filename = 'assets/template/realisasi_sah.xls';
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        
        $objPHPExcel = $objReader->load($filename);

        //GET DATA
        $baseRow = 6;
        $no = 1;
        $grand_total_pagu = 0;
        $grand_total_realisasi = 0;
        $grand_total_pending = 0;
        $grand_total_realisasi_sah = 0;
        $grand_total_sisa = 0;
        $grand_total_presentase = 0;
        
        $objPHPExcel->getActiveSheet()->setCellValue('A4', 'TANGGAL');
        $objPHPExcel->getActiveSheet()->setCellValue('B4', $tgl_hari);
        $objPHPExcel->getActiveSheet()->getStyle('A4:B4')->getFont()->setBold(true);

        foreach($data as $r => $dataRow) {
            $row = $baseRow + $r;
            $target = $dataRow->pagu;
            $real = $dataRow->jml_realisasi_pagu;
            $persen = @($real/$target)*100;
            if (strstr($dataRow->ket, '] ')) {
              $keterangan = str_replace('] ', '', strstr($dataRow->ket, '] '));
            } else {
              $keterangan = $dataRow->ket;
            }
            if ($dataRow->flag_aksi == 1) {
              $status = "Sudah";
            } else {
              $status = "Belum";
            }
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $no)
                                          ->setCellValue('B'.$row, $dataRow->kdgiat)
                                          ->setCellValue('C'.$row, $dataRow->kdoutput)
                                          ->setCellValue('D'.$row, $dataRow->kdsoutput)
                                          ->setCellValue('E'.$row, $dataRow->kdkmpnen)
                                          ->setCellValue('F'.$row, $dataRow->kdskmpnen)
                                          ->setCellValue('G'.$row, $dataRow->jnsbel)
                                          ->setCellValue('H'.$row, $dataRow->kdbeban)
                                          ->setCellValue('I'.$row, $keterangan)
                                          ->setCellValue('J'.$row, $dataRow->ket_rpagu)
                                          ->setCellValue('K'.$row, $dataRow->pagu)
                                          ->setCellValue('L'.$row, $dataRow->jml_realisasi_pagu)
                                          ->setCellValue('M'.$row, $status)
                                          ->setCellValue('N'.$row, $dataRow->pending_rsah)
                                          ->setCellValue('O'.$row, $dataRow->jml_rsah)
                                          ->setCellValue('P'.$row, $dataRow->nama_user);

        $grand_total_pagu += $dataRow->pagu;
        $grand_total_realisasi += $dataRow->jml_realisasi_pagu;
        $grand_total_realisasi_sah += $dataRow->jml_realisasi_pagu;
        $no++;
            
        }
        $last_row = $baseRow + count($data);
        $base_total = $last_row + 1;
        $border_style= array('borders' => array('allborders' => array('style' =>PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => '000000'),)));
        $objPHPExcel->getActiveSheet()->getStyle("A".$baseRow.":P".$last_row)->applyFromArray($border_style);

        $objPHPExcel->getActiveSheet()->setCellValue('A'.$base_total, 'GRAND TOTAL');
        $objPHPExcel->getActiveSheet()->setCellValue('K'.$base_total, $grand_total_pagu);
        $objPHPExcel->getActiveSheet()->setCellValue('L'.$base_total, $grand_total_realisasi);
        $objPHPExcel->getActiveSheet()->setCellValue('N'.$base_total, $grand_total_pending);
        $objPHPExcel->getActiveSheet()->setCellValue('O'.$base_total, $grand_total_realisasi_sah);

        $objPHPExcel->getActiveSheet()->getStyle('A'.$base_total.':O'.$base_total)->getFont()->setBold( true );
        $objPHPExcel->getActiveSheet()->getStyle("K".$baseRow.":O".$last_row)->getNumberFormat()->setFormatCode('#,###');
        //$objPHPExcel->getActiveSheet()->removeRow($baseRow-1,1);
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="rekap_realisasi_sah-'.date('dmY').'.xls"');
        
        // If you're serving to IE over SSL, then the following may be needed
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        //$objWriter->save(str_replace('.php', '.xls', __FILE__));
        $objWriter->save('php://output');
        exit;
    }

    public function realisasi() {  
        $access = $this->session->sub_role;
        if (!$access) { $ok = true; } elseif ($access == 3 || $access == 4 || $access == 5 || $access == 7) { $ok = false; } else { $ok = true; }
        CheckThenRedirect($ok, base_url());

        $dateNow = date('Y-m-d');
        $tahun = date('Y');
        $where = array();
        $where['file_pagu.file_aktif'] = 1;
        $where['pagu_anggaran.level'] = 7;

        $hari = $this->input->post('filter_tgl');
        if (!isset($hari)){
            $hari = 0;
            $tgl_exist = "";
        }
        if ($hari != 0) {
            $where['realisasi_pagu.date_input_rpagu LIKE'] = $hari.'%';
            $where['realisasi_pagu.user_input_rpagu'] = $this->session->user_id;
            $tglx = date_create($hari); 
            $tgl_hari = date_format($tglx, 'd F Y');
            $tgl_exist = " (Filter Tanggal: ".$tgl_hari.")";
        }
        $data['filter_tgl_exist'] = $tgl_exist;

        //SELECT   FROM `pagu_anggaran` JOIN file_pagu ON pagu_anggaran.file_id = file_pagu.id_file LEFT OUTER JOIN realisasi_pagu ON pagu_anggaran.kdindex = realisasi_pagu.kdindex WHERE file_pagu.file_aktif = 1 GROUP BY pagu_anggaran.kdindex

        $query = $this->db->select('pagu_anggaran.*, file_pagu.file_aktif, COALESCE(SUM(realisasi_pagu.jml_rpagu),0) as jml_realisasi_pagu, (pagu_anggaran.pagu - COALESCE(SUM(realisasi_pagu.jml_rpagu),0)) as sisa_pagu',false)
                          ->join('realisasi_pagu', 'pagu_anggaran.kdindex = realisasi_pagu.kdindex','left outer')
                          ->join('file_pagu', 'pagu_anggaran.file_id = file_pagu.id_file')
                          ->group_by('pagu_anggaran.kdindex')
                          ->order_by('pagu_anggaran.id_pagu','ASC')
                          ->get_where("pagu_anggaran", $where);

        
        if($query->num_rows() > 0){
            $data['record'] = $query->result();
        } else {
            $data['record'] = array();
        }       
        /*$data['level1_exist'] = $level1;
        $data['level2_exist'] = $level2;
        $data['level3_exist'] = $level3;
        $data['level4_exist'] = $level4;
        $data['level5_exist'] = $level5;
        $data['level6_exist'] = $level6;*/
        $data['tahun_exist'] = $tahun;

        
        /*$data['dataL1'] = $this->getlevel(1);
        $data['dataL2'] = $this->getlevel(2);
        $data['dataL3'] = $this->getlevel(3);
        $data['dataL4'] = $this->getlevel(4);
        $data['dataL5'] = $this->getlevel(5);
        $data['dataL6'] = $this->getlevel(6);*/

        $this->load->view('pengeluaran/index_realisasi_pagu.php',$data);
    }

    public function realisasihilang() {  
        $access = $this->session->sub_role;
        if (!$access) { $ok = true; } elseif ($access == 3 || $access == 4 || $access == 5 || $access == 7) { $ok = false; } else { $ok = true; }
        CheckThenRedirect($ok, base_url());

        $dateNow = date('Y-m-d');
        $tahun = date('Y');
        
        //SELECT   FROM `pagu_anggaran` JOIN file_pagu ON pagu_anggaran.file_id = file_pagu.id_file LEFT OUTER JOIN realisasi_pagu ON pagu_anggaran.kdindex = realisasi_pagu.kdindex WHERE file_pagu.file_aktif = 1 GROUP BY pagu_anggaran.kdindex

        $query = $this->db->select('pagu_anggaran.*, COALESCE(SUM(realisasi_pagu.jml_rpagu),0) as jml_realisasi_pagu',false)
                          ->join('realisasi_pagu', 'pagu_anggaran.kdindex = realisasi_pagu.kdindex','left outer')
                          ->where('pagu_anggaran.level',7)
                          ->where('realisasi_pagu.kdindex',NULL, false)
                          ->group_by('pagu_anggaran.kdindex')
                          ->order_by('pagu_anggaran.id_pagu','ASC')
                          ->get("pagu_anggaran");

        
        if($query->num_rows() > 0){
            $data['record'] = $query->result();
        } else {
            $data['record'] = array();
        }       
        /*$data['level1_exist'] = $level1;
        $data['level2_exist'] = $level2;
        $data['level3_exist'] = $level3;
        $data['level4_exist'] = $level4;
        $data['level5_exist'] = $level5;
        $data['level6_exist'] = $level6;*/
        $data['tahun_exist'] = $tahun;

        
        /*$data['dataL1'] = $this->getlevel(1);
        $data['dataL2'] = $this->getlevel(2);
        $data['dataL3'] = $this->getlevel(3);
        $data['dataL4'] = $this->getlevel(4);
        $data['dataL5'] = $this->getlevel(5);
        $data['dataL6'] = $this->getlevel(6);*/

        $this->load->view('pengeluaran/index_realisasi_pagu_hilang.php',$data);
    }
    
    public function addrealisasipagu($kdindex) {  
        $access = $this->session->sub_role;
        if (!$access) { $ok = true; } elseif ($access == 3 || $access == 4 || $access == 5 || $access == 7) { $ok = false; } else { $ok = true; }
        CheckThenRedirect($ok, base_url());

        $data['judul'] = "Input Data Realisasi Pagu";
        $dateNow = date('Y-m-d');
        $tahun = date('Y');
        $where = array();
        $where['realisasi_pagu.kdindex'] = $kdindex;
        $where['file_pagu.file_aktif'] = 1;
        //SELECT   FROM `pagu_anggaran` JOIN file_pagu ON pagu_anggaran.file_id = file_pagu.id_file LEFT OUTER JOIN realisasi_pagu ON pagu_anggaran.kdindex = realisasi_pagu.kdindex WHERE file_pagu.file_aktif = 1 GROUP BY pagu_anggaran.kdindex

        $qPagu = $this->db->select('pagu_anggaran.*, file_pagu.file_aktif')
                          ->join('file_pagu', 'pagu_anggaran.file_id = file_pagu.id_file')
                          ->where("kdindex",$kdindex)
                          ->where("file_pagu.file_aktif",1)->get("pagu_anggaran");
        $qRealPagu = $this->db->select('realisasi_pagu.*,pagu_anggaran.file_id, file_pagu.file_aktif, users.nama_user')
                              ->join('pagu_anggaran', 'realisasi_pagu.kdindex = pagu_anggaran.kdindex')
                              ->join('file_pagu', 'pagu_anggaran.file_id = file_pagu.id_file')
                              ->join('users', 'realisasi_pagu.user_input_rpagu = users.id_user')
                              ->order_by('id_rpagu','DESC')
                              ->where("realisasi_pagu.kdindex",$kdindex)
                              ->where("file_pagu.file_aktif",1)->get("realisasi_pagu");
        
        if($qPagu->num_rows() > 0){
            $data['rowPagu'] = $qPagu->row();
        } else {
            $data['rowPagu'] = array();
        }  
        if($qRealPagu->num_rows() > 0){
            $data['recordRealPagu'] = $qRealPagu->result();
        } else {
            $data['recordRealPagu'] = array();
        }  
        $data['tahun_exist'] = $tahun;

        

        $this->load->view('pengeluaran/form_input_realisasi_pagu.php',$data);
    }

    public function createrealisasipagu() {
        $access = $this->session->sub_role;
        if (!$access) { $ok = true; } elseif ($access == 3 || $access == 5) { $ok = false; } else { $ok = true; }
        CheckThenRedirect($ok, base_url());

        $now = date('Y-m-d H:i:s');
        $dateNow = date('Y-m-d');
        $data = array('kdindex'=>$this->input->post('kdindex'),
                      'tgl_transaksi_rpagu'=>$this->input->post('tgl_transaksi_rpagu'),
                      'bulan'=>$this->input->post('bulan'),
                      'jml_rpagu'=>$this->input->post('jml_rpagu'),
                      'ket_rpagu'=>$this->input->post('ket_rpagu'),
                      'date_input_rpagu'=>$now,
                      'user_input_rpagu'=>$this->session->user_id);
        
        $insert_data = $this->db->set($data)->insert("realisasi_pagu");
        $new_id = $this->db->insert_id();
        if($insert_data){
            $dataSah = array('rpagu_id'=>$new_id,
                      'tgl_transaksi_rsah'=>$this->input->post('tgl_transaksi_rpagu'),
                      'pending_rsah'=>0,
                      'jml_rsah'=>$this->input->post('jml_rpagu'),
                      'date_input_rsah'=>$now,
                      'user_input_rsah'=>$this->session->user_id);
        
            $insert_sah = $this->db->set($dataSah)->insert("realisasi_sah");
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Realisasi Pagu Berhasil disimpan.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Realisasi Pagu Gagal disimpan.')));
            //return false;
        }
    }

    public function editrealisasipagu($id) {
        $access = $this->session->sub_role;
        if (!$access) { $ok = true; } elseif ($access == 3 || $access == 5) { $ok = false; } else { $ok = true; }
        CheckThenRedirect($ok, base_url());

        $data['judul'] = "Ubah Data Realisasi Pagu";

        $now = date('Y-m-d H:i:s');
        $dateNow = date('Y-m-d');
        $qRealPagu = $this->db->select('realisasi_pagu.*,pagu_anggaran.file_id, file_pagu.file_aktif, users.nama_user')
                              ->join('pagu_anggaran', 'realisasi_pagu.kdindex = pagu_anggaran.kdindex')
                              ->join('file_pagu', 'pagu_anggaran.file_id = file_pagu.id_file')
                              ->join('users', 'realisasi_pagu.user_input_rpagu = users.id_user')
                              ->order_by('id_rpagu','DESC')
                              ->where("realisasi_pagu.id_rpagu",$id)
                              ->where("file_pagu.file_aktif",1)->get("realisasi_pagu");
        
        if($qRealPagu->num_rows() == 1){
            $data['rowRealPagu'] = $qRealPagu->row();
        } else {
            $data['rowRealPagu'] = array();
        }  
        $this->load->view('pengeluaran/form_edit_realisasi_pagu.php',$data);
    }

    public function updaterealisasipagu() {
        $access = $this->session->sub_role;
        if (!$access) { $ok = true; } elseif ($access == 3 || $access == 5) { $ok = false; } else { $ok = true; }
        CheckThenRedirect($ok, base_url());

        $now = date('Y-m-d H:i:s');
        $dateNow = date('Y-m-d');
        $kdindex = $this->input->post('kdindex');
        $id_rpagu = $this->input->post('id_rpagu');
        $data = array('tgl_transaksi_rpagu'=>$this->input->post('tgl_transaksi_rpagu'),
                      'bulan'=>$this->input->post('bulan'),
                      'jml_rpagu'=>$this->input->post('jml_rpagu'),
                      'ket_rpagu'=>$this->input->post('ket_rpagu'),
                      'date_input_rpagu'=>$now,
                      'user_input_rpagu'=>$this->session->user_id);

        $update_data = $this->db->where("id_rpagu", $id_rpagu)->update("realisasi_pagu", $data);

        if($update_data){
            $dataSah = array('tgl_transaksi_rsah'=>$this->input->post('tgl_transaksi_rpagu'),
                      'pending_rsah'=>0,
                      'jml_rsah'=>$this->input->post('jml_rpagu'),
                      'date_input_rsah'=>$now,
                      'user_input_rsah'=>$this->session->user_id);
        
            $insert_sah = $this->db->where("rpagu_id", $id_rpagu)->update("realisasi_sah", $dataSah);;
            die(json_encode(array('kdindex' => $kdindex, 'status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Realisasi Pagu Berhasil disimpan.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Realisasi Pagu Gagal disimpan.')));
            //return false;
        }
    }

    public function hapusrealisasi()
    {
        $access = $this->session->sub_role;
        if (!$access) { $ok = true; } elseif ($access == 3 || $access == 5) { $ok = false; } else { $ok = true; }
        CheckThenRedirect($ok, base_url());

        $id_rpagu = $this->input->post('idrpagu');

        $delete1 = $this->db->where("id_rpagu", $id_rpagu)->delete('realisasi_pagu');
        $delete2 = $this->db->where("rpagu_id", $id_rpagu)->delete('realisasi_sah');
        
        if($delete2){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Realisasi berhasil dihapus.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Realisasi gagal dihapus.')));
            //return false;
        }
    }

    public function pengesahan() {  
        $access = $this->session->sub_role;
        if (!$access) { $ok = true; } elseif ($access == 3 || $access == 4 || $access == 5 || $access == 7) { $ok = false; } else { $ok = true; }
        CheckThenRedirect($ok, base_url());

        $dateNow = date('Y-m-d');
        $tahun = date('Y');
        $where = array();
        $where['file_pagu.file_aktif'] = 1;
        //SELECT   FROM `pagu_anggaran` JOIN file_pagu ON pagu_anggaran.file_id = file_pagu.id_file LEFT OUTER JOIN realisasi_pagu ON pagu_anggaran.kdindex = realisasi_pagu.kdindex WHERE file_pagu.file_aktif = 1 GROUP BY pagu_anggaran.kdindex
        $hari = $this->input->post('filter_tgl');
        if (!isset($hari)){
            $hari = 0;
            $tgl_exist = "";
        }
        if ($hari != 0) {
            $where['realisasi_sah.date_input_rsah LIKE'] = $hari.'%';
            $where['realisasi_sah.user_input_rsah'] = $this->session->user_id;
            $tglx = date_create($hari); 
            $tgl_hari = date_format($tglx, 'd F Y');
            $tgl_exist = " (Filter Tanggal: ".$tgl_hari.")";
        }
        $data['filter_tgl_exist'] = $tgl_exist;

        $query = $this->db->select('pagu_anggaran.*, file_pagu.file_aktif, SUM(CASE WHEN realisasi_sah.flag_aksi = 1 THEN realisasi_sah.jml_rsah ELSE 0 END) as jml_realisasi_sah, (pagu_anggaran.pagu - SUM(CASE WHEN realisasi_sah.flag_aksi = 1 THEN realisasi_sah.jml_rsah ELSE 0 END)) as sisa_sah')
                          ->join('realisasi_pagu', 'pagu_anggaran.kdindex = realisasi_pagu.kdindex','left outer')
                          ->join('realisasi_sah', 'realisasi_pagu.id_rpagu = realisasi_sah.rpagu_id','left outer')
                          ->join('file_pagu', 'pagu_anggaran.file_id = file_pagu.id_file')
                          ->group_by('pagu_anggaran.kdindex')
                          ->order_by('pagu_anggaran.id_pagu','ASC')
                          ->get_where("pagu_anggaran", $where);
        
        if($query->num_rows() > 0){
            $data['record'] = $query->result();
        } else {
            $data['record'] = array();
        }       
        /*$data['level1_exist'] = $level1;
        $data['level2_exist'] = $level2;
        $data['level3_exist'] = $level3;
        $data['level4_exist'] = $level4;
        $data['level5_exist'] = $level5;
        $data['level6_exist'] = $level6;*/
        $data['tahun_exist'] = $tahun;

        
        /*$data['dataL1'] = $this->getlevel(1);
        $data['dataL2'] = $this->getlevel(2);
        $data['dataL3'] = $this->getlevel(3);
        $data['dataL4'] = $this->getlevel(4);
        $data['dataL5'] = $this->getlevel(5);
        $data['dataL6'] = $this->getlevel(6);*/

        $this->load->view('pengeluaran/index_realisasi_sah.php',$data);
    }

    public function addrealisasisah($kdindex) {  
        $access = $this->session->sub_role;
        if (!$access) { $ok = true; } elseif ($access == 3 || $access == 4 || $access == 5 || $access == 7) { $ok = false; } else { $ok = true; }
        CheckThenRedirect($ok, base_url());

        $data['judul'] = "Input Data Realisasi Pagu";
        $dateNow = date('Y-m-d');
        $tahun = date('Y');
        $where = array();
        $where['realisasi_pagu.kdindex'] = $kdindex;
        $where['file_pagu.file_aktif'] = 1;
        //SELECT   FROM `pagu_anggaran` JOIN file_pagu ON pagu_anggaran.file_id = file_pagu.id_file LEFT OUTER JOIN realisasi_pagu ON pagu_anggaran.kdindex = realisasi_pagu.kdindex WHERE file_pagu.file_aktif = 1 GROUP BY pagu_anggaran.kdindex

        $qPagu = $this->db->select('pagu_anggaran.*, file_pagu.file_aktif')
                          ->join('file_pagu', 'pagu_anggaran.file_id = file_pagu.id_file')
                          ->where("kdindex",$kdindex)
                          ->where("file_pagu.file_aktif",1)->get("pagu_anggaran");
        $qRealPagu = $this->db->select('realisasi_pagu.*, realisasi_sah.*,pagu_anggaran.file_id, file_pagu.file_aktif, users.nama_user')
                              ->join('realisasi_sah', 'realisasi_pagu.id_rpagu = realisasi_sah.rpagu_id')
                              ->join('pagu_anggaran', 'realisasi_pagu.kdindex = pagu_anggaran.kdindex')
                              ->join('file_pagu', 'pagu_anggaran.file_id = file_pagu.id_file')
                              ->join('users', 'realisasi_sah.user_input_rsah = users.id_user')
                              ->order_by('id_rpagu','DESC')
                              ->where("realisasi_pagu.kdindex",$kdindex)
                              ->where("file_pagu.file_aktif",1)->get("realisasi_pagu");
        
        if($qPagu->num_rows() > 0){
            $data['rowPagu'] = $qPagu->row();
        } else {
            $data['rowPagu'] = array();
        }  
        if($qRealPagu->num_rows() > 0){
            $data['recordRealPagu'] = $qRealPagu->result();
        } else {
            $data['recordRealPagu'] = array();
        }  
        $data['tahun_exist'] = $tahun;

        

        $this->load->view('pengeluaran/form_input_realisasi_sah.php',$data);
    }

    public function sudahrealisasisah() {
        CheckThenRedirect($_SESSION['sub_role'] != 5, base_url());
        $now = date('Y-m-d H:i:s');
        $dateNow = date('Y-m-d');
        $id_rsah = $this->input->post('id_rsah');
        $pending_rsah = str_replace('.', '', $this->input->post('pending_rsah'));
        $jml_rsah = str_replace('.', '', $this->input->post('jml_rsah'));
        $data = array('flag_aksi'=>1,
                      'pending_rsah'=>$pending_rsah,
                      'jml_rsah'=>$jml_rsah,
                      'date_input_rsah'=>$now,
                      'user_input_rsah'=>$this->session->user_id);
        
       $update_data = $this->db->where("id_rsah", $id_rsah)->update("realisasi_sah", $data);
        if($update_data){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Realisasi Pengesahan Berhasil disimpan.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Realisasi Pengesahan Gagal disimpan.')));
            //return false;
        }
    }

    public function simpanrealisasisah() {
        CheckThenRedirect($_SESSION['sub_role'] != 5, base_url());
        $now = date('Y-m-d H:i:s');
        $dateNow = date('Y-m-d');
        $id_rsah = $this->input->post('id_rsah');
        $pending_rsah = str_replace('.', '', $this->input->post('pending_rsah'));
        $jml_rsah = str_replace('.', '', $this->input->post('jml_rsah'));
        $data = array('pending_rsah'=>$pending_rsah,
                      'jml_rsah'=>$jml_rsah,
                      'date_input_rsah'=>$now,
                      'user_input_rsah'=>$this->session->user_id);
        
       $update_data = $this->db->where("id_rsah", $id_rsah)->update("realisasi_sah", $data);
        if($update_data){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Realisasi Pengesahan Berhasil disimpan.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Realisasi Pengesahan Gagal disimpan.')));
            //return false;
        }
    }

    public function getlevel($level)
    {
        $qLevel = $this->db->join('file_pagu', 'pagu_anggaran.file_id = file_pagu.id_file')->where('level', $level)->where('file_aktif', 1)->order_by('id_pagu', 'ASC')->get('pagu_anggaran');

        if($qLevel->num_rows() > 0){
            $record = $qLevel->result();
        } else {
            $record = array();
        }  

        return $record;
    }
}
