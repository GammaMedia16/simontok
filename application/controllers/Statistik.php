<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Statistik extends CI_Controller{
    //put your code here
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('m_referensi','m_referensi');
        $this->load->library('session');
    }    
    
    

    public function all() { 
        CheckThenRedirect($_SESSION['roles_id'] != 2, base_url()); 
        $data['judul'] = "Statistik";
        $tahun = $this->input->post('tahun');
        $filepagu = $this->input->post('filepagu');
        if (!isset($tahun)){
            $tahun = date("Y");
        }
        $where = array();
        $where['target_penerimaan.thn_target_penerimaan'] = $tahun;
        $qTT = $this->db->select('COALESCE(SUM(jml_target_penerimaan),0) as total_target_penerimaan',false)->get_where("target_penerimaan", $where);
        if($qTT->num_rows() > 0){
            $rTT = $qTT->row();
            $data['total_target_penerimaan'] = $rTT->total_target_penerimaan;
        } else {
            $data['total_target_penerimaan'] = 0;
        } 
        $qRT = $this->db->select('COALESCE(SUM(jml_netto),0) as total_realisasi_penerimaan',false)->join('target_penerimaan', 'realisasi_penerimaan.kode_akun_penerimaan = target_penerimaan.kode_akun_penerimaan','left outer')->get_where("realisasi_penerimaan", $where);
        if($qRT->num_rows() > 0){
            $rRT = $qRT->row();
            $data['total_realisasi_penerimaan'] = $rRT->total_realisasi_penerimaan;
        } else {
            $data['total_realisasi_penerimaan'] = 0;
        }     
        //rekap per akun
        $qAkunTerima = $this->db->select('target_penerimaan.kode_akun_penerimaan as akun, target_penerimaan.jenis_penerimaan as jenis_penerimaan, target_penerimaan.jml_target_penerimaan as jml_target_penerimaan, COALESCE(SUM(realisasi_penerimaan.jml_netto),0) as jml_realisasi_penerimaan',false)->join('target_penerimaan', 'realisasi_penerimaan.kode_akun_penerimaan = target_penerimaan.kode_akun_penerimaan','left outer')->group_by("target_penerimaan.kode_akun_penerimaan")->get_where("realisasi_penerimaan", $where);
        if($qAkunTerima->num_rows() > 0){
            $data['recordAkunTerima'] = $qAkunTerima->result();
        } else {
            $data['recordAkunTerima'] = array();
        }   
        //pagu anggaran    
        $qPagu = $this->db->select('COALESCE(SUM(pagu),0) as total_pagu',false)->join('file_pagu', 'pagu_anggaran.file_id = file_pagu.id_file')->where("pagu_anggaran.thang", $tahun)->where("pagu_anggaran.level", 7)->where("file_pagu.file_aktif", 1)->get("pagu_anggaran");
        if($qPagu->num_rows() > 0){
            $rPagu = $qPagu->row();
            $data['total_pagu'] = $rPagu->total_pagu;
        } else {
            $data['total_pagu'] = 0;
        } 
        $qPengeluaran = $this->db->select('(SELECT COALESCE(SUM(pagu_anggaran.pagu),0) FROM pagu_anggaran WHERE pagu_anggaran.file_id = file_pagu.id_file AND pagu_anggaran.level = 7) AS total_pagu, COALESCE(SUM(realisasi_pagu.jml_rpagu),0) as total_realisasi_pagu',false)
                          ->join('pagu_anggaran', 'pagu_anggaran.kdindex = realisasi_pagu.kdindex','left outer')
                          ->join('file_pagu', 'pagu_anggaran.file_id = file_pagu.id_file')
                          ->where("pagu_anggaran.thang", $tahun)
                          ->where("file_pagu.file_aktif", 1)
                          ->get("realisasi_pagu");
        if($qPengeluaran->num_rows() > 0){
            $data['rPengeluaran'] = $qPengeluaran->row();
        } else {
            $data['rPengeluaran'] = array();
        }       

        $qPSah = $this->db->select('COALESCE(SUM(realisasi_sah.jml_rsah),0) as total_realisasi_sah',false)
                          ->join('pagu_anggaran', 'pagu_anggaran.kdindex = realisasi_pagu.kdindex','left outer')
                          ->join('realisasi_sah', 'realisasi_pagu.id_rpagu = realisasi_sah.rpagu_id','left outer')
                          ->join('file_pagu', 'pagu_anggaran.file_id = file_pagu.id_file')
                          ->where("pagu_anggaran.thang", $tahun)
                          ->where("realisasi_sah.flag_aksi", 1)
                          ->where("file_pagu.file_aktif", 1)
                          ->get("realisasi_pagu");
        if($qPSah->num_rows() > 0){
            $data['rPSah'] = $qPSah->row();
        } else {
            $data['rPSah'] = array();
        }     
        
        //get pagu per jurusan
        $qPJurusan = $this->db->select('COALESCE(SUM(pagu_anggaran.pagu), 0) as jumlah_pagu,pagu_anggaran.kdsoutput as kode_jurusan,jurusan.nama_jur as nama_jurusan',false)
                          ->join('file_pagu', 'pagu_anggaran.file_id = file_pagu.id_file')
                          ->join('jurusan', 'pagu_anggaran.kdsoutput = jurusan.kode_jur','left outer')
                          ->where("pagu_anggaran.thang", $tahun)
                          ->where("pagu_anggaran.kdgiat", '5034')
                          ->where("pagu_anggaran.kdoutput", '501')
                          ->where("pagu_anggaran.level", 7)
                          ->where("file_pagu.file_aktif", 1)
                          ->group_by("pagu_anggaran.kdsoutput")
                          ->get("pagu_anggaran");
        if($qPJurusan->num_rows() > 0){ 
            $resultdataPaguJurusan = $qPJurusan->result();
        } else {
            $resultdataPaguJurusan = array();
        }

        //grafik batang realisasi sah - jurusan
        $bulan = $this->input->post('bulan');
        if (!isset($bulan)){
            $bulan = 0;
        }
        $where_r = array();
        
        $where_r['pagu_anggaran.thang'] = $tahun;
        $where_r['pagu_anggaran.kdgiat'] = '5034';
        $where_r['pagu_anggaran.kdoutput'] = '501';
        $where_r['pagu_anggaran.level'] = 7;
        $where_r['realisasi_sah.flag_aksi'] = 1;
        $where_r['file_pagu.file_aktif'] = 1;
        if ($bulan != '0') {
            $where_r['realisasi_pagu.bulan'] = $bulan;
        }

        $data['bulan_exist'] = $bulan;
        $qRSJurusan = $this->db->select('COALESCE(SUM(realisasi_sah.jml_rsah),0) as total_realisasi_sah, pagu_anggaran.kdsoutput as kode_jurusan',false)
                          ->join('pagu_anggaran', 'pagu_anggaran.kdindex = realisasi_pagu.kdindex','left outer')
                          ->join('realisasi_sah', 'realisasi_pagu.id_rpagu = realisasi_sah.rpagu_id','left outer')
                          ->join('file_pagu', 'pagu_anggaran.file_id = file_pagu.id_file')
                          ->group_by("pagu_anggaran.kdsoutput")
                          ->get_where("realisasi_pagu", $where_r);

        if($qRSJurusan->num_rows() > 0){
            $resultdataRSJurusan = $qRSJurusan->result();
            $dataResultRSJurusan = [];
            foreach ($resultdataRSJurusan as $rowRSJ) {
                foreach ($resultdataPaguJurusan as $rowPJ) {
                    if ($rowPJ->kode_jurusan == $rowRSJ->kode_jurusan ) {
                        $pagu = $rowPJ->jumlah_pagu;
                        $real = $rowRSJ->total_realisasi_sah;
                        $persen = @($real/$pagu)*100;
                        $dataResultRSJurusan[] = [
                            'nama_jurusan' => $rowPJ->nama_jurusan,
                            'pagu' => $rowPJ->jumlah_pagu,
                            'realisasi' => $rowRSJ->total_realisasi_sah,
                            'persen' => number_format($persen, 2, '.', ',')
                        ];
                    }
                }
            }

            $dataRealisasiSahJurusan = json_encode($dataResultRSJurusan);
        } else {
            $dataResultRSJurusan = array();
            $dataRealisasiSahJurusan = array();
        }
        $data['dataRealisasiSahJurusan'] = $dataRealisasiSahJurusan;
        $data['dataResultRSJurusan'] = $dataResultRSJurusan;
        $data['tahun_exist'] = $tahun;

        $this->load->view('statistik/index_admin', $data);
    }

    public function pegawai()
    {
        CheckThenRedirect($_SESSION['sub_role'] != 4, base_url());

        $tahun = $this->input->post('tahun');
        if (!isset($tahun)){
            $tahun = date('Y');
        }
        $where = array();
        /*if ($tahun != date('Y')) {
            $where['kondisi_id'] = $kondisi;
        }*/

        $qPegawai = $this->db->select('id_user,nama_user')
                ->where(array('sub_role'=>3))->or_where(array('sub_role'=>5))->order_by('nama_user','ASC')->get("users");
        $rPegawai = $qPegawai->result();
        $data['dataPegawai'] = $rPegawai;
        $data['tahun_exist'] = $tahun;

        $this->load->view('statistik/index_pegawai_bulanan', $data);
    }

    public function countpegawaibulanan($tahun,$id_pegawai) {
        $dari = $tahun."-01-01 00:00:01";
        $sampai = $tahun."-12-31 23:59:59";
        $petugas_id = $id_pegawai;
        $qperpeg = $this->db->select('MONTH(date_input_rpagu) as bln, COUNT(*) as jml',false)
                          ->join('realisasi_pagu', 'pagu_anggaran.kdindex = realisasi_pagu.kdindex','left outer')
                          ->join('file_pagu', 'pagu_anggaran.file_id = file_pagu.id_file')
                          ->where(array('realisasi_pagu.user_input_rpagu' => $petugas_id,'file_pagu.file_aktif' => 1,'date_input_rpagu >=' => $dari,'date_input_rpagu <=' => $sampai))
                          ->group_by('bln')
                          ->get("pagu_anggaran");
        if ($qperpeg->num_rows() > 0) {
            $arr_bln_ok = $qperpeg->result();
        } else {
           $arr_bln_ok = array();
        }
        $data['cRekap'] = $arr_bln_ok;
        //die(json_encode($data['cRekap']));
        return json_encode($data['cRekap']);
    }

}
