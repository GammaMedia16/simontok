<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Access extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('ion_auth');
        $this->load->model('admin/m_user','m_user');
        $this->load->model('m_api','m_api');
        $this->load->library('session');
        date_default_timezone_set('Asia/Jakarta');
        //$this->load->library('../controllers/sidak');
    }  

    public function index()
    {
        if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']){
            redirect("dashboard");
        } else {
            redirect("login");    
        }
    }
    
    public function validate() {

        $this->form_validation->set_rules('username', 'Username', 'required|min_length[5]|max_length[25]|alpha_dash');
        $this->form_validation->set_rules('userpass', 'Password', 'required');
        
        if($this->form_validation->run($this) == FALSE){
            $this->load->view('access/login');
        }
        else
        {
            $username = $this->input->post('username');
            $password = $this->input->post('userpass');
            $pass = md5($password);
            //$pass = $password;
            $ret = $this->m_user->GetUser($username,$pass);
            // $data['error'] = $ret;
            // $this->load->view('access/login',$data);
            if($ret){
                $user = $ret[0];
                if($username == $user['username'] && $pass == $user["password"]){
                    //if ($user['current'] == 0) {
                        $this->session->loggedIn = 1;
                        $this->session->loggedTime = Now();

                        ## LOGIN AS EDITOR ##
                        $this->session->user_id = $user['id_user'];
                        $this->session->username = $user['username'];
                        $this->session->namauser = $user['nama_user'];
                        $this->session->roles = $user['role'];
                        $this->session->roles_id = $user['id_role'];
                        $this->session->sub_role = $user['sub_role'];
                        $this->session->satker_kode = $user['satker_kode'];
                        $this->session->nama_satker = $user['nama_satker'];
                        $this->session->gender = $user['gender'];
                        $this->session->color = $user['colour'];
                        setcookie("gamma_media_session", "active".$user['username'], time() + 86400, "/");
                        //TOKEN API SIDAK
                        $token = $this->m_api->requesttoken();
                        $this->session->token = $token;
                        
                        if($user['username'] != ''){
                            $username = $user['username'];
                            $data_user = array('username'=>$username,
                                      'act'=>"Login",
                                      'last_update'=>date("Y-m-d H:i:s"));
                            $this->db->set($data_user)->insert("log_user");
                            redirect("dashboard");  
                        } else {
                            $this->logout();
                        }
                    /*} else {
                        $data['error'] = "Username Anda sedang Online. Silahkan Logout dahulu.";
                        $this->load->view('access/login',$data);
                    }*/
                        
                } else {
                    $data['error'] = "Username dan Password tidak cocok.";
                    $this->load->view('access/login',$data);
                    //$this->validate($data);
                    // redirect("login");
                }
            } else {
                $data['error'] = "Username atau password tidak terdaftar";
                $this->load->view('access/login',$data);
            }
            //return;
            
        }

    }

    
    public function logout(){
        
        $username = $this->session->username;
        $data_user = array('username'=>$username,
                  'act'=>"Logout",
                  'last_update'=>date("Y-m-d H:i:s"));
        $this->db->set($data_user)->insert("log_user");
        unset($_SESSION);
        unset($_COOKIE['gamma_media_session']);
        setcookie("gamma_media_session", "", time() + 86400, "/");
        session_destroy();
        redirect('dashboard');
    }
}
