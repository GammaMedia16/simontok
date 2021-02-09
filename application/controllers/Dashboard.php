<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Dashboard extends CI_Controller{
    //put your code here
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        //$this->load->library('curl');
        $this->session->resort = NULL;
        $this->session->nama_resort = NULL;
    }    
    
    public function index() {  
        CheckThenRedirect(empty($_SESSION['loggedIn']), base_url());
        $data['username'] = NULL;
        $data['nama'] = NULL;
        $data['loggedin'] = 0;
        $data['roles'] = NULL;
        $data['sub_role']   = 0;
        $data['sub_role_tambahan']   = 0;
        $data['roles_id'] = 0;
        $data['kategori_pemohon']   = 0;
        $data['id_user_sipot']  = 0;
        if ($this->session->loggedIn == 1){
            $data['username']   = $this->session->username;
            $data['nama']       = $this->session->namauser;
            $data['loggedin']   = $this->session->loggedIn;
            $data['roles']  = $this->session->roles;
            $data['roles_id']   = $this->session->roles_id;
            $data['sub_role']   = $this->session->sub_role;
            $data['sub_role_tambahan']   = $this->session->sub_role_tambahan;
            $data['kategori_pemohon']   = $this->session->kategori_pemohon;
            $id_user_sipot  = $this->session->id_user_sipot;
            $data['id_user_sipot']  = $this->session->id_user_sipot;
            $tahun = date("Y");
            $dateNow = date("Y-m-d");
            $data['tahun_exist'] = $tahun;
            
            

            $this->load->view('dashboard/admin', $data);
        } 
        
    }
    
}
