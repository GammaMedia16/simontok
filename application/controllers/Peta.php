<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Peta extends CI_Controller{
    //put your code here
    public function __construct()
    {
        parent::__construct();
        $this->load->library('maps');
        $this->load->model('m_referensi','m_referensi');
    }    

    public function createkmldpkk($data)
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $xmlString = '<?xml version="1.0" encoding="UTF-8"?>
          <kml xmlns = "http://earth.google.com/kml/2.1">
            <Document>
            <visibility>1</visibility>';
        foreach ($data as $row) {  
          if (file_exists('assets/filedaerahpenyangga/'.$row->file_peta)) {
            $xmlString .= '
                          <NetworkLink>
                            <name>'.$row->nama_kk.'</name>
                            <Link>
                              <href>'.base_url('assets/filedaerahpenyangga/'.$row->file_peta).'</href>
                            </Link>
                          </NetworkLink>';
          }
          if (isset($_SESSION['roles_id']) && $_SESSION['roles_id'] == 2) {
              if (file_exists('assets/filekawasan/'.$row->kk_reg.'.kml')) {
                $xmlString .= '
                              <NetworkLink>
                                <name>'.$row->nama_kk.'</name>
                                <Link>
                                  <href>'.base_url('assets/filekawasan/'.$row->kk_reg.'.kml').'</href>
                                </Link>
                              </NetworkLink>';
              }
          }
              
             
        }

        $xmlString .= '     
            </Document>
        </kml>';

        $dom = new DOMDocument;
        $dom->formatOutput = TRUE;
        $dom->loadXML($xmlString);
        //Save XML as a file
        $dom->save('assets/filedaerahpenyangga/filter_data.kml');
    }

    public function createkmlkemkon($data)
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $xmlString = '<?xml version="1.0" encoding="UTF-8"?>
          <kml xmlns = "http://earth.google.com/kml/2.1">
            <Document>
            <visibility>1</visibility>';
        foreach ($data as $row) {   
          if (file_exists('assets/filekemitraankonservasi/'.$row->file_peta)) {
            $xmlString .= '
                          <NetworkLink>
                            <name>'.$row->nama_kk.'</name>
                            
                            <description>'.$row->judul_pks.'</description>
                            <Link>
                              <href>'.base_url('assets/filekemitraankonservasi/'.$row->file_peta).'</href>
                            </Link>
                          </NetworkLink>';
          }
          if (isset($_SESSION['roles_id']) && $_SESSION['roles_id'] == 2) {
              if (file_exists('assets/filekawasan/'.$row->kk_reg.'.kml')) {
                $xmlString .= '
                              <NetworkLink>
                                <name>'.$row->nama_kk.'</name>
                                <Link>
                                  <href>'.base_url('assets/filekawasan/'.$row->kk_reg.'.kml').'</href>
                                </Link>
                              </NetworkLink>';
              }
          }
        }

        $xmlString .= '     
            </Document>
        </kml>';

        $dom = new DOMDocument;
        $dom->formatOutput = TRUE;
        $dom->loadXML($xmlString);
        //Save XML as a file
        $dom->save('assets/filekemitraankonservasi/filter_data.kml');
    }
    
    

    public function index() {
    CheckThenRedirect($_SESSION['roles_id'] != 2, base_url());
        $data['judul'] = 'Peta Data Pemberdayaan Masyarakat di dalam dan sekitar Kawasan Konservasi';
        $data['tahun_judul'] = '';
        /*CONFIG PETA*/
        $config['map_height'] = '500px';
        //$config['zoom'] = 11.25;

        /*GET DATA PETA*/
        $cek_dpkk = $this->input->post('cek_dpkk');
        $cek_pdskk = $this->input->post('cek_pdskk');
        $cek_kemkon = $this->input->post('cek_kemkon');

        $fungsi_kk_id = $this->input->post('fungsi_kk_id');
        $prov_id = $this->input->post('prov_id');
        $tujuan_id = $this->input->post('tujuan_id');
        $aktivitas_pemanfaatan = $this->input->post('aktivitas_pemanfaatan');
        $satker_kode = $this->input->post('satker_kode');
        $tahun = $this->input->post('tahun');
        $kk_reg = $this->input->post('kk_reg');
        $data['judul'] = 'Peta Data Kemitraan Konservasi ';
        $data['tahun_judul'] = '';
        if ($this->session->sub_role == 4 ) {
            $satker_kode = $this->session->satker_kode;
        }
        if (!isset($cek_dpkk)){
            $cek_dpkk = 0;
        }
        if (!isset($cek_pdskk)){
            $cek_pdskk = 0;
        }
        if (!isset($cek_kemkon)){
            $cek_kemkon = 0;
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
            $where['kawasan.satker_kode'] = $satker_kode;
            $data['dataKK'] = $this->m_referensi->GetKKSatker($satker_kode);
        } else {
            $data['dataKK'] = $this->m_referensi->GetAllKK();
        }

        if ($prov_id != 0) {
            $where['satker.prov_id'] = $prov_id;
        } 
        
        
        $kmlLayersPeta = array();
        if ($cek_dpkk != 0) {
            $where_dpkk = array();
            

            $cek_dpkk = 1;
            if ($kk_reg != '0') {
                $where_dpkk['dpkk.kk_reg'] = $kk_reg;
            }
            if ($prov_id != 0) {
                $where_dpkk['kawasan.prov_id'] = $prov_id;
            }
            //$where_dpkk['dpkk.file_peta !='] = '';
            $where_dpkk = $where_dpkk + $where;
            $query3 = $this->db->select('dpkk.*, fungsi_kk.nama_fungsi, fungsi_kk.short_name, satker.nama_satker, UI.nama_user, kawasan.nama_kk')
                            ->join('satker', 'dpkk.satker_kode = satker.kode_satker','left outer')
                            ->join('kawasan', 'dpkk.kk_reg = kawasan.reg_kk','left outer')
                            ->join('fungsi_kk', 'kawasan.fungsi_kk_id = fungsi_kk.id_fungsi_kk','left outer')
                            ->join('users as UI', 'dpkk.user_input = UI.id_user','left outer')
                            ->group_by('id_dpkk')
                            ->order_by('id_dpkk', 'DESC')
                            ->get_where("dpkk", $where_dpkk);
            if($query3->num_rows() > 0){
                $dataDPKK = $query3->result();
                if ($query3->num_rows() <= 10) {
                    /*CREATE MARKER MAPS*/
                    $a=0;
                    foreach ($dataDPKK as $rowDPKK) {
                      $kmlkawasan = base_url('assets/filekawasan/'.$rowDPKK->kk_reg.'.kml');
                      if (!in_array($kmlkawasan, $kmlLayersPeta)) {
                        $kmlLayersPeta[] = base_url('assets/filekawasan/'.$rowDPKK->kk_reg.'.kml');
                      }
                        $kmlLayersPeta[] = base_url('assets/filedaerahpenyangga/'.$rowDPKK->file_peta);
                        $a++;
                    }
                } else {
                    $this->createkmldpkk($dataDPKK);
                    $kmlLayersPeta[] = base_url('assets/filedaerahpenyangga/filter_data.kml');
                }   
                $config['zoom'] = 'auto';
            } else {
                $dataDPKK = array();
            }
        }
        if ($cek_pdskk != 0) {
            $cek_pdskk = 1;
            $where_pdskk = array();
            if ($tahun != '0') {
                $where_pdskk['pdskk.tahun_keg'] = $tahun;
                $data['judul'] = $data['judul'].' Tahun '.$tahun;
                $data['tahun_judul'] = 'Tahun '.$tahun;
            }
            if ($kk_reg != '0') {
                $where_pdskk['pdskk.kk_reg'] = $kk_reg;
            }
            $where_pdskk = $where_pdskk + $where;
            $query1 = $this->db->select('id_pdskk, pdskk.kk_reg, foto_usaha, pdskk.satker_kode as satker_kode, kelompok_id, ket_usaha, MAX(tahun_keg) as tahun_keg, MAX(tahap_id) as tahap_id, kelompok.desa_id as desa_id, kelompok.nama_kelompok as nama_kelompok, fungsi_kk.nama_fungsi, fungsi_kk.short_name, satker.nama_satker, UI.nama_user, kawasan.nama_kk, SUM(biaya_keg) AS total_biaya,ref_jenis_usaha.detail_1 as jenis_usaha, kelompok.jml_anggota_kelompok')
                ->join('kelompok', 'pdskk.kelompok_id = kelompok.id_kelompok','left outer')
                ->join('satker', 'pdskk.satker_kode = satker.kode_satker','left outer')
                ->join('kawasan', 'pdskk.kk_reg = kawasan.reg_kk','left outer')
                ->join('fungsi_kk', 'kawasan.fungsi_kk_id = fungsi_kk.id_fungsi_kk','left outer')
                ->join('users as UI', 'pdskk.user_input = UI.id_user','left outer')
                ->join('ref_jenis_usaha', 'pdskk.usaha_id = ref_jenis_usaha.id_reference', 'left outer')
                ->group_by('kelompok_id,tahun_keg')
                ->order_by('id_pdskk,tahap_id', 'ASC')
                ->get_where("pdskk", $where_pdskk);
            if($query1->num_rows() > 0){
                $dataPDSKK = $query1->result();

                /*CREATE MARKER MAPS*/
                foreach ($dataPDSKK as $rowPDSKK) {
                    $marker = array();
                    $kmlkawasan = base_url('assets/filekawasan/'.$rowPDSKK->kk_reg.'.kml');
                    if (!in_array($kmlkawasan, $kmlLayersPeta)) {
                      $kmlLayersPeta[] = base_url('assets/filekawasan/'.$rowPDSKK->kk_reg.'.kml');
                    }
                    
                    $arr_desa = explode(';', $rowPDSKK->desa_id);
                    $val_desa = "";
                    $x = count($arr_desa);
                    if ($x >= 1) {
                        for ($i=0; $i < $x; $i++) { 
                            $query = $this->db->select('*')
                                ->where(array('id_desa'=>$arr_desa[$i]))->get("adm_daerah");
                            $rowDesa = $query->row();
                            if ($query->num_rows() > 0) {
                            if ($rowDesa->lat != '' && $rowDesa->lon != '') {
                                $marker['position'] = $rowDesa->lat.', '.$rowDesa->lon;
                                $infowindow_content = '<h5>DESA '.ucwords($rowDesa->nama_desa).'</h5>';
                                $infowindow_content .= '<h6>KEC. '.ucwords($rowDesa->nama_kec).', '.ucwords($rowDesa->nama_kab_kota).', PROV. '.ucwords($rowDesa->nama_prov).'</h6>';
                                $infowindow_content .= '<table border="0" cellspacing="3" cellpadding="3px">';
                                $infowindow_content .= '<tr><td> Nama Kelompok </td><td> : </td><td> '.$rowPDSKK->nama_kelompok.' </td></tr>';
                                $infowindow_content .= '<tr><td> Jenis Usaha </td><td> : </td><td> '.$rowPDSKK->jenis_usaha.' </td></tr>';
                                $infowindow_content .= '<tr><td> Jumlah Anggota </td><td> : </td><td> '.$rowPDSKK->jml_anggota_kelompok.' Orang </td></tr>';
                                $infowindow_content .= ' <tr><td> Unit Kawasan </td><td> : </td><td> '.$rowPDSKK->short_name.'. '.$rowPDSKK->nama_kk.' </td></tr>';
                                $infowindow_content .= '<tr><td> Satker </td><td> : </td><td> '.$rowPDSKK->nama_satker.'</td></tr>';
                                $infowindow_content .= '</table><br>';
                                $infowindow_content .= '<a target="_blank" class="btn btn-xs btn-info text-light" href="'.base_url('pemberdayaan/binadesa/detail/'.$rowPDSKK->id_pdskk).'">Detail Data</a>';
                                if ($rowPDSKK->foto_usaha != '') {
                                    $src_gambar = base_url('assets/filepembinaandesa/'.$rowPDSKK->foto_usaha);
                                    $gambar = "<center><img class=\"img-responsive\" src=\"".$src_gambar."\" style=\"padding-top:10px;max-width:200px\"></center>";
                                } else {
                                    $gambar = "***Foto Usaha Kosong***";
                                }
                                
                                
                                $infowindow_content .= '<tr><td colspan="3">'.$gambar.'</td></tr>';
                                $infowindow_content .= '</table>';
                                $marker['infowindow_content'] = $infowindow_content;
                                $marker['icon'] = base_url('assets/dist/img/marker.png');
                                $this->maps->add_marker($marker);
                            }
                            }
                        }
                    } 
                }
                
                $config['zoom'] = 'auto';
            } else {
                $dataPDSKK = array();
            }
        }
        if ($cek_kemkon != 0) {
            $where_kemkon = array();
            
            $cek_kemkon = 1;
            if ($tahun != '0') {
                $where_kemkon['kemitraan_konservasi.tgl_pks >='] = $tahun.'-01-01';
                $where_kemkon['kemitraan_konservasi.tgl_pks <='] = $tahun.'-12-31';
                $data['judul'] = $data['judul'].' Tahun '.$tahun;
                $data['tahun_judul'] = 'Tahun '.$tahun;
            }
            if ($tujuan_id != '0') {
                $where_kemkon['kemitraan_konservasi.tujuan_id'] = $tujuan_id;
            }
            if ($aktivitas_pemanfaatan != '0') {
                $where_kemkon['CONCAT(";", aktivitas_pemanfaatan, ";") like '] = '%'.$aktivitas_pemanfaatan.'%';
            }
            if ($kk_reg != '0') {
                $where_kemkon['kelompok.kk_reg'] = $kk_reg;
            }
            $where_kemkon['kemitraan_konservasi.file_peta !='] = '';
            $where_kemkon = $where_kemkon + $where;
            $query2 = $this->db->select('id_kemitraan, kelompok.kk_reg, kawasan.nama_kk, judul_pks, file_peta')
                    ->join('kelompok', 'kemitraan_konservasi.kelompok_id = kelompok.id_kelompok','left outer')
                    ->join('satker', 'kemitraan_konservasi.satker_kode = satker.kode_satker','left outer')
                    ->join('kawasan', 'kelompok.kk_reg = kawasan.reg_kk','left outer')
                    ->join('fungsi_kk', 'kawasan.fungsi_kk_id = fungsi_kk.id_fungsi_kk','left outer')
                    ->join('ref_tujuan', 'kemitraan_konservasi.tujuan_id = ref_tujuan.id_reference','left outer')
                    ->join('users as UI', 'kemitraan_konservasi.user_input = UI.id_user','left outer')
                    ->group_by('id_kemitraan')
                    ->order_by('id_kemitraan', 'DESC')
                    ->get_where("kemitraan_konservasi", $where_kemkon);
            if($query2->num_rows() > 0){
                $dataKemkon = $query2->result();
                if ($query2->num_rows() <= 10) {
                    /*CREATE MARKER MAPS*/
                    $a=0;

                    foreach ($dataKemkon as $rowKemkon) {
                      $kmlkawasan = base_url('assets/filekawasan/'.$rowKemkon->kk_reg.'.kml');
                      if (!in_array($kmlkawasan, $kmlLayersPeta)) {
                            $kmlLayersPeta[] = base_url('assets/filekawasan/'.$rowKemkon->kk_reg.'.kml');
                          }
                        $kmlLayersPeta[] = base_url('assets/filekemitraankonservasi/'.$rowKemkon->file_peta);
                        $a++;
                    }
                } else {
                    $this->createkmlkemkon($dataKemkon);
                    $kmlLayersPeta[] = base_url('assets/filekemitraankonservasi/filter_data.kml');
                }   
                $config['zoom'] = 'auto';
            } else {
                $dataKemkon = array();
            }
        }
        $config['kmlLayerURL'] = $kmlLayersPeta;
        
        $this->maps->initialize($config);
        $data['map'] = $this->maps->create_map();
        $data['cek_pdskk_exist'] = $cek_pdskk;
        $data['cek_kemkon_exist'] = $cek_kemkon;
        $data['cek_dpkk_exist'] = $cek_dpkk;

        $data['kk_exist'] = $kk_reg;
        $data['tahun_exist'] = $tahun;
        $data['fungsi_exist'] = $fungsi_kk_id;
        $data['prov_exist'] = $prov_id;
        $data['satker_exist'] = $satker_kode;
        $data['tujuan_exist'] = $tujuan_id;
        $data['aktivitas_pemanfaatan_exist'] = $aktivitas_pemanfaatan;
        /*DATA REFERENSI*/
        $data['dataFungsiKK'] = $this->m_referensi->GetFungsiKK();
        $data['dataProv'] = $this->m_referensi->GetAllProvinsi();
        $data['dataSatker'] = $this->m_referensi->GetSatker();
        $data['dataTujuan'] = $this->m_referensi->GetReferensi('tujuan');
        $data['dataAktivitas'] = $this->m_referensi->GetReferensi('aktivitas_pemanfaatan');
        $this->load->view('peta/index.php',$data);
    }

    public function user() {
        $data['judul'] = 'Peta Data Pemberdayaan Masyarakat di dalam dan sekitar Kawasan Konservasi';
        $data['tahun_judul'] = '';
        /*CONFIG PETA*/
        $config['map_height'] = '500px';
        //$config['zoom'] = 11.25;

        /*GET DATA PETA*/
        $cek_dpkk = $this->input->post('cek_dpkk');
        $cek_pdskk = $this->input->post('cek_pdskk');
        $cek_kemkon = $this->input->post('cek_kemkon');

        $fungsi_kk_id = $this->input->post('fungsi_kk_id');
        $prov_id = $this->input->post('prov_id');
        $tujuan_id = $this->input->post('tujuan_id');
        $aktivitas_pemanfaatan = $this->input->post('aktivitas_pemanfaatan');
        $satker_kode = $this->input->post('satker_kode');
        $tahun = $this->input->post('tahun');
        $kk_reg = $this->input->post('kk_reg');
        $data['judul'] = 'Peta Data Kemitraan Konservasi ';
        $data['tahun_judul'] = '';
        if ($this->session->sub_role == 4 ) {
            $satker_kode = $this->session->satker_kode;
        }
        if (!isset($cek_dpkk)){
            $cek_dpkk = 0;
        }
        if (!isset($cek_pdskk)){
            $cek_pdskk = 0;
        }
        if (!isset($cek_kemkon)){
            $cek_kemkon = 0;
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
            $where['kawasan.satker_kode'] = $satker_kode;
            $data['dataKK'] = $this->m_referensi->GetKKSatker($satker_kode);
        } else {
            $data['dataKK'] = $this->m_referensi->GetAllKK();
        }

        if ($prov_id != 0) {
            $where['satker.prov_id'] = $prov_id;
        } 
        
        
        $kmlLayersPeta = array();
        if ($cek_dpkk != 0) {
            $where_dpkk = array();
            

            $cek_dpkk = 1;
            if ($kk_reg != '0') {
                $where_dpkk['dpkk.kk_reg'] = $kk_reg;
            }
            if ($prov_id != 0) {
                $where_dpkk['kawasan.prov_id'] = $prov_id;
            }
            //$where_dpkk['dpkk.file_peta !='] = '';
            $where_dpkk = $where_dpkk + $where;
            $query3 = $this->db->select('dpkk.*, fungsi_kk.nama_fungsi, fungsi_kk.short_name, satker.nama_satker, UI.nama_user, kawasan.nama_kk')
                            ->join('satker', 'dpkk.satker_kode = satker.kode_satker','left outer')
                            ->join('kawasan', 'dpkk.kk_reg = kawasan.reg_kk','left outer')
                            ->join('fungsi_kk', 'kawasan.fungsi_kk_id = fungsi_kk.id_fungsi_kk','left outer')
                            ->join('users as UI', 'dpkk.user_input = UI.id_user','left outer')
                            ->group_by('id_dpkk')
                            ->order_by('id_dpkk', 'DESC')
                            ->get_where("dpkk", $where_dpkk);
            if($query3->num_rows() > 0){
                $dataDPKK = $query3->result();
                if ($query3->num_rows() <= 10) {
                    /*CREATE MARKER MAPS*/
                    $a=0;
                    foreach ($dataDPKK as $rowDPKK) {
                      /*$kmlkawasan = base_url('assets/filekawasan/'.$rowDPKK->kk_reg.'.kml');
                      if (!in_array($kmlkawasan, $kmlLayersPeta)) {
                        $kmlLayersPeta[] = base_url('assets/filekawasan/'.$rowDPKK->kk_reg.'.kml');
                      }*/
                        $kmlLayersPeta[] = base_url('assets/filedaerahpenyangga/'.$rowDPKK->file_peta);
                        $a++;
                    }
                } else {
                    $this->createkmldpkk($dataDPKK);
                    $kmlLayersPeta[] = base_url('assets/filedaerahpenyangga/filter_data.kml');
                }   
                
            } else {
                $dataDPKK = array();
            }
        }
        if ($cek_pdskk != 0) {
            $cek_pdskk = 1;
            $where_pdskk = array();
            if ($tahun != '0') {
                $where_pdskk['pdskk.tahun_keg'] = $tahun;
                $data['judul'] = $data['judul'].' Tahun '.$tahun;
                $data['tahun_judul'] = 'Tahun '.$tahun;
            }
            if ($kk_reg != '0') {
                $where_pdskk['pdskk.kk_reg'] = $kk_reg;
            }
            $where_pdskk = $where_pdskk + $where;
            $query1 = $this->db->select('id_pdskk, pdskk.kk_reg, foto_usaha, pdskk.satker_kode as satker_kode, kelompok_id, ket_usaha, MAX(tahun_keg) as tahun_keg, MAX(tahap_id) as tahap_id, kelompok.desa_id as desa_id, kelompok.nama_kelompok as nama_kelompok, fungsi_kk.nama_fungsi, fungsi_kk.short_name, satker.nama_satker, UI.nama_user, kawasan.nama_kk, SUM(biaya_keg) AS total_biaya,ref_jenis_usaha.detail_1 as jenis_usaha, kelompok.jml_anggota_kelompok')
                ->join('kelompok', 'pdskk.kelompok_id = kelompok.id_kelompok','left outer')
                ->join('satker', 'pdskk.satker_kode = satker.kode_satker','left outer')
                ->join('kawasan', 'pdskk.kk_reg = kawasan.reg_kk','left outer')
                ->join('fungsi_kk', 'kawasan.fungsi_kk_id = fungsi_kk.id_fungsi_kk','left outer')
                ->join('users as UI', 'pdskk.user_input = UI.id_user','left outer')
                ->join('ref_jenis_usaha', 'pdskk.usaha_id = ref_jenis_usaha.id_reference', 'left outer')
                ->group_by('kelompok_id,tahun_keg')
                ->order_by('id_pdskk,tahap_id', 'ASC')
                ->get_where("pdskk", $where_pdskk);
            if($query1->num_rows() > 0){
                $dataPDSKK = $query1->result();

                /*CREATE MARKER MAPS*/
                foreach ($dataPDSKK as $rowPDSKK) {
                    $marker = array();
                    /*$kmlkawasan = base_url('assets/filekawasan/'.$rowPDSKK->kk_reg.'.kml');
                    if (!in_array($kmlkawasan, $kmlLayersPeta)) {
                      $kmlLayersPeta[] = base_url('assets/filekawasan/'.$rowPDSKK->kk_reg.'.kml');
                    }*/
                    
                    $arr_desa = explode(';', $rowPDSKK->desa_id);
                    $val_desa = "";
                    $x = count($arr_desa);
                    if ($x >= 1) {
                        for ($i=0; $i < $x; $i++) { 
                            $query = $this->db->select('*')
                                ->where(array('id_desa'=>$arr_desa[$i]))->get("adm_daerah");
                            $rowDesa = $query->row();
                            if ($query->num_rows() > 0) {
                            if ($rowDesa->lat != '' && $rowDesa->lon != '') {
                                $marker['position'] = $rowDesa->lat.', '.$rowDesa->lon;
                                $infowindow_content = '<h5>DESA '.ucwords($rowDesa->nama_desa).'</h5>';
                                $infowindow_content .= '<h6>KEC. '.ucwords($rowDesa->nama_kec).', '.ucwords($rowDesa->nama_kab_kota).', PROV. '.ucwords($rowDesa->nama_prov).'</h6>';
                                $infowindow_content .= '<table border="0" cellspacing="3" cellpadding="3px">';
                                $infowindow_content .= '<tr><td> Nama Kelompok </td><td> : </td><td> '.$rowPDSKK->nama_kelompok.' </td></tr>';
                                $infowindow_content .= '<tr><td> Jenis Usaha </td><td> : </td><td> '.$rowPDSKK->jenis_usaha.' </td></tr>';
                                $infowindow_content .= '<tr><td> Jumlah Anggota </td><td> : </td><td> '.$rowPDSKK->jml_anggota_kelompok.' Orang </td></tr>';
                                $infowindow_content .= ' <tr><td> Unit Kawasan </td><td> : </td><td> '.$rowPDSKK->short_name.'. '.$rowPDSKK->nama_kk.' </td></tr>';
                                $infowindow_content .= '<tr><td> Satker </td><td> : </td><td> '.$rowPDSKK->nama_satker.'</td></tr>';
                                if ($rowPDSKK->foto_usaha != '') {
                                    $src_gambar = base_url('assets/filepembinaandesa/'.$rowPDSKK->foto_usaha);
                                    $gambar = "<center><img class=\"img-responsive\" src=\"".$src_gambar."\" style=\"padding-top:10px;max-width:200px\"></center>";
                                } else {
                                    $gambar = "***Foto Usaha Kosong***";
                                }
                                
                                
                                $infowindow_content .= '<tr><td colspan="3">'.$gambar.'</td></tr>';
                                $infowindow_content .= '</table>';
                                $marker['infowindow_content'] = $infowindow_content;
                                $marker['icon'] = base_url('assets/dist/img/marker.png');
                                $this->maps->add_marker($marker);
                            }
                            }
                        }
                    }
                }
                

            } else {
                $dataPDSKK = array();
            }
        }
        if ($cek_kemkon != 0) {
            $where_kemkon = array();
            
            $cek_kemkon = 1;
            if ($tahun != '0') {
                $where_kemkon['kemitraan_konservasi.tgl_pks >='] = $tahun.'-01-01';
                $where_kemkon['kemitraan_konservasi.tgl_pks <='] = $tahun.'-12-31';
                $data['judul'] = $data['judul'].' Tahun '.$tahun;
                $data['tahun_judul'] = 'Tahun '.$tahun;
            }
            if ($tujuan_id != '0') {
                $where_kemkon['kemitraan_konservasi.tujuan_id'] = $tujuan_id;
            }
            if ($aktivitas_pemanfaatan != '0') {
                $where_kemkon['CONCAT(";", aktivitas_pemanfaatan, ";") like '] = '%'.$aktivitas_pemanfaatan.'%';
            }
            if ($kk_reg != '0') {
                $where_kemkon['kelompok.kk_reg'] = $kk_reg;
            }
            $where_kemkon['kemitraan_konservasi.file_peta !='] = '';
            $where_kemkon = $where_kemkon + $where;
            $query2 = $this->db->select('id_kemitraan, kelompok.kk_reg, kawasan.nama_kk, judul_pks, file_peta')
                    ->join('kelompok', 'kemitraan_konservasi.kelompok_id = kelompok.id_kelompok','left outer')
                    ->join('satker', 'kemitraan_konservasi.satker_kode = satker.kode_satker','left outer')
                    ->join('kawasan', 'kelompok.kk_reg = kawasan.reg_kk','left outer')
                    ->join('fungsi_kk', 'kawasan.fungsi_kk_id = fungsi_kk.id_fungsi_kk','left outer')
                    ->join('ref_tujuan', 'kemitraan_konservasi.tujuan_id = ref_tujuan.id_reference','left outer')
                    ->join('users as UI', 'kemitraan_konservasi.user_input = UI.id_user','left outer')
                    ->group_by('id_kemitraan')
                    ->order_by('id_kemitraan', 'DESC')
                    ->get_where("kemitraan_konservasi", $where_kemkon);
            if($query2->num_rows() > 0){
                $dataKemkon = $query2->result();
                if ($query2->num_rows() <= 10) {
                    /*CREATE MARKER MAPS*/
                    $a=0;

                    foreach ($dataKemkon as $rowKemkon) {
                      /*$kmlkawasan = base_url('assets/filekawasan/'.$rowKemkon->kk_reg.'.kml');
                      if (!in_array($kmlkawasan, $kmlLayersPeta)) {
                            $kmlLayersPeta[] = base_url('assets/filekawasan/'.$rowKemkon->kk_reg.'.kml');
                          }*/
                        $kmlLayersPeta[] = base_url('assets/filekemitraankonservasi/'.$rowKemkon->file_peta);
                        $a++;
                    }
                } else {
                    $this->createkmlkemkon($dataKemkon);
                    $kmlLayersPeta[] = base_url('assets/filekemitraankonservasi/filter_data.kml');
                }   
                
            } else {
                $dataKemkon = array();
            }
        }
        $config['kmlLayerURL'] = $kmlLayersPeta;
        //$config['zoom'] = 'auto';
        $this->maps->initialize($config);
        $data['map'] = $this->maps->create_map();
        $data['cek_pdskk_exist'] = $cek_pdskk;
        $data['cek_kemkon_exist'] = $cek_kemkon;
        $data['cek_dpkk_exist'] = $cek_dpkk;

        $data['kk_exist'] = $kk_reg;
        $data['tahun_exist'] = $tahun;
        $data['fungsi_exist'] = $fungsi_kk_id;
        $data['prov_exist'] = $prov_id;
        $data['satker_exist'] = $satker_kode;
        $data['tujuan_exist'] = $tujuan_id;
        $data['aktivitas_pemanfaatan_exist'] = $aktivitas_pemanfaatan;
        /*DATA REFERENSI*/
        $data['dataFungsiKK'] = $this->m_referensi->GetFungsiKK();
        $data['dataProv'] = $this->m_referensi->GetAllProvinsi();
        $data['dataSatker'] = $this->m_referensi->GetSatker();
        $data['dataTujuan'] = $this->m_referensi->GetReferensi('tujuan');
        $data['dataAktivitas'] = $this->m_referensi->GetReferensi('aktivitas_pemanfaatan');
        $this->load->view('peta/index.php',$data);
    }

}
