<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dpkk extends CI_Controller{
    //put your code here
    public function __construct()
    {
        parent::__construct();
        $this->load->library('mpdf');
        $this->load->library('excel');
        $this->load->model('m_referensi','m_referensi');
        date_default_timezone_set('Asia/Jakarta');
    }    
    
    public function index() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $fungsi_kk_id = $this->input->post('fungsi_kk_id');
        $prov_id = $this->input->post('prov_id');
        $satker_kode = $this->input->post('satker_kode');
        $kk_reg = $this->input->post('kk_reg');
        $data['judul'] = 'Data Daerah Penyangga Kawasan Konservasi';
        if ($this->session->sub_role == 4 ) {
            $satker_kode = $this->session->satker_kode;
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
        if ($kk_reg != '0') {
            $where['dpkk.kk_reg'] = $kk_reg;
        }
        if ($prov_id != 0) {
            $where['FIND_IN_SET('.$prov_id.',kawasan.prov_id) !='] = '0';
            //$where['kawasan.prov_id'] = $prov_id;
        } 
        $data['kk_exist'] = $kk_reg;
        $data['fungsi_exist'] = $fungsi_kk_id;
        $data['prov_exist'] = $prov_id;
        $data['satker_exist'] = $satker_kode;
        $query = $this->db->select('dpkk.*, fungsi_kk.nama_fungsi, fungsi_kk.short_name, satker.nama_satker, UI.nama_user, kawasan.nama_kk')
                ->join('satker', 'dpkk.satker_kode = satker.kode_satker','left outer')
                ->join('kawasan', 'dpkk.kk_reg = kawasan.reg_kk','left outer')
                ->join('fungsi_kk', 'kawasan.fungsi_kk_id = fungsi_kk.id_fungsi_kk','left outer')
                ->join('users as UI', 'dpkk.user_input = UI.id_user','left outer')
                ->group_by('id_dpkk')
                ->order_by('id_dpkk', 'DESC')
                ->get_where("dpkk", $where);
        if($query->num_rows() > 0){
            $data['record'] = $query->result();
        } else {
            $data['record'] = array();
        }
        
        $data['dataFungsiKK'] = $this->m_referensi->GetFungsiKK();
        $data['dataProv'] = $this->m_referensi->GetAllProvinsi();
        $data['dataSatker'] = $this->m_referensi->GetSatker();

        $this->load->view('dpkk/index.php',$data);
    }

    public function resume() {
        $fungsi_kk_id = $this->input->post('fungsi_kk_id');
        $prov_id = $this->input->post('prov_id');
        $satker_kode = $this->input->post('satker_kode');
        $kk_reg = $this->input->post('kk_reg');
        $data['judul'] = 'Resume Data Daerah Penyangga Kawasan Konservasi';
        if ($this->session->sub_role == 4 ) {
            $satker_kode = $this->session->satker_kode;
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
        if ($kk_reg != '0') {
            $where['dpkk.kk_reg'] = $kk_reg;
        }
        if ($prov_id != 0) {
            $where['FIND_IN_SET('.$prov_id.',kawasan.prov_id) !='] = '0';
            //$where['kawasan.prov_id'] = $prov_id;
        } 
        $data['kk_exist'] = $kk_reg;
        $data['fungsi_exist'] = $fungsi_kk_id;
        $data['prov_exist'] = $prov_id;
        $data['satker_exist'] = $satker_kode;
        $query = $this->db->select('SUM(luas_dpkk) as luas_dpkk, SUM(CHAR_LENGTH(dpkk.desa_id) - CHAR_LENGTH(REPLACE(dpkk.desa_id, ";", "")) + 1) as jml_desa, COUNT(DISTINCT(dpkk.kk_reg)) as jml_kawasan, COUNT(DISTINCT(dpkk.satker_kode)) as jml_satker')
                ->join('satker', 'dpkk.satker_kode = satker.kode_satker','left outer')
                ->join('kawasan', 'dpkk.kk_reg = kawasan.reg_kk','left outer')
                ->join('fungsi_kk', 'kawasan.fungsi_kk_id = fungsi_kk.id_fungsi_kk','left outer')
                ->join('users as UI', 'dpkk.user_input = UI.id_user','left outer')
                ->limit(1)->get_where("dpkk", $where);
        if($query->num_rows() > 0){
            $data['record'] = $query->row();
        } else {
            $data['record'] = array();
        }
        
        $data['dataFungsiKK'] = $this->m_referensi->GetFungsiKK();
        $data['dataProv'] = $this->m_referensi->GetAllProvinsi();
        $data['dataSatker'] = $this->m_referensi->GetSatker();

        $this->load->view('dpkk/resume_data.php',$data);
    }

    public function unduhresume() {
        $fungsi_kk_id = $this->input->post('fungsi_kk_id');
        $prov_id = $this->input->post('prov_id');
        $satker_kode = $this->input->post('satker_kode');
        $kk_reg = $this->input->post('kk_reg');
        $data['judul'] = 'Resume Data Daerah Penyangga Kawasan Konservasi';
        if ($this->session->sub_role == 4 ) {
            $satker_kode = $this->session->satker_kode;
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
        if ($kk_reg != '0') {
            $where['dpkk.kk_reg'] = $kk_reg;
        }
        if ($prov_id != 0) {
            $where['FIND_IN_SET('.$prov_id.',kawasan.prov_id) !='] = '0';
            //$where['kawasan.prov_id'] = $prov_id;
        } 
        $data['kk_exist'] = $kk_reg;
        $data['fungsi_exist'] = $fungsi_kk_id;
        $data['prov_exist'] = $prov_id;
        $data['satker_exist'] = $satker_kode;
        $query = $this->db->select('SUM(luas_dpkk) as luas_dpkk, SUM(CHAR_LENGTH(dpkk.desa_id) - CHAR_LENGTH(REPLACE(dpkk.desa_id, ";", "")) + 1) as jml_desa, COUNT(DISTINCT(dpkk.kk_reg)) as jml_kawasan, COUNT(DISTINCT(dpkk.satker_kode)) as jml_satker')
                ->join('satker', 'dpkk.satker_kode = satker.kode_satker','left outer')
                ->join('kawasan', 'dpkk.kk_reg = kawasan.reg_kk','left outer')
                ->join('fungsi_kk', 'kawasan.fungsi_kk_id = fungsi_kk.id_fungsi_kk','left outer')
                ->join('users as UI', 'dpkk.user_input = UI.id_user','left outer')
                ->limit(1)->get_where("dpkk", $where);
        if($query->num_rows() > 0){
            $data['record'] = $query->row();
        } else {
            $data['record'] = array();
        }
        
        $html = $this->load->view('dpkk/unduh_resume_data',$data,true);
        $pdfFileName = 'Resume_Data_Daerah_Penyangga_KK.pdf';
        $this->mpdf->SetTitle($pdfFileName);
        $this->mpdf->WriteHTML($html);
        $footer = '<div style="font-size: 7pt;"><i>';
        $footer .= 'Dicetak melalui Sistem Informasi Daerah Penyangga Kawasan Konservasi dan Kemitraan Konservasi (SIMDPKK) pada tanggal '.date('d F Y');
        $footer .= '</i></div>';
        $file = 'Resume_Data_Daerah_Penyangga_KK.pdf';
        header("Content-Disposition: attachment; filename='".$file."'");
        $this->mpdf->SetHTMLFooter($footer);
        $this->mpdf->Output($pdfFileName,'I');
        exit();
    }

    public function ekspor() {
        define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        
        $fungsi_kk_id = $this->input->post('fungsi_kk_id');
        $prov_id = $this->input->post('prov_id');
        $satker_kode = $this->input->post('satker_kode');
        $kk_reg = $this->input->post('kk_reg');
        $judul = '';
        if ($this->session->sub_role == 4 ) {
            $satker_kode = $this->session->satker_kode;
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
        $where = array();
        if ($fungsi_kk_id != 0) {
            $where['fungsi_kk_id'] = $fungsi_kk_id;
        }
        
        if ($satker_kode != 0) {
            $where['kawasan.satker_kode'] = $satker_kode;
        }
        if ($kk_reg != '0') {
            $where['dpkk.kk_reg'] = $kk_reg;
        }
        if ($prov_id != 0) {
            $where['FIND_IN_SET('.$prov_id.',kawasan.prov_id) !='] = '0';
            //$where['kawasan.prov_id'] = $prov_id;
        } 
        $query = $this->db->select('dpkk.*, fungsi_kk.nama_fungsi, fungsi_kk.short_name, satker.nama_satker, UI.nama_user, kawasan.nama_kk')
                ->join('satker', 'dpkk.satker_kode = satker.kode_satker','left outer')
                ->join('kawasan', 'dpkk.kk_reg = kawasan.reg_kk','left outer')
                ->join('fungsi_kk', 'kawasan.fungsi_kk_id = fungsi_kk.id_fungsi_kk','left outer')
                ->join('users as UI', 'dpkk.user_input = UI.id_user','left outer')
                ->group_by('id_dpkk')
                ->order_by('id_dpkk', 'DESC')
                ->get_where("dpkk", $where);

        $filename = 'assets/template/ekspor/dpkk.xls';
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        
        $objPHPExcel = $objReader->load($filename);
        //$objPHPExcel->getActiveSheet()->setCellValue('C4', $judul);
        $baseRow = 7;
        //GET DATA
        $data = $query->result();
        $no=1;
        foreach($data as $r => $dataRow) {
            $row = $baseRow;
            
            $arr_desa = $this->getdatadesaekspor($dataRow->desa_id);
            $jml_desa = count($arr_desa);
            $i=0;
            //echo $jml_desa.'<br>';
            $endmerge = intval($row)+intval($jml_desa)-1;
            $objPHPExcel->getActiveSheet()->mergeCells("C".($row).":C".($endmerge));
            $objPHPExcel->getActiveSheet()->mergeCells("D".($row).":D".($endmerge));
            $objPHPExcel->getActiveSheet()->mergeCells("H".($row).":H".($endmerge));
            $objPHPExcel->getActiveSheet()->mergeCells("I".($row).":I".($endmerge));
            $objPHPExcel->getActiveSheet()->mergeCells("J".($row).":J".($endmerge));
            $objPHPExcel->getActiveSheet()->mergeCells("K".($row).":K".($endmerge));
            foreach ($arr_desa as $key => $value) {
                //print_r($arr_desa[$i]);
                $fix_row = $row + $key;

                //echo $fix_row.' '.$arr_desa[$key]['nama_desa'].' ';
                //echo $dataRow->nama_satker.'<br>';
                
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$fix_row, $no)
                                              ->setCellValue('C'.$fix_row, $dataRow->nama_satker)
                                              ->setCellValue('D'.$fix_row, $dataRow->short_name.' '.$dataRow->nama_kk)
                                              ->setCellValue('E'.$fix_row, $arr_desa[$key]['nama_kab_kota'])
                                              ->setCellValue('F'.$fix_row, $arr_desa[$key]['nama_kec'])
                                              ->setCellValue('G'.$fix_row, $arr_desa[$key]['nama_desa'])
                                              ->setCellValue('H'.$fix_row, $this->getdatastatuskwsekspor($dataRow->status_kawasan))
                                              ->setCellValue('I'.$fix_row, $dataRow->no_sk_dpkk)
                                              ->setCellValue('J'.$fix_row, $dataRow->luas_dpkk)
                                              ->setCellValue('K'.$fix_row, $dataRow->keterangan);
                if(++$i === $jml_desa) {
                    $baseRow = $fix_row + 1;
                }
                $no++;
            }

            
        }
        //$objPHPExcel->getActiveSheet()->removeRow($baseRow-1,1);
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="data_daerah_penyangga_'.date('dmY').'.xls"');
        
        // If you're serving to IE over SSL, then the following may be needed
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        //$objWriter->save(str_replace('.php', '.xls', __FILE__));
        $objWriter->save('php://output');
        exit;
    }

    public function add() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $data['judul'] = "Tambah Data Daerah Penyangga Kawasan Konservasi";
        if ($this->session->sub_role == 4) {
            $data['dataKK'] = $this->m_referensi->GetKKSatker($this->session->satker_kode);
            $data['dataSatker'] = $this->m_referensi->GetDetailSatker($this->session->satker_kode);
        } else {
            $data['dataKK'] = $this->m_referensi->GetAllKK();
            $data['dataSatker'] = $this->m_referensi->GetSatker();
        }
        $data['dataRefStatusKawasan'] = $this->m_referensi->GetReferensi('status_kawasan');
        $data['dataProv'] = $this->m_referensi->GetAllProvinsi();
        $this->load->view('dpkk/form_create', $data);
    }

    public function insert() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $now = date("Y-m-d H:i:s");

        $c_desa = count($this->input->post('desa_id[]'));
        if ($c_desa == 0) {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Desa harus diisi minimal 1. Data Kelompok Masyarakat gagal dibuat.')));
        } else {
            
            
            //set status kawasan 
            $c_status = count($this->input->post('status_kawasan[]'));
            $status_kawasan = "";
            for ($i=0; $i < $c_status; $i++) { 
                $x=$c_status-1;
                $status_kawasan .= $this->input->post('status_kawasan['.$i.']');
                if ($i != $x) {
                    $status_kawasan .= ";";
                }
            }

            //set Desa 
            $desa_id = "";
            for ($a=0; $a < $c_desa; $a++) { 
                $y=$c_desa-1;
                $desa_id .= $this->input->post('desa_id['.$a.']');
                if ($a != $y) {
                    $desa_id .= ";";
                }
            }

            $data = array('satker_kode'=>$this->input->post('satker_kode'),
                          'kk_reg'=>$this->input->post('kk_reg'),
                          'desa_id'=>$desa_id,
                          'status_kawasan'=>$status_kawasan,
                          'no_sk_dpkk'=>$this->input->post('no_sk_dpkk'),
                          'luas_dpkk'=>$this->input->post('luas_dpkk'),
                          'keterangan'=>$this->input->post('keterangan'),
                          'created_at'=>$now,
                          'updated_at'=>$now,
                          'user_input'=>$this->session->user_id);
            //upload file
            $config1['upload_path']          = './assets/filedaerahpenyangga/';
            $config1['allowed_types']        = 'pdf';
            $this->load->library('upload', $config1);
            $this->upload->initialize($config1);
            if($this->upload->do_upload('fileskpenetapan')){
                $file_name = $this->upload->data('file_name');
                $data['file_sk_dpkk'] = $file_name;
            }
            //upload file
            $config2['upload_path']          = './assets/filedaerahpenyangga/';
            $config2['allowed_types']        = 'kml|kmz';
            $this->load->library('upload', $config2);
            $this->upload->initialize($config2);
            if($this->upload->do_upload('filepeta')){
                $file_name = $this->upload->data('file_name');
                $data['file_peta'] = $file_name;
            }
            $insert = $this->db->set($data)->insert('dpkk');
            
            if($insert){
                die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Daerah Penyangga KK berhasil dibuat.')));
                //return true;
            } else {
                die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Daerah Penyangga KK gagal dibuat.')));
                //return false;
            }
        }
            
    }

    public function edit($id) {
        $data['judul'] = "Ubah Data Daerah Penyangga Kawasan Konservasi";
        $query = $this->db->from('dpkk')
                ->join('kawasan', 'dpkk.kk_reg = kawasan.reg_kk','left outer')
                ->join('fungsi_kk', 'kawasan.fungsi_kk_id = fungsi_kk.id_fungsi_kk','left outer')
                ->where('id_dpkk', $id)
                ->limit(1)
                ->get();
        if($query->num_rows() > 0){
            $row = $query->row();
            $data['record'] = $row;
            $data['recordDaerah'] = $this->m_referensi->GetDesaKelompok($row->desa_id);
            $data['recordSelectedDesa'] = $this->m_referensi->GetSelectedDesaKelompok($row->desa_id);
            $data['recordSelectedReff'] = $this->m_referensi->GetReffSelected('status_kawasan',$row->status_kawasan);
        } else {
            $data['record'] = array();
            $data['recordDaerah'] = array();
            $data['recordSelectedDesa'] = array();
            $data['recordSelectedReff'] = array();
        }
        if ($this->session->sub_role == 4) {
            $data['dataKK'] = $this->m_referensi->GetKKSatker($this->session->satker_kode);
            $data['dataSatker'] = $this->m_referensi->GetDetailSatker($this->session->satker_kode);
        } else {
            $data['dataKK'] = $this->m_referensi->GetAllKK();
            $data['dataSatker'] = $this->m_referensi->GetSatker();
        }
        $data['dataRefStatusKawasan'] = $this->getdatareffjson('status_kawasan');
        $data['dataProv'] = $this->m_referensi->GetAllProvinsi();
        
        $this->load->view('dpkk/form_edit', $data);
    }

    public function detail($id) {
        $data['judul'] = "Detail Data Daerah Penyangga Kawasan Konservasi";
        $query = $this->db->select('dpkk.*, short_name, nama_satker, nama_kk, nama_user, dpkk.updated_at as last_update')
                ->from('dpkk')
                ->join('satker', 'dpkk.satker_kode = satker.kode_satker','left outer')
                ->join('kawasan', 'dpkk.kk_reg = kawasan.reg_kk','left outer')
                ->join('fungsi_kk', 'kawasan.fungsi_kk_id = fungsi_kk.id_fungsi_kk','left outer')
                ->join('users', 'dpkk.user_input = users.id_user','left outer')
                ->where('id_dpkk', $id)
                ->limit(1)
                ->get();
        if($query->num_rows() > 0){
            $row = $query->row();
            $data['record'] = $row;
        } else {
            $data['record'] = array();
        }
        $this->load->view('dpkk/form_detail', $data);
    }

    public function update() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $now = date("Y-m-d H:i:s");

        $c_desa = count($this->input->post('desa_id[]'));
        if ($c_desa == 0) {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Desa harus diisi minimal 1. Data Kelompok Masyarakat gagal dibuat.')));
        } else {
            
            
            //set status kawasan 
            $c_status = count($this->input->post('status_kawasan[]'));
            $status_kawasan = "";
            for ($i=0; $i < $c_status; $i++) { 
                $x=$c_status-1;
                $status_kawasan .= $this->input->post('status_kawasan['.$i.']');
                if ($i != $x) {
                    $status_kawasan .= ";";
                }
            }

            //set Desa 
            $desa_id = "";
            for ($a=0; $a < $c_desa; $a++) { 
                $y=$c_desa-1;
                $desa_id .= $this->input->post('desa_id['.$a.']');
                if ($a != $y) {
                    $desa_id .= ";";
                }
            }

            $data = array('satker_kode'=>$this->input->post('satker_kode'),
                          'kk_reg'=>$this->input->post('kk_reg'),
                          'desa_id'=>$desa_id,
                          'status_kawasan'=>$status_kawasan,
                          'no_sk_dpkk'=>$this->input->post('no_sk_dpkk'),
                          'luas_dpkk'=>$this->input->post('luas_dpkk'),
                          'keterangan'=>$this->input->post('keterangan'),
                          'created_at'=>$now,
                          'updated_at'=>$now,
                          'user_input'=>$this->session->user_id);
            //upload file
            $config1['upload_path']          = './assets/filedaerahpenyangga/';
            $config1['allowed_types']        = 'pdf';
            $this->load->library('upload', $config1);
            $this->upload->initialize($config1);
            if($this->upload->do_upload('fileskpenetapan')){
                $file_name = $this->upload->data('file_name');
                $data['file_sk_dpkk'] = $file_name;
            }
            //upload file
            $config2['upload_path']          = './assets/filedaerahpenyangga/';
            $config2['allowed_types']        = 'kml|kmz';
            $this->load->library('upload', $config2);
            $this->upload->initialize($config2);
            if($this->upload->do_upload('filepeta')){
                $file_name = $this->upload->data('file_name');
                $data['file_peta'] = $file_name;
            }
            $update = $this->db->where('id_dpkk', $this->input->post('id_dpkk'))
                            ->update("dpkk", $data);
            
            if($update){
                die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Daerah Penyangga KK berhasil disimpan.')));
                //return true;
            } else {
                die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Daerah Penyangga KK gagal disimpan.')));
                //return false;
            }
        }

    }

    
    public function delete() {
        $id_data= $this->input->post('id');
        $query = $this->db->where('id_dpkk', $id_data)->get("dpkk");
        $row = $query->row();
        $file1 = $row->file_sk_dpkk;
        $file2 = $row->file_peta;
        if ($file1 != "") {
            unlink('./assets/filedaerahpenyangga/'.$file1);
        }
        if ($file2 != "") {
            unlink('./assets/filedaerahpenyangga/'.$file2);
        }
        $delete_data = $this->db->where("id_dpkk", $id_data)->delete("dpkk");
        if($delete_data){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data Daerah Penyangga Kawasan Konservasi berhasil dihapus.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data Daerah Penyangga Kawasan Konservasi gagal dihapus.')));
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

    public function getdatastatuskwsekspor($value) {
        $arr_status = explode(';', $value);
        
        $val_status = "";
        $x = count($arr_status);
        if ($x > 1) {
            for ($i=0; $i < $x; $i++) { 
                $query = $this->db->select('*')
                    ->where(array('id_reference'=>$arr_status[$i]))->get("ref_status_kawasan");
                $record = $query->row();
                $val_status .= $record->detail_1;
                if ($i != $x) {
                    $val_status .= ", ";
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
                
        return $val_status;
    }

    public function getdatadesaview($value) {
        $arr_desa = explode(';', $value);
        
        $val_desa = "";
        $x = count($arr_desa);
        if ($x > 1) {
            for ($i=0; $i < $x; $i++) { 
                $query = $this->db->select('*')
                    ->where(array('id_desa'=>$arr_desa[$i]))->get("adm_daerah");
                $record = $query->row();
                $val_desa .= "- ".$record->nama_desa;
                if ($i != $x) {
                    $val_desa .= "<br> ";
                }
            }
        } else {
            if ($value == 0 || $value == '' || $value == NULL) {
                $val_desa .= '***Data Kosong***';
            } else {
                $query = $this->db->select('*')
                    ->where(array('id_desa'=>$arr_desa[0]))->get("adm_daerah");
                $record = $query->row();
                $val_desa .= $record->nama_desa;
            }
        }
                
        echo $val_desa;
    }

    public function getdatadesaekspor($value) {
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

    public function getdatakk() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $id = $this->input->get('id');
        $result = $this->m_referensi->GetKKSatkerKelompok($id);
        $main = array();
        $list = array('reg_kk' => 'id', 'nama_kk' => 'text');
        foreach ($result as $index => $item){ 
            foreach ($item as $key => $value) {
                $main[$index][$list[$key]] = $value; 
            }
        }
        die(json_encode($main));
    }

    public function getdataprov() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $result = $this->m_referensi->GetAllProvinsi();
        $main = array();
        $list = array('id_prov' => 'id', 'nama_prov' => 'text');
        foreach ($result as $index => $item){ 
            foreach ($item as $key => $value) {
                $main[$index][$list[$key]] = $value; 
            }
        }
        die(json_encode($main));
    }

    public function getdatakabkota() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $id = $this->input->get('id');
        $result = $this->m_referensi->GetAllKabKota($id);
        $main = array();
        $list = array('id_kab_kota' => 'id', 'nama_kab_kota' => 'text');
        foreach ($result as $index => $item){ 
            foreach ($item as $key => $value) {
                $main[$index][$list[$key]] = $value; 
            }
        }
        die(json_encode($main));
    }

    public function getdatakec() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $id = $this->input->get('id');
        $result = $this->m_referensi->GetAllKec($id);
        $main = array();
        $list = array('id_kec' => 'id', 'nama_kec' => 'text');
        foreach ($result as $index => $item){ 
            foreach ($item as $key => $value) {
                $main[$index][$list[$key]] = $value; 
            }
        }
        die(json_encode($main));
    }

    public function getdatadesa() {
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $id = $this->input->get('id');
        $result = $this->m_referensi->GetAllDesa($id);
        $main = array();
        $list = array('id_desa' => 'id', 'nama_desa' => 'text');
        foreach ($result as $index => $item){ 
            foreach ($item as $key => $value) {
                $main[$index][$list[$key]] = $value; 
            }
        }
        die(json_encode($main));
    }
}
