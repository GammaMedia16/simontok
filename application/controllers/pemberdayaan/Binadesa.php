<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Binadesa extends CI_Controller{
    //put your code here
    public function __construct()
    {
        parent::__construct();
        $this->load->library('mpdf');
        $this->load->library('excel');
        $this->load->model('m_referensi','m_referensi');
        ini_set("memory_limit","512M");
        date_default_timezone_set('Asia/Jakarta');
    }    
    
    public function index() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $fungsi_kk_id = $this->input->post('fungsi_kk_id');
        $prov_id = $this->input->post('prov_id');
        $satker_kode = $this->input->post('satker_kode');
        $tahun = $this->input->post('tahun');
        $kk_reg = $this->input->post('kk_reg');
        $usaha_id = $this->input->post('usaha_id');
        $data['judul'] = 'Data Pembinaan Desa Sekitar Kawasan Konservasi ';
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
        if (!isset($usaha_id)){
            $usaha_id = 0;
        }
        $where = array();
        if ($fungsi_kk_id != 0) {
            $where['fungsi_kk_id'] = $fungsi_kk_id;
        }
        if ($satker_kode != 0) {
            $where['kawasan.satker_kode'] = $satker_kode;
            $data['dataKK'] = $this->m_referensi->GetKKSatker($satker_kode);
        } else {
            $data['dataKK'] = $this->m_referensi->GetAllKK();
        }
        if ($prov_id != 0) {
            $where['FIND_IN_SET('.$prov_id.',kawasan.prov_id) !='] = '0';
            //$where['satker.prov_id'] = $prov_id;
        } 
        if ($tahun != '0') {
            $where['pdskk.tahun_keg'] = $tahun;
        }
        if ($kk_reg != '0') {
            $where['pdskk.kk_reg'] = $kk_reg;
        }
        if ($usaha_id != '0') {
            $where['pdskk.usaha_id'] = $usaha_id;
        }
        $data['kk_exist'] = $kk_reg;
        $data['tahun_exist'] = $tahun;
        $data['fungsi_exist'] = $fungsi_kk_id;
        $data['prov_exist'] = $prov_id;
        $data['satker_exist'] = $satker_kode;
        $data['usaha_exist'] = $usaha_id;
        $query = $this->db->select('id_pdskk, pdskk.satker_kode as satker_kode, kelompok_id, tahun_keg, MAX(tahap_id) as tahap_id, kelompok.desa_id as desa_id, kelompok.nama_kelompok as nama_kelompok, fungsi_kk.nama_fungsi, fungsi_kk.short_name, satker.nama_satker, UI.nama_user, kawasan.nama_kk, (SELECT SUM(biaya_keg) FROM pdskk as pp WHERE pp.kelompok_id = pdskk.kelompok_id AND pp.tahun_keg = pdskk.tahun_keg) AS total_biaya')
                ->join('kelompok', 'pdskk.kelompok_id = kelompok.id_kelompok','left outer')
                ->join('satker', 'pdskk.satker_kode = satker.kode_satker','left outer')
                ->join('kawasan', 'pdskk.kk_reg = kawasan.reg_kk','left outer')
                ->join('fungsi_kk', 'kawasan.fungsi_kk_id = fungsi_kk.id_fungsi_kk','left outer')
                ->join('ref_jenis_usaha', 'pdskk.usaha_id = ref_jenis_usaha.id_reference','left outer')
                ->join('users as UI', 'pdskk.user_input = UI.id_user','left outer')
                ->group_by('kelompok_id,tahun_keg')
                ->order_by('id_pdskk,tahap_id', 'DESC')
                ->get_where("pdskk", $where);
        if($query->num_rows() > 0){
            $data['record'] = $query->result();
        } else {
            $data['record'] = array();
        }
        
        $data['dataFungsiKK'] = $this->m_referensi->GetFungsiKK();
        $data['dataProv'] = $this->m_referensi->GetAllProvinsi();
        $data['dataSatker'] = $this->m_referensi->GetSatker();
        $data['dataUsaha'] = $this->m_referensi->GetReferensi('jenis_usaha');
        

        $this->load->view('binadesa/index.php',$data);
    }

    public function ekspor() {
        define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        
        $fungsi_kk_id = $this->input->post('fungsi_kk_id');
        $prov_id = $this->input->post('prov_id');
        $satker_kode = $this->input->post('satker_kode');
        $tahun = $this->input->post('tahun');
        $kk_reg = $this->input->post('kk_reg');
        $usaha_id = $this->input->post('usaha_id');
        $judul = '';
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
        if (!isset($usaha_id)){
            $usaha_id = 0;
        }
        $where = array();
        if ($fungsi_kk_id != 0) {
            $where['fungsi_kk_id'] = $fungsi_kk_id;
        }
        if ($satker_kode != 0) {
            $where['kawasan.satker_kode'] = $satker_kode;
            $data['dataKK'] = $this->m_referensi->GetKKSatker($satker_kode);
        } else {
            $data['dataKK'] = $this->m_referensi->GetAllKK();
        }
        if ($prov_id != 0) {
            $where['FIND_IN_SET('.$prov_id.',kawasan.prov_id) !='] = '0';
            //$where['satker.prov_id'] = $prov_id;
        } 
        if ($tahun != '0') {
            $where['pdskk.tahun_keg'] = $tahun;
        }
        if ($kk_reg != '0') {
            $where['pdskk.kk_reg'] = $kk_reg;
        }
        if ($usaha_id != '0') {
            $where['pdskk.usaha_id'] = $usaha_id;
        }
        $query = $this->db->select('id_pdskk, pdskk.satker_kode as satker_kode, kelompok_id, tahun_keg, kelompok.desa_id as desa_id, kelompok.nama_kelompok as nama_kelompok, fungsi_kk.nama_fungsi, fungsi_kk.short_name, satker.nama_satker, UI.nama_user as nama_user, kawasan.nama_kk, T1.detail_1 as tahap_pembinaan, T2.detail_1 as tahap_pembinaan_mitra, ref_jenis_usaha.detail_1 as jenis_usaha, pdskk.*')
                ->join('kelompok', 'pdskk.kelompok_id = kelompok.id_kelompok','left outer')
                ->join('satker', 'pdskk.satker_kode = satker.kode_satker','left outer')
                ->join('kawasan', 'pdskk.kk_reg = kawasan.reg_kk','left outer')
                ->join('fungsi_kk', 'kawasan.fungsi_kk_id = fungsi_kk.id_fungsi_kk','left outer')
                ->join('ref_tahap_pembinaan as T1', 'pdskk.tahap_id = T1.id_reference','left outer')
                ->join('ref_tahap_pembinaan as T2', 'pdskk.tahap_id_mitra = T2.id_reference','left outer')
                ->join('ref_jenis_usaha', 'pdskk.usaha_id = ref_jenis_usaha.id_reference','left outer')
                ->join('users as UI', 'pdskk.user_input = UI.id_user','left outer')
                ->order_by('id_pdskk,tahap_id', 'DESC')
                ->get_where("pdskk", $where);

        $filename = 'assets/template/ekspor/pdskk.xls';
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
                                          ->setCellValue('G'.$row, $dataRow->tahap_pembinaan)
                                          ->setCellValue('H'.$row, $dataRow->nama_keg)
                                          ->setCellValue('I'.$row, $dataRow->biaya_keg)
                                          ->setCellValue('J'.$row, $dataRow->tahun_keg)
                                          ->setCellValue('K'.$row, $dataRow->nama_mitra)
                                          ->setCellValue('L'.$row, $dataRow->tahap_pembinaan_mitra)
                                          ->setCellValue('M'.$row, $dataRow->nama_keg_mitra)
                                          ->setCellValue('N'.$row, $dataRow->jenis_usaha)
                                          ->setCellValue('O'.$row, $dataRow->ket_usaha)
                                          ->setCellValue('P'.$row, $dataRow->keuntungan_usaha)
                                          ->setCellValue('Q'.$row, $dataRow->jml_anggota_interaksi)
                                          ->setCellValue('R'.$row, $dataRow->rata_pendapatan)
                                          ->setCellValue('S'.$row, $dataRow->jml_kas)
                                          ->setCellValue('T'.$row, $dataRow->nama_user);
            
            $no++;
            
        }
        //$objPHPExcel->getActiveSheet()->removeRow($baseRow-1,1);
        //Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="data_pembinaan_desa_'.date('dmY').'.xls"');
        
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
        $satker_kode = $this->input->post('satker_kode');
        $tahun = $this->input->post('tahun');
        $kk_reg = $this->input->post('kk_reg');
        $usaha_id = $this->input->post('usaha_id');
        $data['judul'] = 'Resume Data Pembinaan Desa Sekitar Kawasan Konservasi ';
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
        if (!isset($usaha_id)){
            $usaha_id = 0;
        }
        $where = array();
        if ($fungsi_kk_id != 0) {

            $where['fungsi_kk_id'] = $fungsi_kk_id;
        }
        if ($satker_kode != 0) {
            $where['pdskk.satker_kode'] = $satker_kode;
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
            $where['pdskk.tahun_keg'] = $tahun;
            $data['judul'] = $data['judul'].' Tahun '.$tahun;
            $data['tahun_judul'] = 'Tahun '.$tahun;
        }
        if ($kk_reg != '0') {
            $where['pdskk.kk_reg'] = $kk_reg;
        }
        if ($usaha_id != '0') {
            $where['pdskk.usaha_id'] = $usaha_id;
        }
        $data['kk_exist'] = $kk_reg;
        $data['tahun_exist'] = $tahun;
        $data['fungsi_exist'] = $fungsi_kk_id;
        $data['prov_exist'] = $prov_id;
        $data['satker_exist'] = $satker_kode;
        $data['usaha_exist'] = $usaha_id;
        $query = $this->db->select('COUNT(DISTINCT(pdskk.kelompok_id)) as jml_kelompok, SUM(biaya_keg) as jml_biaya, COUNT(DISTINCT(pdskk.kk_reg)) as jml_kawasan, COUNT(DISTINCT(pdskk.satker_kode)) as jml_satker, SUM(keuntungan_usaha) as jml_untung, SUM(jml_kas) as jml_kas, AVG(rata_pendapatan) as jml_rata_pendapatan')
                ->join('kelompok', 'pdskk.kelompok_id = kelompok.id_kelompok','inner')
                ->join('users as UI', 'pdskk.user_input = UI.id_user','inner')
                ->join('kawasan', 'pdskk.kk_reg = kawasan.reg_kk','left outer')
                ->join('fungsi_kk', 'kawasan.fungsi_kk_id = fungsi_kk.id_fungsi_kk','left outer')
                ->limit(1)->get_where("pdskk", $where);
        $query1 = $this->db->select('COUNT(DISTINCT(pdskk.kelompok_id)) as jml_kelompok, ref_jenis_usaha.detail_1 as jenis_usaha, usaha_id')
                ->join('ref_jenis_usaha', 'pdskk.usaha_id = ref_jenis_usaha.id_reference','left outer')
                ->join('kelompok', 'pdskk.kelompok_id = kelompok.id_kelompok','left outer')
                ->join('kawasan', 'pdskk.kk_reg = kawasan.reg_kk','left outer')
                ->join('fungsi_kk', 'kawasan.fungsi_kk_id = fungsi_kk.id_fungsi_kk','left outer')
                ->group_by('usaha_id')->where('usaha_id !=', 0)->get_where("pdskk", $where);
        $query2 = $this->db->select('jml_anggota_kelompok as jml_anggota_interaksi, CHAR_LENGTH(kelompok.desa_id) - CHAR_LENGTH(REPLACE(kelompok.desa_id, ";", "")) + 1 as jml_desa')
                ->join('pdskk', 'kelompok.id_kelompok = pdskk.kelompok_id','left outer')
                ->join('ref_jenis_usaha', 'pdskk.usaha_id = ref_jenis_usaha.id_reference','left outer')
                ->join('kawasan', 'kelompok.kk_reg = kawasan.reg_kk','left outer')
                ->join('fungsi_kk', 'kawasan.fungsi_kk_id = fungsi_kk.id_fungsi_kk','left outer')
                ->group_by('pdskk.kelompok_id')->where('pdskk.kelompok_id !=', '')->get_where("kelompok", $where);
        /*$query3 = $this->db->select('COUNT(*) AS jumlah FROM ( SELECT GROUP_CONCAT(desa_id separator  \';\') AS all_tags, LENGTH(GROUP_CONCAT(desa_id SEPARATOR \';\')) - LENGTH(REPLACE(GROUP_CONCAT( desa_id SEPARATOR  \';\'),  \';\', \'\')) + 1 AS count_tags')
                ->join('numbers as n', 'n.num <= t.count_tags')
                ->get_where("kelompok ) as t", $where);*/
        if($query->num_rows() > 0){
            $data['record'] = $query->row();
            $data['record1'] = $query1->result();
            $jml_anggota_interaksi = 0;
            $jml_desa_terlibat = 0;
            foreach ($query2->result() as $rowjml) {
                $jml_anggota_interaksi += $rowjml->jml_anggota_interaksi;
                $jml_desa_terlibat += $rowjml->jml_desa;
            }
            $data['jml_anggota_interaksi'] = $jml_anggota_interaksi;
            $data['jml_desa_terlibat'] = $jml_desa_terlibat;
        } else {
            $data['record'] = array();
            $data['record1'] = array();
            $data['jml_desa_terlibat'] = 0;
            $data['jml_anggota_interaksi'] = 0;
        }
        
        $data['dataFungsiKK'] = $this->m_referensi->GetFungsiKK();
        $data['dataProv'] = $this->m_referensi->GetAllProvinsi();
        $data['dataSatker'] = $this->m_referensi->GetSatker();
        $data['dataUsaha'] = $this->m_referensi->GetReferensi('jenis_usaha');
        

        $this->load->view('binadesa/resume_data.php',$data);
    }

    public function unduhresume() {
        //CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $fungsi_kk_id = $this->input->post('fungsi_kk_id');
        $prov_id = $this->input->post('prov_id');
        $satker_kode = $this->input->post('satker_kode');
        $tahun = $this->input->post('tahun');
        $kk_reg = $this->input->post('kk_reg');
        $usaha_id = $this->input->post('usaha_id');
        $data['judul'] = 'Resume Data Pembinaan Desa Sekitar Kawasan Konservasi ';
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
        if (!isset($usaha_id)){
            $usaha_id = 0;
        }
        $where = array();
        if ($fungsi_kk_id != 0) {

            $where['fungsi_kk_id'] = $fungsi_kk_id;
        }
        if ($satker_kode != 0) {
            $where['pdskk.satker_kode'] = $satker_kode;
            $data['dataKK'] = $this->m_referensi->GetKKSatker($satker_kode);
        } else {
            $data['dataKK'] = $this->m_referensi->GetAllKK();
        }
        if ($prov_id != 0) {
            $where['FIND_IN_SET('.$prov_id.',kawasan.prov_id) !='] = '0';
            //$where['kawasan.prov_id'] = $prov_id;
        } 
        if ($tahun != '0') {
            $where['pdskk.tahun_keg'] = $tahun;
            $data['judul'] = $data['judul'].' Tahun '.$tahun;
            $data['tahun_judul'] = 'Tahun '.$tahun;
        }
        if ($kk_reg != '0') {
            $where['pdskk.kk_reg'] = $kk_reg;
        }
        if ($usaha_id != '0') {
            $where['pdskk.usaha_id'] = $usaha_id;
        }
        $data['kk_exist'] = $kk_reg;
        $data['tahun_exist'] = $tahun;
        $data['fungsi_exist'] = $fungsi_kk_id;
        $data['prov_exist'] = $prov_id;
        $data['satker_exist'] = $satker_kode;
        $data['usaha_exist'] = $usaha_id;
        $query = $this->db->select('COUNT(DISTINCT(pdskk.kelompok_id)) as jml_kelompok, SUM(biaya_keg) as jml_biaya, SUM(jml_anggota_kelompok) as jml_anggota_interaksi, COUNT(DISTINCT(pdskk.kk_reg)) as jml_kawasan, COUNT(DISTINCT(pdskk.satker_kode)) as jml_satker, SUM(keuntungan_usaha) as jml_untung, SUM(jml_kas) as jml_kas, AVG(rata_pendapatan) as jml_rata_pendapatan')
                ->join('kelompok', 'pdskk.kelompok_id = kelompok.id_kelompok','inner')
                ->join('users as UI', 'pdskk.user_input = UI.id_user','inner')
                ->join('kawasan', 'pdskk.kk_reg = kawasan.reg_kk','left outer')
                ->join('fungsi_kk', 'kawasan.fungsi_kk_id = fungsi_kk.id_fungsi_kk','left outer')
                ->limit(1)->get_where("pdskk", $where);
        $query1 = $this->db->select('COUNT(DISTINCT(pdskk.kelompok_id)) as jml_kelompok, ref_jenis_usaha.detail_1 as jenis_usaha, usaha_id')
                ->join('ref_jenis_usaha', 'pdskk.usaha_id = ref_jenis_usaha.id_reference','left outer')
                ->join('kelompok', 'pdskk.kelompok_id = kelompok.id_kelompok','left outer')
                ->join('kawasan', 'pdskk.kk_reg = kawasan.reg_kk','left outer')
                ->join('fungsi_kk', 'kawasan.fungsi_kk_id = fungsi_kk.id_fungsi_kk','left outer')
                ->group_by('usaha_id')->get_where("pdskk", $where);

        $query2 = $this->db->select('jml_anggota_kelompok as jml_anggota_interaksi, CHAR_LENGTH(kelompok.desa_id) - CHAR_LENGTH(REPLACE(kelompok.desa_id, ";", "")) + 1 as jml_desa')
                ->join('pdskk', 'kelompok.id_kelompok = pdskk.kelompok_id','left outer')
                ->join('ref_jenis_usaha', 'pdskk.usaha_id = ref_jenis_usaha.id_reference','left outer')
                ->join('kawasan', 'kelompok.kk_reg = kawasan.reg_kk','left outer')
                ->join('fungsi_kk', 'kawasan.fungsi_kk_id = fungsi_kk.id_fungsi_kk','left outer')
                ->group_by('id_kelompok')->where('pdskk.kelompok_id !=', '')->get_where("kelompok", $where);
       


        if($query->num_rows() > 0){
            $data['record'] = $query->row();
            $data['record1'] = $query1->result();
            $jml_anggota_interaksi = 0;
            $jml_desa_terlibat = 0;
            foreach ($query2->result() as $rowjml) {
                $jml_anggota_interaksi += $rowjml->jml_anggota_interaksi;
                $jml_desa_terlibat += $rowjml->jml_desa;
            }
            $data['jml_anggota_interaksi'] = $jml_anggota_interaksi;
            $data['jml_desa_terlibat'] = $jml_desa_terlibat;
        } else {
            $data['record'] = array();
            $data['record1'] = array();
            $data['jml_anggota_interaksi'] = 0;
            $data['jml_desa_terlibat'] = 0;
        }

        /*$this->load->view('binadesa/unduh_resume_data.php',$data);
        */
        $html = $this->load->view('binadesa/unduh_resume_data',$data,true);
        $pdfFileName = 'Resume_Data_Pembinaan_Desa_Sekitar_KK.pdf';
        $this->mpdf->SetTitle($pdfFileName);
        $this->mpdf->WriteHTML($html);
        $footer = '<div style="font-size: 7pt;"><i>';
        $footer .= 'Dicetak melalui Sistem Informasi Daerah Penyangga Kawasan Konservasi dan Kemitraan Konservasi (SIMDPKK) pada tanggal '.date('d F Y');
        $footer .= '</i></div>';
        $file = 'Resume_Data_Pembinaan_Desa_Sekitar_KK.pdf';
        header("Content-Disposition: attachment; filename='".$file."'");
        $this->mpdf->SetHTMLFooter($footer);
        $this->mpdf->Output($pdfFileName,'I');
        exit();
    }
    
    public function add() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $data['judul'] = "Tambah Data Pembinaan Desa Sekitar Kawasan Konservasi ";
        if ($this->session->sub_role == 4) {
            $data['dataKelompok'] = $this->m_referensi->GetKelompokSatker($this->session->satker_kode);
        } else {
            $data['dataKelompok'] = $this->m_referensi->GetAllKelompok();
        }
        $data['dataTahap'] = $this->m_referensi->GetReferensi('tahap_pembinaan');
        $data['dataUsaha'] = $this->m_referensi->GetReferensi('jenis_usaha');
        $this->load->view('binadesa/form_create', $data);
    }

    public function insert() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $now = date("Y-m-d H:i:s");
        //cek count tahap
        $c_tahap = 0;
        $dataTahap = $this->m_referensi->GetReferensi('tahap_pembinaan');
        foreach ($dataTahap as $row) {
            $value = $this->input->post('nama_keg'.$row->id_reference);
            $biaya = $this->input->post('biaya_keg'.$row->id_reference);
            if ($value != "" && $biaya != "") {
                $c_tahap++;
            }
        }
        if ($c_tahap == 0) {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Tahap Kegiatan Pembinaan harus diisi minimal 1. Data Pembinaan Desa Sekitar KK gagal dibuat.')));
        } else {

            //get data kelompok
            $kelompok_id = $this->input->post('kelompok_id');
            $row_kelompok = $this->m_referensi->GetDetailKelompok($kelompok_id);
            $satker_kode = $row_kelompok->kode_satker;
            $kk_reg = $row_kelompok->reg_kk;
            $cekEnd = 0;
            foreach ($dataTahap as $row) {
                $nama_keg = $this->input->post('nama_keg'.$row->id_reference);
                $biaya_keg = $this->input->post('biaya_keg'.$row->id_reference);
                if ($nama_keg != "" && $nama_keg != "") {
                    $data = array('satker_kode'=>$satker_kode,
                                  'kk_reg'=>$kk_reg,
                                  'kelompok_id'=>$kelompok_id,
                                  'tahap_id'=>$row->id_reference,
                                  'nama_keg'=>$nama_keg,
                                  'biaya_keg'=>$biaya_keg,
                                  'tahun_keg'=>$this->input->post('tahun'),
                                  'nama_mitra'=>$this->input->post('nama_mitra'),
                                  'tahap_id_mitra'=>$this->input->post('tahap_id_mitra'),
                                  'nama_keg_mitra'=>$this->input->post('nama_keg_mitra'),
                                  'usaha_id'=>$this->input->post('usaha_id'),
                                  'ket_usaha'=>$this->input->post('ket_usaha'),
                                  'keuntungan_usaha'=>$this->input->post('keuntungan_usaha'),
                                  'jml_anggota_interaksi'=>$this->input->post('jml_anggota_interaksi'),
                                  'rata_pendapatan'=>$this->input->post('rata_pendapatan'),
                                  'jml_kas'=>$this->input->post('jml_kas'),
                                  'created_at'=>$now,
                                  'updated_at'=>$now,
                                  'user_input'=>$this->session->user_id);
                    //upload file
                    $config1['upload_path']          = './assets/filepembinaandesa/';
                    $config1['allowed_types']        = 'pdf';
                    $config1['overwrite'] = TRUE;
                    $this->load->library('upload', $config1);
                    $this->upload->initialize($config1);
                    if($this->upload->do_upload('filerpl')){
                        $file_name = $this->upload->data('file_name');
                        $data['file_rpl'] = $file_name;
                    }
                    //upload file
                    $config2['upload_path']          = './assets/filepembinaandesa/';
                    $config2['allowed_types']        = 'pdf';
                    $config2['overwrite'] = TRUE;
                    $this->load->library('upload', $config2);
                    $this->upload->initialize($config2);
                    if($this->upload->do_upload('filerkt')){
                        $file_name = $this->upload->data('file_name');
                        $data['file_rkt'] = $file_name;
                    }
                    //upload file
                    $config3['upload_path']          = './assets/filepembinaandesa/';
                    $config3['allowed_types']        = 'jpg|jpeg|png';
                    $config3['overwrite'] = TRUE;
                    $this->load->library('upload', $config3);
                    $this->upload->initialize($config3);
                    if($this->upload->do_upload('fotousaha')){
                        $file_name = $this->upload->data('file_name');
                        $data['foto_usaha'] = $file_name;
                    }
                    $insert = $this->db->set($data)->insert('pdskk');
                    /*UPDATE DESA BINAAN*/
                    $dataKelompok = $this->m_referensi->GetDetailKelompok($kelompok_id);
                    $dataDesa = $dataKelompok->desa_id;
                    $arr_desa = explode(';', $dataDesa);
                    $x = count($arr_desa);
                    if ($x >= 1) {
                        for ($i=0; $i < $x; $i++) { 
                            $id_desa = $arr_desa[$i];
                            $dataUpdateDesaBinaan = array('status_binaan'=>1,
                                                            'updated_at'=>$now,
                                                            'user_input'=>$this->session->user_id);
                            $updateDesaBinaan = $this->db->where('id_desa', $id_desa)
                                                         ->update("adm_daerah", $dataUpdateDesaBinaan);
                        }
                    } 
                    $cekEnd++;
                }
            }

            if($c_tahap == $cekEnd){
                die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Pembinaan Desa Sekitar KK berhasil dibuat.')));
                //return true;
            } else {
                die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Pembinaan Desa Sekitar KK gagal dibuat.')));
                //return false;
            }
        }
            
    }

    public function edit($id) {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $data['judul'] = "Ubah Data Pembinaan Desa Sekitar Kawasan Konservasi ";
        $query = $this->db->select('pdskk.*')
                ->join('kelompok', 'pdskk.kelompok_id = kelompok.id_kelompok','left outer')
                ->join('satker', 'pdskk.satker_kode = satker.kode_satker','left outer')
                ->join('kawasan', 'pdskk.kk_reg = kawasan.reg_kk','left outer')
                ->join('fungsi_kk', 'kawasan.fungsi_kk_id = fungsi_kk.id_fungsi_kk','left outer')
                ->join('users as UI', 'pdskk.user_input = UI.id_user','left outer')
                ->group_by('kelompok_id,tahun_keg')
                ->order_by('id_pdskk,tahap_id', 'DESC')
                ->from("pdskk")
                ->where('id_pdskk', $id)
                ->limit(1)
                ->get();
        if($query->num_rows() > 0){
            $row = $query->row();
            $data['record'] = $row;
            $query1 = $this->db->select('tahap_id, nama_keg, biaya_keg, tahun_keg')
                ->where('kelompok_id', $row->kelompok_id)
                ->where('usaha_id', $row->usaha_id)
                ->where('tahun_keg', $row->tahun_keg)
                ->get('pdskk');
            $data['recordTahap'] = $query1->result();
        } else {
            $data['record'] = array();
            $data['recordTahap'] = $row;
        }
        if ($this->session->sub_role == 4) {
            $data['dataKelompok'] = $this->m_referensi->GetKelompokSatker($this->session->satker_kode);
        } else {
            $data['dataKelompok'] = $this->m_referensi->GetAllKelompok();
        }
        $data['dataTahap'] = $this->m_referensi->GetReferensi('tahap_pembinaan');
        $data['dataUsaha'] = $this->m_referensi->GetReferensi('jenis_usaha');
        
        $this->load->view('binadesa/form_edit', $data);
    }

    

    public function update() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $now = date("Y-m-d H:i:s");
        //cek count tahap
        $c_tahap = 0;
        $dataTahap = $this->m_referensi->GetReferensi('tahap_pembinaan');
        foreach ($dataTahap as $row) {
            $value = $this->input->post('nama_keg'.$row->id_reference);
            $biaya = $this->input->post('biaya_keg'.$row->id_reference);
            if ($value != "" && $biaya != "") {
                $c_tahap++;
            }
        }
        if ($c_tahap == 0) {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Tahap Kegiatan Pembinaan harus diisi minimal 1. Data Pembinaan Desa Sekitar KK gagal dibuat.')));
        } else {
            $delete_data = $this->db->where("kelompok_id", $this->input->post('kelompok_id_old'))->where("tahun_keg", $this->input->post('tahun_keg_old'))->where("usaha_id", $this->input->post('usaha_id_old'))->delete("pdskk");
            //get data kelompok
            $kelompok_id = $this->input->post('kelompok_id');
            $row_kelompok = $this->m_referensi->GetDetailKelompok($kelompok_id);
            $satker_kode = $row_kelompok->kode_satker;
            $kk_reg = $row_kelompok->reg_kk;
            $cekEnd = 0;
            foreach ($dataTahap as $row) {
                $nama_keg = $this->input->post('nama_keg'.$row->id_reference);
                $biaya_keg = $this->input->post('biaya_keg'.$row->id_reference);
                if ($nama_keg != "" && $nama_keg != "") {
                    $data = array('satker_kode'=>$satker_kode,
                                  'kk_reg'=>$kk_reg,
                                  'kelompok_id'=>$kelompok_id,
                                  'tahap_id'=>$row->id_reference,
                                  'nama_keg'=>$nama_keg,
                                  'biaya_keg'=>$biaya_keg,
                                  'tahun_keg'=>$this->input->post('tahun'),
                                  'nama_mitra'=>$this->input->post('nama_mitra'),
                                  'tahap_id_mitra'=>$this->input->post('tahap_id_mitra'),
                                  'nama_keg_mitra'=>$this->input->post('nama_keg_mitra'),
                                  'usaha_id'=>$this->input->post('usaha_id'),
                                  'ket_usaha'=>$this->input->post('ket_usaha'),
                                  'keuntungan_usaha'=>$this->input->post('keuntungan_usaha'),
                                  'jml_anggota_interaksi'=>$this->input->post('jml_anggota_interaksi'),
                                  'rata_pendapatan'=>$this->input->post('rata_pendapatan'),
                                  'jml_kas'=>$this->input->post('jml_kas'),
                                  'created_at'=>$now,
                                  'updated_at'=>$now,
                                  'user_input'=>$this->session->user_id);
                    //upload file
                    $config1['upload_path']          = './assets/filepembinaandesa/';
                    $config1['allowed_types']        = 'pdf';
                    $config1['overwrite'] = TRUE;
                    $this->load->library('upload', $config1);
                    $this->upload->initialize($config1);
                    if($this->upload->do_upload('filerpl')){
                        $file_name = $this->upload->data('file_name');
                        $data['file_rpl'] = $file_name;
                        //unlink('./assets/filepembinaandesa/'.$this->input->post('file_rpl_old'));
                    } else {
                        $data['file_rpl'] = $this->input->post('file_rpl_old');
                    }

                    //upload file
                    $config2['upload_path']          = './assets/filepembinaandesa/';
                    $config2['allowed_types']        = 'pdf';
                    $config2['overwrite'] = TRUE;
                    $this->load->library('upload', $config2);
                    $this->upload->initialize($config2);
                    if($this->upload->do_upload('filerkt')){
                        $file_name1 = $this->upload->data('file_name');
                        $data['file_rkt'] = $file_name1;
                        //unlink('./assets/filepembinaandesa/'.$this->input->post('file_rkt_old'));
                    } else {
                        $data['file_rkt'] = $this->input->post('file_rkt_old');
                    }
                    //upload file
                    $config3['upload_path']          = './assets/filepembinaandesa/';
                    $config3['allowed_types']        = 'jpg|jpeg|png';
                    $config3['overwrite'] = TRUE;
                    $this->load->library('upload', $config3);
                    $this->upload->initialize($config3);
                    if($this->upload->do_upload('fotousaha')){
                        $file_name2 = $this->upload->data('file_name');
                        $data['foto_usaha'] = $file_name2;
                        //unlink('./assets/filepembinaandesa/'.$this->input->post('foto_usaha_old'));
                    } else {
                        $data['foto_usaha'] = $this->input->post('foto_usaha_old');
                    }
                    $insert = $this->db->set($data)->insert('pdskk');
                    /*UPDATE DESA BINAAN*/
                    $dataKelompok = $this->m_referensi->GetDetailKelompok($kelompok_id);
                    $dataDesa = $dataKelompok->desa_id;
                    $arr_desa = explode(';', $dataDesa);
                    $x = count($arr_desa);
                    if ($x >= 1) {
                        for ($i=0; $i < $x; $i++) { 
                            $id_desa = $arr_desa[$i];
                            $dataUpdateDesaBinaan = array('status_binaan'=>1,
                                                            'updated_at'=>$now,
                                                            'user_input'=>$this->session->user_id);
                            $updateDesaBinaan = $this->db->where('id_desa', $id_desa)
                                                         ->update("adm_daerah", $dataUpdateDesaBinaan);
                        }
                    } 
                    $cekEnd++;
                }
            }

            if($c_tahap == $cekEnd){
                die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Pembinaan Desa Sekitar KK berhasil disimpan.')));
                //return true;
            } else {
                die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Pembinaan Desa Sekitar KK gagal disimpan.')));
                //return false;
            }
        }

    }

    public function detail($id) {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());

        $data['judul'] = "Detail Data Pembinaan Desa Sekitar Kawasan Konservasi ";
        $query = $this->db->select('pdskk.*, kelompok.nama_kelompok as nama_kelompok, kelompok.desa_id as desa_id, fungsi_kk.nama_fungsi, fungsi_kk.short_name, satker.nama_satker, UI.nama_user, kawasan.nama_kk, SUM(biaya_keg) AS total_biaya, ref_tahap_pembinaan.detail_1 as tahap_mitra, ref_jenis_usaha.detail_1 as jenis_usaha')
                ->join('kelompok', 'pdskk.kelompok_id = kelompok.id_kelompok','left outer')
                ->join('satker', 'pdskk.satker_kode = satker.kode_satker','left outer')
                ->join('kawasan', 'pdskk.kk_reg = kawasan.reg_kk','left outer')
                ->join('fungsi_kk', 'kawasan.fungsi_kk_id = fungsi_kk.id_fungsi_kk','left outer')
                ->join('users as UI', 'pdskk.user_input = UI.id_user','left outer')
                ->join('ref_tahap_pembinaan', 'pdskk.tahap_id_mitra = ref_tahap_pembinaan.id_reference', 'left outer')
                ->join('ref_jenis_usaha', 'pdskk.usaha_id = ref_jenis_usaha.id_reference', 'left outer')
                ->where("id_pdskk", $id)
                ->limit(1)
                ->get("pdskk");
        if($query->num_rows() > 0){
            $row = $query->row();
            $data['record'] = $row;
            $query1 = $this->db->select('*')
                ->join('ref_tahap_pembinaan', 'pdskk.tahap_id = ref_tahap_pembinaan.id_reference', 'left outer')
                ->where('kelompok_id', $row->kelompok_id)
                ->where('usaha_id', $row->usaha_id)
                ->where('tahun_keg', $row->tahun_keg)
                ->order_by('tahap_id', 'ASC')
                ->get('pdskk');
            $data['recordTahap'] = $query1->result();
        } else {
            $data['record'] = array();
            $data['recordTahap'] = array();
        }
        $this->load->view('binadesa/form_detail', $data);
    }

    public function unduhdetail($id) {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());

        $data['judul'] = "Detail Data Pembinaan Desa Sekitar Kawasan Konservasi ";
        $query = $this->db->select('pdskk.*, kelompok.nama_kelompok as nama_kelompok, fungsi_kk.nama_fungsi, fungsi_kk.short_name, satker.nama_satker, UI.nama_user, kawasan.nama_kk, SUM(biaya_keg) AS total_biaya, ref_tahap_pembinaan.detail_1 as tahap_mitra, ref_jenis_usaha.detail_1 as jenis_usaha,  kelompok.desa_id as desa_id,')
                ->join('kelompok', 'pdskk.kelompok_id = kelompok.id_kelompok','left outer')
                ->join('satker', 'pdskk.satker_kode = satker.kode_satker','left outer')
                ->join('kawasan', 'pdskk.kk_reg = kawasan.reg_kk','left outer')
                ->join('fungsi_kk', 'kawasan.fungsi_kk_id = fungsi_kk.id_fungsi_kk','left outer')
                ->join('users as UI', 'pdskk.user_input = UI.id_user','left outer')
                ->join('ref_tahap_pembinaan', 'pdskk.tahap_id_mitra = ref_tahap_pembinaan.id_reference', 'left outer')
                ->join('ref_jenis_usaha', 'pdskk.usaha_id = ref_jenis_usaha.id_reference', 'left outer')
                ->where("id_pdskk", $id)
                ->limit(1)
                ->get("pdskk");
        if($query->num_rows() > 0){
            $row = $query->row();
            $data['record'] = $row;
            $query1 = $this->db->select('*')
                ->join('ref_tahap_pembinaan', 'pdskk.tahap_id = ref_tahap_pembinaan.id_reference', 'left outer')
                ->where('usaha_id', $row->usaha_id)
                ->where('kelompok_id', $row->kelompok_id)
                ->where('tahun_keg', $row->tahun_keg)
                ->order_by('tahap_id', 'ASC')
                ->get('pdskk');
            $data['recordTahap'] = $query1->result();
        } else {
            $data['record'] = array();
            $data['recordTahap'] = array();
        }
        //$this->load->view('binadesa/unduh_form_detail', $data);

        $html = $this->load->view('binadesa/unduh_form_detail',$data,true);
        $pdfFileName = 'Detail_Data_Pembinaan_Desa_Sekitar_KK.pdf';
        $this->mpdf->SetTitle($pdfFileName);
        $this->mpdf->WriteHTML($html);
        $footer = '<div style="font-size: 7pt;"><i>';
        $footer .= 'Dicetak melalui Sistem Informasi Daerah Penyangga Kawasan Konservasi dan Kemitraan Konservasi (SIMDPKK) pada tanggal '.date('d F Y');
        $footer .= '</i></div>';
        $file = 'Detail_Data_Pembinaan_Desa_Sekitar_KK.pdf';
        header("Content-Disposition: attachment; filename='".$file."'");
        $this->mpdf->SetHTMLFooter($footer);
        $this->mpdf->Output($pdfFileName,'I');
        exit();
    }

    public function delete() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $kelompok_id= $this->input->post('kelompok_id');
        $tahun_keg= $this->input->post('tahun_keg');
        $query = $this->db->where('kelompok_id', $kelompok_id)->where('tahun_keg', $tahun_keg)->limit(1)->get("pdskk");
        $row = $query->row();
        $file1 = $row->file_rpl;
        $file2 = $row->file_rkt;
        $file3 = $row->foto_usaha;
        if ($file1 != "") {
            unlink('./assets/filepembinaandesa/'.$file1);
        }
        if ($file2 != "") {
            unlink('./assets/filepembinaandesa/'.$file2);
        }
        if ($file3 != "") {
            unlink('./assets/filepembinaandesa/'.$file3);
        }
        $delete_data = $this->db->where('kelompok_id', $kelompok_id)->where('tahun_keg', $tahun_keg)->delete("pdskk");
        if($delete_data){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Pembinaan Desa Sekitar Kawasan Konservasi  berhasil dihapus.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Pembinaan Desa Sekitar Kawasan Konservasi  gagal dihapus.')));
            //return false;
        }

    }



    public function getdatastatuskwsview($value) {
        $arr_status = explode(';', $value);
        
        $val_status = "";
        $x = count($arr_status);
        if ($x > 1) {
            for ($i=0; $i < $x; $i++) { 
                $query = $this->db->select('*')
                    ->where(array('id_reference'=>$arr_status[$i]))->get("ref_status_kawasan");
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
                    ->where(array('id_reference'=>$arr_status[0]))->get("ref_status_kawasan");
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
                $val_desa .= $record->nama_desa;
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
                
        echo $val_desa;
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

    public function getdatakelompokdetail($id) {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $query = $this->db->select("*")
                          ->join('satker as S', 'kelompok.satker_kode = S.kode_satker','left outer')
                          ->join('kawasan as K', 'kelompok.kk_reg = K.reg_kk','left outer')
                          ->join('fungsi_kk as F', 'K.fungsi_kk_id = F.id_fungsi_kk','left outer')
                          ->where('id_kelompok',$id)
                          ->limit(1)
                          ->get("kelompok");
        return $query->row();
    }

    public function getdatadesadetail($value) {
        $arr_desa = explode(';', $value);
        
        $val_desa = array();
        $x = count($arr_desa);
        for ($i=0; $i < $x; $i++) { 
            if ($arr_desa[$i] != 0 || $arr_desa[$i] != '') {
               $query = $this->db->select('*')
                    ->where(array('id_desa'=>$arr_desa[$i]))->get("adm_daerah");
                
                //if($query->num_rows() > 0){
                    $record = $query->row();
                    $row_desa = array();
                    $row_desa['nama_desa'] = $record->nama_desa;
                    $row_desa['nama_kec'] = $record->nama_kec;
                    $row_desa['nama_kab_kota'] = $record->nama_kab_kota;
                    $row_desa['nama_prov'] = $record->nama_prov;
                    $val_desa[$i] = $row_desa;
                //} 
            }
                
            
        }
                
        return $val_desa;
    }
}
