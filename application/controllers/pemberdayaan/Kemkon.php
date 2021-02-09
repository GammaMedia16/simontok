<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kemkon extends CI_Controller{
    //put your code here
    public function __construct()
    {
        parent::__construct();
        $this->load->library('excel');
        $this->load->library('mpdf');
        $this->load->model('m_referensi','m_referensi');
        date_default_timezone_set('Asia/Jakarta');
    }    
    
    public function index() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        //cek file upload
        $directory = "./assets/fileupload/";
        //$directory = base_url("assets/fileupload");
        $filecount = count(glob($directory . "*.*"));
        $this->load->helper('file');
        //echo $filecount; 
        if ($filecount > 0) {
            delete_files('./assets/fileupload/');
            # code...
        }

        $fungsi_kk_id = $this->input->post('fungsi_kk_id');
        $prov_id = $this->input->post('prov_id');
        $tujuan_id = $this->input->post('tujuan_id');
        $aktivitas_pemanfaatan = $this->input->post('aktivitas_pemanfaatan');
        $satker_kode = $this->input->post('satker_kode');
        $tahun = $this->input->post('tahun');
        $kk_reg = $this->input->post('kk_reg');
        $data['judul'] = 'Data Kemitraan Konservasi ';
        if ($this->session->sub_role == 4 ) {
            $satker_kode = $this->session->satker_kode;
        }
        if (!isset($tahun)){
            $tahun = date('Y');
        }
        if (!isset($fungsi_kk_id)){
            $fungsi_kk_id = 0;
        }
        if (!isset($prov_id)){
            $prov_id = 0;
        }
        if (!isset($satker_kode)){
            $satker_kode = 0;
        }
        if (!isset($kk_reg)){
            $kk_reg = 0;
        }
        if (!isset($tujuan_id)){
            $tujuan_id = 0;
        }
        if (!isset($aktivitas_pemanfaatan)){
            $aktivitas_pemanfaatan = 0;
        }
        $where = array();
        if ($fungsi_kk_id != 0) {
            $where['fungsi_kk_id'] = $fungsi_kk_id;
        }
        if ($satker_kode != 0) {
            $where['kelompok.satker_kode'] = $satker_kode;
            $data['dataKK'] = $this->m_referensi->GetKKSatker($satker_kode);
        } else {
            $data['dataKK'] = $this->m_referensi->GetAllKK();
        }
        if ($prov_id != 0) {
            //$where['satker.prov_id'] = $prov_id;
            $where['FIND_IN_SET('.$prov_id.',kawasan.prov_id) !='] = '0';
        } 
        if ($tahun != '0') {
            $where['kemitraan_konservasi.tgl_pks >='] = $tahun.'-01-01';
            $where['kemitraan_konservasi.tgl_pks <='] = $tahun.'-12-31';
        }
        if ($tujuan_id != '0') {
            $where['kemitraan_konservasi.tujuan_id'] = $tujuan_id;
        }
        if ($aktivitas_pemanfaatan != '0') {
            $where['CONCAT(";", aktivitas_pemanfaatan, ";") like '] = '%'.$aktivitas_pemanfaatan.'%';
        }
        if ($kk_reg != '0') {
            $where['kelompok.kk_reg'] = $kk_reg;
        }
        $data['kk_exist'] = $kk_reg;
        $data['tahun_exist'] = $tahun;
        $data['fungsi_exist'] = $fungsi_kk_id;
        $data['prov_exist'] = $prov_id;
        $data['satker_exist'] = $satker_kode;
        $data['tujuan_exist'] = $tujuan_id;
        $data['aktivitas_pemanfaatan_exist'] = $aktivitas_pemanfaatan;
        $query = $this->db->select('id_kemitraan, no_pks, judul_pks, kelompok.satker_kode as satker_kode, kelompok_id, kelompok.desa_id as desa_id, kelompok.nama_kelompok as nama_kelompok, fungsi_kk.nama_fungsi, fungsi_kk.short_name, satker.nama_satker, UI.nama_user, kawasan.nama_kk, ref_tujuan.detail_1 as tujuan_kemitraan')
                ->join('kelompok', 'kemitraan_konservasi.kelompok_id = kelompok.id_kelompok','left outer')
                ->join('satker', 'kelompok.satker_kode = satker.kode_satker','left outer')
                ->join('kawasan', 'kelompok.kk_reg = kawasan.reg_kk','left outer')
                ->join('fungsi_kk', 'kawasan.fungsi_kk_id = fungsi_kk.id_fungsi_kk','left outer')
                ->join('ref_tujuan', 'kemitraan_konservasi.tujuan_id = ref_tujuan.id_reference','left outer')
                ->join('users as UI', 'kemitraan_konservasi.user_input = UI.id_user','left outer')
                ->group_by('id_kemitraan')
                ->order_by('id_kemitraan', 'DESC')
                ->get_where("kemitraan_konservasi", $where);
        if($query->num_rows() > 0){
            $data['record'] = $query->result();
        } else {
            $data['record'] = array();
        }
        
        $data['dataFungsiKK'] = $this->m_referensi->GetFungsiKK();
        $data['dataProv'] = $this->m_referensi->GetAllProvinsi();
        $data['dataSatker'] = $this->m_referensi->GetSatker();
        $data['dataTujuan'] = $this->m_referensi->GetReferensi('tujuan');
        $data['dataAktivitas'] = $this->m_referensi->GetReferensi('aktivitas_pemanfaatan');
        

        $this->load->view('kemkon/index.php',$data);
    }

    public function ekspor() {
        define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        $fungsi_kk_id = $this->input->post('fungsi_kk_id');
        $prov_id = $this->input->post('prov_id');
        $tujuan_id = $this->input->post('tujuan_id');
        $aktivitas_pemanfaatan = $this->input->post('aktivitas_pemanfaatan');
        $satker_kode = $this->input->post('satker_kode');
        $tahun = $this->input->post('tahun');
        $kk_reg = $this->input->post('kk_reg');
        $data['judul'] = 'Data Kemitraan Konservasi ';
        if ($this->session->sub_role == 4 ) {
            $satker_kode = $this->session->satker_kode;
        }
        if (!isset($tahun)){
            $tahun = date('Y');
        }
        if (!isset($fungsi_kk_id)){
            $fungsi_kk_id = 0;
        }
        if (!isset($prov_id)){
            $prov_id = 0;
        }
        if (!isset($satker_kode)){
            $satker_kode = 0;
        }
        if (!isset($kk_reg)){
            $kk_reg = 0;
        }
        if (!isset($tujuan_id)){
            $tujuan_id = 0;
        }
        if (!isset($aktivitas_pemanfaatan)){
            $aktivitas_pemanfaatan = 0;
        }
        $where = array();
        if ($fungsi_kk_id != 0) {
            $where['fungsi_kk_id'] = $fungsi_kk_id;
        }
        if ($satker_kode != 0) {
            $where['kelompok.satker_kode'] = $satker_kode;
            $data['dataKK'] = $this->m_referensi->GetKKSatker($satker_kode);
        } else {
            $data['dataKK'] = $this->m_referensi->GetAllKK();
        }
        if ($prov_id != 0) {
            $where['FIND_IN_SET('.$prov_id.',kawasan.prov_id) !='] = '0';
            //$where['satker.prov_id'] = $prov_id;
        } 
        if ($tahun != '0') {
            $where['kemitraan_konservasi.tgl_pks >='] = $tahun.'-01-01';
            $where['kemitraan_konservasi.tgl_pks <='] = $tahun.'-12-31';
        }
        if ($tujuan_id != '0') {
            $where['kemitraan_konservasi.tujuan_id'] = $tujuan_id;
        }
        if ($aktivitas_pemanfaatan != '0') {
            $where['CONCAT(";", aktivitas_pemanfaatan, ";") like '] = '%'.$aktivitas_pemanfaatan.'%';
        }
        if ($kk_reg != '0') {
            $where['kelompok.kk_reg'] = $kk_reg;
        }
        $data['kk_exist'] = $kk_reg;
        $data['tahun_exist'] = $tahun;
        $data['fungsi_exist'] = $fungsi_kk_id;
        $data['prov_exist'] = $prov_id;
        $data['satker_exist'] = $satker_kode;
        $data['tujuan_exist'] = $tujuan_id;
        $data['aktivitas_pemanfaatan_exist'] = $aktivitas_pemanfaatan;
        $query = $this->db->select('id_kemitraan, kemitraan_konservasi.*, kelompok.satker_kode as satker_kode, kelompok_id, kelompok.desa_id as desa_id, kelompok.nama_kelompok as nama_kelompok, fungsi_kk.nama_fungsi, fungsi_kk.short_name, satker.nama_satker, UI.nama_user, kawasan.nama_kk, ref_tujuan.detail_1 as tujuan_kemitraan, ref_aktivitas_pemanfaatan.detail_1 as akt_pemanfaatan')
                ->join('kelompok', 'kemitraan_konservasi.kelompok_id = kelompok.id_kelompok','left outer')
                ->join('satker', 'kelompok.satker_kode = satker.kode_satker','left outer')
                ->join('kawasan', 'kelompok.kk_reg = kawasan.reg_kk','left outer')
                ->join('fungsi_kk', 'kawasan.fungsi_kk_id = fungsi_kk.id_fungsi_kk','left outer')
                ->join('ref_tujuan', 'kemitraan_konservasi.tujuan_id = ref_tujuan.id_reference','left outer')
                ->join('ref_aktivitas_pemanfaatan', 'kemitraan_konservasi.aktivitas_pemanfaatan = ref_aktivitas_pemanfaatan.id_reference','left outer')
                ->join('users as UI', 'kemitraan_konservasi.user_input = UI.id_user','left outer')
                ->group_by('id_kemitraan')
                ->order_by('id_kemitraan', 'DESC')
                ->get_where("kemitraan_konservasi", $where);

        $filename = 'assets/template/ekspor/kemitraan_konservasi.xls';
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        
        $objPHPExcel = $objReader->load($filename);
        //$objPHPExcel->getActiveSheet()->setCellValue('C4', $judul);
        $baseRow = 7;
        //GET DATA
        $data = $query->result();
        $no=1;
        foreach($data as $r => $dataRow) {
            $row = $baseRow + $r;
            

            //echo $jml_desa.'<br>';
            //$endmerge = intval($row)+intval($jml_desa)-1;
            //$objPHPExcel->getActiveSheet()->mergeCells("C".($row).":C".($endmerge));
            //$objPHPExcel->getActiveSheet()->mergeCells("D".($row).":D".($endmerge));
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $no)
                                          ->setCellValue('C'.$row, $dataRow->nama_satker)
                                          ->setCellValue('D'.$row, $dataRow->short_name.' '.$dataRow->nama_kk)
                                          ->setCellValue('E'.$row, $dataRow->nama_kelompok)
                                          ->setCellValue('F'.$row, $this->getdatadesaekspor($dataRow->desa_id))
                                          ->setCellValue('G'.$row, $dataRow->luas)
                                          ->setCellValue('H'.$row, $dataRow->no_spd)
                                          ->setCellValue('I'.$row, $dataRow->jangka_waktu)
                                          ->setCellValue('J'.$row, $dataRow->no_pks)
                                          ->setCellValue('K'.$row, $dataRow->tgl_pks)
                                          ->setCellValue('L'.$row, $dataRow->judul_pks)
                                          ->setCellValue('M'.$row, $dataRow->tujuan_kemitraan)
                                          ->setCellValue('N'.$row, $dataRow->akt_pemanfaatan)
                                          ->setCellValue('O'.$row, $dataRow->vol_pemanfaatan)
                                          ->setCellValue('P'.$row, $dataRow->nilai_ekonomi)
                                          ->setCellValue('Q'.$row, $dataRow->keterangan)
                                          ->setCellValue('R'.$row, $dataRow->nama_user);
            
            $no++;
            
        }
        //$objPHPExcel->getActiveSheet()->removeRow($baseRow-1,1);
        //Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="data_kemitraan_konservasi_'.date('dmY').'.xls"');
        
        // If you're serving to IE over SSL, then the following may be needed
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        //$objWriter->save(str_replace('.php', '.xls', __FILE__));
        $objWriter->save('php://output');
        exit;
    }

    public function resume() {
        $fungsi_kk_id = $this->input->post('fungsi_kk_id');
        $prov_id = $this->input->post('prov_id');
        $tujuan_id = $this->input->post('tujuan_id');
        $aktivitas_pemanfaatan = $this->input->post('aktivitas_pemanfaatan');
        $satker_kode = $this->input->post('satker_kode');
        $tahun = $this->input->post('tahun');
        $kk_reg = $this->input->post('kk_reg');
        $data['judul'] = 'Resume Data Kemitraan Konservasi ';
        $data['tahun_judul'] = '';
        if ($this->session->sub_role == 4 ) {
            $satker_kode = $this->session->satker_kode;
        }
        if (!isset($tahun)){
            $tahun = 0;
        }
        if (!isset($fungsi_kk_id)){
            $fungsi_kk_id = 0;
        }
        if (!isset($prov_id)){
            $prov_id = 0;
        }
        if (!isset($satker_kode)){
            $satker_kode = 0;
        }
        if (!isset($kk_reg)){
            $kk_reg = 0;
        }
        if (!isset($tujuan_id)){
            $tujuan_id = 0;
        }
        if (!isset($aktivitas_pemanfaatan)){
            $aktivitas_pemanfaatan = 0;
        }
        $where = array();
        if ($fungsi_kk_id != 0) {

            $where['fungsi_kk_id'] = $fungsi_kk_id;
        }
        if ($satker_kode != 0) {
            $where['kelompok.satker_kode'] = $satker_kode;
            $data['dataKK'] = $this->m_referensi->GetKKSatker($satker_kode);
        } else {
            $data['dataKK'] = $this->m_referensi->GetAllKK();
        }
        if ($prov_id != 0) {
            $where['FIND_IN_SET('.$prov_id.',kawasan.prov_id) !='] = '0';
            //$where['kawasan.prov_id'] = $prov_id;
            //$where['kawasan.prov_id'] = $prov_id;
        } 
        if ($tahun != '0') {
            $where['kemitraan_konservasi.tgl_pks >='] = $tahun.'-01-01';
            $where['kemitraan_konservasi.tgl_pks <='] = $tahun.'-12-31';
            $data['judul'] = $data['judul'].' Tahun '.$tahun;
            $data['tahun_judul'] = 'Tahun '.$tahun;
        }
        if ($tujuan_id != '0') {
            $where['kemitraan_konservasi.tujuan_id'] = $tujuan_id;
        }
        if ($aktivitas_pemanfaatan != '0') {
            $where['CONCAT(";", aktivitas_pemanfaatan, ";") like '] = '%'.$aktivitas_pemanfaatan.'%';
        }
        if ($kk_reg != '0') {
            $where['kelompok.kk_reg'] = $kk_reg;
        }
        
        $where['kemitraan_konservasi.no_pks !='] = '-';
        $data['kk_exist'] = $kk_reg;
        $data['tahun_exist'] = $tahun;
        $data['fungsi_exist'] = $fungsi_kk_id;
        $data['prov_exist'] = $prov_id;
        $data['satker_exist'] = $satker_kode;
        $data['tujuan_exist'] = $tujuan_id;
        $data['aktivitas_pemanfaatan_exist'] = $aktivitas_pemanfaatan;
        $query = $this->db->select('DISTINCT(id_kemitraan), COUNT(DISTINCT(CASE WHEN tujuan_id = 1 THEN id_kemitraan END )) as jml_pks_pe, COUNT(DISTINCT(CASE WHEN tujuan_id = 2 THEN id_kemitraan END )) as jml_pks_pm, COUNT(DISTINCT(id_kemitraan)) as jml_pks, SUM(luas) as jml_luas, SUM(case when tujuan_id = 1 then luas else 0 end) as jml_pe, SUM(case when tujuan_id = 2 then luas else 0 end) as jml_pm, COUNT(DISTINCT(kemitraan_konservasi.kelompok_id)) as jml_kelompok, COUNT(DISTINCT(kelompok.kk_reg)) as jml_kawasan, COUNT(DISTINCT(kelompok.satker_kode)) as jml_satker, SUM(CHAR_LENGTH(kelompok.desa_id) - CHAR_LENGTH(REPLACE(kelompok.desa_id, ";", "")) + 1) as jml_desa')
                ->join('kelompok', 'kemitraan_konservasi.kelompok_id = kelompok.id_kelompok','left outer')
                ->join('ref_tujuan', 'kemitraan_konservasi.tujuan_id = ref_tujuan.id_reference','left outer')
                ->join('users as UI', 'kemitraan_konservasi.user_input = UI.id_user','left outer')
                ->join('satker', 'kelompok.satker_kode = satker.kode_satker','left outer')
                ->join('kawasan', 'kelompok.kk_reg = kawasan.reg_kk','left outer')
                ->join('fungsi_kk', 'kawasan.fungsi_kk_id = fungsi_kk.id_fungsi_kk','left outer')
                ->limit(1)->get_where("kemitraan_konservasi", $where, false);
        if($query->num_rows() > 0){
            $data['record'] = $query->row();
        } else {
            $data['record'] = array();
        }
        
        $data['dataFungsiKK'] = $this->m_referensi->GetFungsiKK();
        $data['dataProv'] = $this->m_referensi->GetAllProvinsi();
        $data['dataSatker'] = $this->m_referensi->GetSatker();
        $data['dataTujuan'] = $this->m_referensi->GetReferensi('tujuan');
        $data['dataAktivitas'] = $this->m_referensi->GetReferensi('aktivitas_pemanfaatan');
        

        $this->load->view('kemkon/resume_data.php',$data);
    }

    public function unduhresume() {
        $fungsi_kk_id = $this->input->post('fungsi_kk_id');
        $prov_id = $this->input->post('prov_id');
        $tujuan_id = $this->input->post('tujuan_id');
        $aktivitas_pemanfaatan = $this->input->post('aktivitas_pemanfaatan');
        $satker_kode = $this->input->post('satker_kode');
        $tahun = $this->input->post('tahun');
        $kk_reg = $this->input->post('kk_reg');
        $data['judul'] = 'Resume Data Kemitraan Konservasi ';
        $data['tahun_judul'] = '';
        if ($this->session->sub_role == 4 ) {
            $satker_kode = $this->session->satker_kode;
        }
        if (!isset($tahun)){
            $tahun = 0;
        }
        if (!isset($fungsi_kk_id)){
            $fungsi_kk_id = 0;
        }
        if (!isset($prov_id)){
            $prov_id = 0;
        }
        if (!isset($satker_kode)){
            $satker_kode = 0;
        }
        if (!isset($kk_reg)){
            $kk_reg = 0;
        }
        if (!isset($tujuan_id)){
            $tujuan_id = 0;
        }
        if (!isset($aktivitas_pemanfaatan)){
            $aktivitas_pemanfaatan = 0;
        }
        $where = array();
        if ($fungsi_kk_id != 0) {

            $where['fungsi_kk_id'] = $fungsi_kk_id;
        }
        if ($satker_kode != 0) {
            $where['kelompok.satker_kode'] = $satker_kode;
            $data['dataKK'] = $this->m_referensi->GetKKSatker($satker_kode);
        } else {
            $data['dataKK'] = $this->m_referensi->GetAllKK();
        }
        if ($prov_id != 0) {
            $where['FIND_IN_SET('.$prov_id.',kawasan.prov_id) !='] = '0';
            //$where['kawasan.prov_id'] = $prov_id;
        } 
        if ($tahun != '0') {
            $where['kemitraan_konservasi.tgl_pks >='] = $tahun.'-01-01';
            $where['kemitraan_konservasi.tgl_pks <='] = $tahun.'-12-31';
            $data['judul'] = $data['judul'].' Tahun '.$tahun;
            $data['tahun_judul'] = 'Tahun '.$tahun;
        }
        if ($tujuan_id != '0') {
            $where['kemitraan_konservasi.tujuan_id'] = $tujuan_id;
        }
        if ($aktivitas_pemanfaatan != '0') {
            $where['CONCAT(";", aktivitas_pemanfaatan, ";") like '] = '%'.$aktivitas_pemanfaatan.'%';
        }
        if ($kk_reg != '0') {
            $where['kelompok.kk_reg'] = $kk_reg;
        }
        
        $where['kemitraan_konservasi.no_pks !='] = '-';
        $data['kk_exist'] = $kk_reg;
        $data['tahun_exist'] = $tahun;
        $data['fungsi_exist'] = $fungsi_kk_id;
        $data['prov_exist'] = $prov_id;
        $data['satker_exist'] = $satker_kode;
        $data['tujuan_exist'] = $tujuan_id;
        $data['aktivitas_pemanfaatan_exist'] = $aktivitas_pemanfaatan;
        $query = $this->db->select('DISTINCT(id_kemitraan), COUNT(DISTINCT(CASE WHEN tujuan_id = 1 THEN id_kemitraan END )) as jml_pks_pe, COUNT(DISTINCT(CASE WHEN tujuan_id = 2 THEN id_kemitraan END )) as jml_pks_pm, COUNT(DISTINCT(id_kemitraan)) as jml_pks, SUM(luas) as jml_luas, SUM(case when tujuan_id = 1 then luas else 0 end) as jml_pe, SUM(case when tujuan_id = 2 then luas else 0 end) as jml_pm, COUNT(DISTINCT(kemitraan_konservasi.kelompok_id)) as jml_kelompok, COUNT(DISTINCT(kelompok.kk_reg)) as jml_kawasan, COUNT(DISTINCT(kelompok.satker_kode)) as jml_satker, SUM(CHAR_LENGTH(kelompok.desa_id) - CHAR_LENGTH(REPLACE(kelompok.desa_id, ";", "")) + 1) as jml_desa')
                ->join('kelompok', 'kemitraan_konservasi.kelompok_id = kelompok.id_kelompok','left outer')
                ->join('ref_tujuan', 'kemitraan_konservasi.tujuan_id = ref_tujuan.id_reference','left outer')
                ->join('users as UI', 'kemitraan_konservasi.user_input = UI.id_user','left outer')
                ->join('kawasan', 'kelompok.kk_reg = kawasan.reg_kk','left outer')
                ->join('fungsi_kk', 'kawasan.fungsi_kk_id = fungsi_kk.id_fungsi_kk','left outer')
                ->limit(1)->get_where("kemitraan_konservasi", $where);
        if($query->num_rows() > 0){
            $data['record'] = $query->row();
        } else {
            $data['record'] = array();
        }
        
        $html = $this->load->view('kemkon/unduh_resume_data',$data,true);
        $pdfFileName = 'Resume_Data_Kemitraan_Konservasi.pdf';
        $this->mpdf->SetTitle($pdfFileName);
        $this->mpdf->WriteHTML($html);
        $footer = '<div style="font-size: 7pt;"><i>';
        $footer .= 'Dicetak melalui Sistem Informasi Daerah Penyangga Kawasan Konservasi dan Kemitraan Konservasi (SIMDPKK) pada tanggal '.date('d F Y');
        $footer .= '</i></div>';
        $file = 'Resume_Data_Kemitraan_Konservasi.pdf';
        header("Content-Disposition: attachment; filename='".$file."'");
        $this->mpdf->SetHTMLFooter($footer);
        $this->mpdf->Output($pdfFileName,'I');
        exit();
    }

    public function add() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $data['judul'] = "Tambah Data Kemitraan Konservasi ";
        if ($this->session->sub_role == 4) {
            $data['dataKelompok'] = $this->m_referensi->GetKelompokSatker($this->session->satker_kode);
        } else {
            $data['dataKelompok'] = $this->m_referensi->GetAllKelompok();
        }
        $data['dataTujuan'] = $this->m_referensi->GetReferensi('tujuan');
        $data['dataZonaBlok'] = $this->m_referensi->GetReferensi('zona_blok');
        $data['dataAktivitas'] = $this->m_referensi->GetReferensi('aktivitas_pemanfaatan');
        $this->load->view('kemkon/form_create', $data);
    }

    public function insert() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $now = date("Y-m-d H:i:s");

        //get data kelompok
        $kelompok_id = $this->input->post('kelompok_id');
        $row_kelompok = $this->m_referensi->GetDetailKelompok($kelompok_id);
        $satker_kode = $row_kelompok->kode_satker;
        $kk_reg = $row_kelompok->reg_kk;
        $tujuan_id = $this->input->post('tujuan_id');
        $data = array('satker_kode'=>$satker_kode,
                      'kk_reg'=>$kk_reg,
                      'kelompok_id'=>$kelompok_id,
                      'luas'=>$this->input->post('luas'),
                      'no_spd'=>$this->input->post('no_spd'),
                      'jangka_waktu'=>$this->input->post('jangka_waktu'),
                      'no_pks'=>$this->input->post('no_pks'),
                      'tgl_pks'=>$this->input->post('tgl_pks'),
                      'judul_pks'=>$this->input->post('judul_pks'),
                      'tujuan_id'=>$tujuan_id,
                      'keterangan'=>$this->input->post('keterangan'),
                      'nilai_ekonomi'=>$this->input->post('nilai_ekonomi'),
                      'zona_blok'=>$this->input->post('zona_blok'),
                      'created_at'=>$now,
                      'updated_at'=>$now,
                      'user_input'=>$this->session->user_id);
        if ($tujuan_id == 2) {
            //set status kawasan 
            $c_aktv = count($this->input->post('aktivitas_pemanfaatan[]'));
            $aktivitas_pemanfaatan = "";
            for ($i=0; $i < $c_aktv; $i++) { 
                $x=$c_aktv-1;
                $aktivitas_pemanfaatan .= $this->input->post('aktivitas_pemanfaatan['.$i.']');
                if ($i != $x) {
                    $aktivitas_pemanfaatan .= ";";
                }
            }
            $data['aktivitas_pemanfaatan'] = $aktivitas_pemanfaatan;
            $data['vol_pemanfaatan'] = $this->input->post('vol_pemanfaatan');
        }

        //upload file
        $config1['upload_path']          = './assets/filekemitraankonservasi/';
        $config1['allowed_types']        = 'pdf';
        $this->load->library('upload', $config1);
        $this->upload->initialize($config1);
        if($this->upload->do_upload('filebaverifikasi')){
            $file_name = $this->upload->data('file_name');
            $data['file_ba_verifikasi'] = $file_name;
        }
        //upload file
        $config2['upload_path']          = './assets/filekemitraankonservasi/';
        $config2['allowed_types']        = 'pdf';
        $this->load->library('upload', $config2);
        $this->upload->initialize($config2);
        if($this->upload->do_upload('filepks')){
            if ($tujuan_id == 1) {
                $config11['upload_path']          = './assets/fileupload/';
                $config11['allowed_types']        = 'pdf';
                $this->load->library('upload', $config11);
                $this->upload->initialize($config11);
                $this->upload->do_upload('filepks');
            }
            $file_name = $this->upload->data('file_name');
            $data['file_pks'] = $file_name;
                
        }
        //upload file
        $config3['upload_path']          = './assets/filekemitraankonservasi/';
        $config3['allowed_types']        = 'kml';
        $this->load->library('upload', $config3);
        $this->upload->initialize($config3);
        if($this->upload->do_upload('filepeta')){
            if ($tujuan_id == 1) {
                $config12['upload_path']          = './assets/fileupload/';
                $config12['allowed_types']        = 'kml';
                $this->load->library('upload', $config12);
                $this->upload->initialize($config12);
                $this->upload->do_upload('filepeta');
            } 
            $file_name = $this->upload->data('file_name');
            $data['file_peta'] = $file_name;
               
        }

        //PUSH TO SIMPULIH
        
        $insert = $this->db->set($data)->insert('kemitraan_konservasi');
        if($insert){
            if ($tujuan_id == 1) {
                $linkAPI = "http://simpulih.menlhk.go.id/kemitraan/";
                //$linkAPI = "http://localhost/simpulih/kemitraan/";
                $url = $linkAPI.'insertapi';
                //$data['fileuploadpks'] = '@'.$_FILES['filepks']['tmp_name'];
                $data['nama_kelompok'] = $row_kelompok->nama_kelompok;
                $data['desa_id'] = $row_kelompok->desa_id;
                $data['jml_anggota_kelompok'] = $row_kelompok->jml_anggota_kelompok;
                die($this->postCURL($url, $data));
            } else {
                die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Kemitraan Konservasi berhasil dibuat.')));
            }
                
            
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Kemitraan Konservasi gagal dibuat.')));
            //return false;
        }
        
        
            
    }

    public function postCURL($_url, $_param){

        $postData = '';
        //create name value pairs seperated by &
        foreach($_param as $k => $v) 
        { 
          $postData .= $k . '='.$v.'&'; 
        }
        rtrim($postData, '&');


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, false); 
        /*curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                            'Content-Type: multipart/form-data'
                                            ));*/
        curl_setopt($ch, CURLOPT_POST, count($postData));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);    

        $output=curl_exec($ch);

        curl_close($ch);

        return $output;
    }

    public function edit($id) {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $data['judul'] = "Ubah Data Kemitraan Konservasi ";
        $query = $this->db->select('kemitraan_konservasi.*')
                ->from("kemitraan_konservasi")
                ->where('id_kemitraan', $id)
                ->limit(1)
                ->get();
        if($query->num_rows() > 0){
            $row = $query->row();
            $data['record'] = $row;
            $data['recordSelectedReff'] = $this->m_referensi->GetReffSelected('aktivitas_pemanfaatan',$row->aktivitas_pemanfaatan);
        } else {
            $data['record'] = array();
            $data['recordSelectedReff'] = array();
        }
        if ($this->session->sub_role == 4) {
            $data['dataKelompok'] = $this->m_referensi->GetKelompokSatker($this->session->satker_kode);
        } else {
            $data['dataKelompok'] = $this->m_referensi->GetAllKelompok();
        }
        $data['dataZonaBlok'] = $this->m_referensi->GetReferensi('zona_blok');
        $data['dataTujuan'] = $this->m_referensi->GetReferensi('tujuan');
        $data['dataAktivitas'] = $this->m_referensi->GetReferensi('aktivitas_pemanfaatan');
        $data['dataRefAktivitas'] = $this->getdatareffjson('aktivitas_pemanfaatan');
        $this->load->view('kemkon/form_edit', $data);
    }

    

    public function update() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $now = date("Y-m-d H:i:s");

        //get data kelompok
        $kelompok_id = $this->input->post('kelompok_id');
        $row_kelompok = $this->m_referensi->GetDetailKelompok($kelompok_id);
        $satker_kode = $row_kelompok->kode_satker;
        $kk_reg = $row_kelompok->reg_kk;
        $tujuan_id = $this->input->post('tujuan_id');
        $data = array('satker_kode'=>$satker_kode,
                      'kk_reg'=>$kk_reg,
                      'kelompok_id'=>$kelompok_id,
                      'luas'=>$this->input->post('luas'),
                      'no_spd'=>$this->input->post('no_spd'),
                      'jangka_waktu'=>$this->input->post('jangka_waktu'),
                      'no_pks'=>$this->input->post('no_pks'),
                      'tgl_pks'=>$this->input->post('tgl_pks'),
                      'judul_pks'=>$this->input->post('judul_pks'),
                      'tujuan_id'=>$tujuan_id,
                      'keterangan'=>$this->input->post('keterangan'),
                      'nilai_ekonomi'=>$this->input->post('nilai_ekonomi'),
                      'zona_blok'=>$this->input->post('zona_blok'),
                      'created_at'=>$now,
                      'updated_at'=>$now,
                      'user_input'=>$this->session->user_id);
        if ($tujuan_id == 2) {
            //set status kawasan 
            $c_aktv = count($this->input->post('aktivitas_pemanfaatan[]'));
            $aktivitas_pemanfaatan = "";
            for ($i=0; $i < $c_aktv; $i++) { 
                $x=$c_aktv-1;
                $aktivitas_pemanfaatan .= $this->input->post('aktivitas_pemanfaatan['.$i.']');
                if ($i != $x) {
                    $aktivitas_pemanfaatan .= ";";
                }
            }
            $data['aktivitas_pemanfaatan'] = $aktivitas_pemanfaatan;
            $data['vol_pemanfaatan'] = $this->input->post('vol_pemanfaatan');
        }

        //upload file
        $config1['upload_path']          = './assets/filekemitraankonservasi/';
        $config1['allowed_types']        = 'pdf';
        $this->load->library('upload', $config1);
        $this->upload->initialize($config1);
        if($this->upload->do_upload('filebaverifikasi')){
            $file_name = $this->upload->data('file_name');
            $data['file_ba_verifikasi'] = $file_name;
            if ($this->input->post('file_ba_verifikasi_old') != '') {
                unlink('./assets/filekemitraankonservasi/'.$this->input->post('file_ba_verifikasi_old'));
            }
        }
        //upload file
        $config2['upload_path']          = './assets/filekemitraankonservasi/';
        $config2['allowed_types']        = 'pdf';
        $this->load->library('upload', $config2);
        $this->upload->initialize($config2);
        if($this->upload->do_upload('filepks')){
            $file_name = $this->upload->data('file_name');
            $data['file_pks'] = $file_name;
            if ($this->input->post('file_pks_old') != '') {
                unlink('./assets/filekemitraankonservasi/'.$this->input->post('file_pks_old'));
            }
        }
        //upload file
        $config3['upload_path']          = './assets/filekemitraankonservasi/';
        $config3['allowed_types']        = 'kml';
        $this->load->library('upload', $config3);
        $this->upload->initialize($config3);
        if($this->upload->do_upload('filepeta')){
            $file_name = $this->upload->data('file_name');
            $data['file_peta'] = $file_name;
            if ($this->input->post('file_peta_old') != '') {
                unlink('./assets/filekemitraankonservasi/'.$this->input->post('file_peta_old'));
            }
        }
        $update = $this->db->where('id_kemitraan', $this->input->post('id_kemitraan'))
                            ->update("kemitraan_konservasi", $data);
            
        if($update){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Kemitraan Konservasi berhasil disimpan.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Kemitraan Konservasi gagal disimpan.')));
            //return false;
        }

    }

    public function detail($id) {
        $data['judul'] = "Detail Data Kemitraan Konservasi ";
        $query = $this->db->select('kemitraan_konservasi.*, DATE_FORMAT(kemitraan_konservasi.tgl_pks,\'%d %b %Y\') as newtgl, kelompok.satker_kode as satker_kode, kelompok.desa_id as desa_id, kelompok.nama_kelompok as nama_kelompok, fungsi_kk.nama_fungsi, fungsi_kk.short_name, satker.nama_satker, UI.nama_user, kawasan.nama_kk, ref_tujuan.detail_1 as tujuan_kemitraan, ref_zona_blok.detail_1 as zona_blok_detail,kemitraan_konservasi.updated_at as last_update')
                ->join('kelompok', 'kemitraan_konservasi.kelompok_id = kelompok.id_kelompok','left outer')
                ->join('satker', 'kelompok.satker_kode = satker.kode_satker','left outer')
                ->join('kawasan', 'kelompok.kk_reg = kawasan.reg_kk','left outer')
                ->join('fungsi_kk', 'kawasan.fungsi_kk_id = fungsi_kk.id_fungsi_kk','left outer')
                ->join('ref_tujuan', 'kemitraan_konservasi.tujuan_id = ref_tujuan.id_reference','left outer')
                ->join('ref_zona_blok', 'kemitraan_konservasi.zona_blok = ref_zona_blok.id_reference','left outer')
                ->join('users as UI', 'kemitraan_konservasi.user_input = UI.id_user','left outer')
                ->where("id_kemitraan", $id)
                ->limit(1)
                ->get("kemitraan_konservasi");
        if($query->num_rows() > 0){
            $row = $query->row();
            $data['record'] = $row;
        } else {
            $data['record'] = array();
        }
        $this->load->view('kemkon/form_detail', $data);
    }

    public function delete() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $id_kemitraan= $this->input->post('id');
        $query = $this->db->where('id_kemitraan', $id_kemitraan)->get("kemitraan_konservasi");
        $row = $query->row();
        $file1 = $row->file_ba_verifikasi;
        $file2 = $row->file_pks;
        $file2 = $row->file_peta;
        if ($file1 != "") {
            unlink('./assets/filekemitraankonservasi/'.$file1);
        }
        if ($file2 != "") {
            unlink('./assets/filekemitraankonservasi/'.$file2);
        }
        if ($file3 != "") {
            unlink('./assets/filekemitraankonservasi/'.$file3);
        }
        $delete_data = $this->db->where('id_kemitraan', $id_kemitraan)->delete("kemitraan_konservasi");
        if($delete_data){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Kemitraan Konservasi  berhasil dihapus.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Kemitraan Konservasi  gagal dihapus.')));
            //return false;
        }

    }

    public function getdataaktivitasview($value) {
        $arr_status = explode(';', $value);
        
        $val_status = "";
        $x = count($arr_status);
        if ($x > 1) {
            for ($i=0; $i < $x; $i++) { 
                $query = $this->db->select('*')
                    ->where(array('id_reference'=>$arr_status[$i]))->get("ref_aktivitas_pemanfaatan");
                $record = $query->row();
                $val_status .= "- ".$record->detail_1;
                if ($i != $x) {
                    $val_status .= "<br> ";
                }
            }
        } else {
            if ($value == 0 || $value == '' || $value == NULL) {
                $val_status .= '***Data Kosong***';
            } else {
                $query = $this->db->select('*')
                    ->where(array('id_reference'=>$arr_status[0]))->get("ref_aktivitas_pemanfaatan");
                $record = $query->row();
                $val_status .= $record->detail_1;
            }
        }
                
        echo $val_status;
    }

    public function getdatadesaview($value=NULL) {
        if (!isset($value) || empty($value)) {
            $value = $this->input->get('val');
        } else {
            $value = $value;
        }
        
        $arr_desa = explode(';', $value);
        
        $val_desa = "";
        $x = count($arr_desa);
        if ($x > 1) {
            for ($i=0; $i < $x; $i++) { 
                $y=$x-1;
                $query = $this->db->select('id_desa,nama_desa')
                    ->where(array('id_desa'=>$arr_desa[$i]))->get("adm_daerah");
                $record = $query->row();
                $val_desa .= 'DESA '.$record->nama_desa;
                if ($i != $y) {
                    $val_desa .= ", ";
                }
            }
        } else {
            $query = $this->db->select('id_desa,nama_desa')
                    ->where(array('id_desa'=>$arr_desa[0]))->get("adm_daerah");
            $record = $query->row();
            $val_desa .= 'DESA '.$record->nama_desa;
        }
                
        echo $val_desa;
    }

    public function getdatareffjson($get) {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $result = $this->m_referensi->GetReferensi($get);
        $main = array();
        $list = array('id_reference' => 'id', 'detail_1' => 'text');
        foreach ($result as $index => $item){ 
            foreach ($item as $key => $value) {
                $main[$index][$list[$key]] = $value; 
            }
        }
        return json_encode($main);
    }

    public function getdatakelompok() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $id = $this->input->get('id');
        $result = $this->m_referensi->GetDetailKelompok($id);
        
        die(json_encode($result));
    }

    public function getdatadesaekspor($value=NULL) {
        if (!isset($value) || empty($value)) {
            $value = $this->input->get('val');
        } else {
            $value = $value;
        }
        
        $arr_desa = explode(';', $value);
        
        $val_desa = "";
        $x = count($arr_desa);
        if ($x > 1) {
            for ($i=0; $i < $x; $i++) { 
                $y=$x-1;
                $query = $this->db->select('id_desa,nama_desa')
                    ->where(array('id_desa'=>$arr_desa[$i]))->get("adm_daerah");
                $record = $query->row();
                $val_desa .= 'DESA '.$record->nama_desa;
                if ($i != $y) {
                    $val_desa .= ", ";
                }
            }
        } else {
            $query = $this->db->select('id_desa,nama_desa')
                    ->where(array('id_desa'=>$arr_desa[0]))->get("adm_daerah");
            $record = $query->row();
            $val_desa .= $record->nama_desa;
        }
                
        return $val_desa;
    }
}
