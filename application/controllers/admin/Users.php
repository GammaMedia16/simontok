<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * ***************************************************************
 * Script : 
 * Version : 
 * Date :
 * Author : Dhimas Ony P.
 * Email : dhimas205@gmail.com
 * Description : 
 * ***************************************************************
 */

/**
 * Description of Dashboard
 *
 * @author Dhimas Ony
 */
class Users extends CI_Controller{
    //put your code here
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
    }    
    
    public function index() {
        CheckThenRedirect($_SESSION['sub_role'] != 3, base_url());
        $data['judul'] = "Data Referensi - Pengguna";
        $query = $this->db->select('U.*,R.role as role, RL.role as subrole')->from('users as U')
                ->join('roles as R', 'R.id_role = U.role_id')
                ->join('roles as RL', 'RL.id_role = U.sub_role', 'left outer')
                ->where('U.role_id', 2)
                ->get();
        if($query->num_rows() > 0){
            $data['record'] = $query->result();
        } else {
            $data['record'] = array();
        }          
        $this->load->view('users/index',$data);
    }
    
    public function create() {
        CheckThenRedirect(!$_SESSION['loggedIn'], base_url());
        
        $query1 = $this->db->from('roles')->where('id_role >', '2')->get();
        if($query1->num_rows() > 0){
            $data['record1'] = $query1->result();
        } else {
            $data['record1'] = array();
        }                
        $query2 = $this->db->from('satker')->order_by('id_satker')->get();
        if($query2->num_rows() > 0){
            $data['record2'] = $query2->result();
        } else {
            $data['record2'] = array();
        }
        $this->load->view('users/form_create', $data);
    }


    public function insert() {
        CheckThenRedirect(!$_SESSION['loggedIn'], base_url());
        //$password=md5($this->input->post('new_password'));
        $password=$this->input->post('new_password');
        $data1 = array('nama_user'=>$this->input->post('nama'),
                      'role_id'=>2,
                      'sub_role'=>$this->input->post('sub_role'),
                      'gender'=>$this->input->post('gender'),
                      'username'=>$this->input->post('username'),
                      'satker_kode'=>$this->input->post('satker_kode'),
                      'password'=>$password,
                      'created_at'=>date("Y-m-d H:i:s"));
        
        $insert_user = $this->db->set($data1)->insert("users");
        $new_id_user = $this->db->insert_id();

        if($insert_user){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data User berhasil dibuat.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data User gagal dibuat.')));
            //return false;
        }

    }

    public function edit($id) {
        CheckThenRedirect(!$_SESSION['loggedIn'], base_url());
        $query = $this->db->from('users')
                ->join('satker', 'users.satker_kode = satker.kode_satker','left outer')
                ->where('users.id_user', $id)
                ->limit(1)
                ->get();
        if($query->num_rows() > 0){
            $data['record'] = $query->row();
        } else {
            $data['record'] = array();
        }

        $query = $this->db->from('roles')->where('id_role', '2')->get();;
        if($query->num_rows() > 0){
            $data['recordRoles'] = $query->result();
        } else {
            $data['recordRoles'] = array();
        }  
        $query1 = $this->db->from('roles')->where('id_role >', '2')->get();
        if($query1->num_rows() > 0){
            $data['record1'] = $query1->result();
        } else {
            $data['record1'] = array();
        }                
        $query2 = $this->db->from('satker')->get();
        if($query2->num_rows() > 0){
            $data['record2'] = $query2->result();
        } else {
            $data['record2'] = array();
        }
        $this->load->view('users/form_edit', $data);
    }

    public function update() {
        CheckThenRedirect(!$_SESSION['loggedIn'], base_url());
        $id_user = $this->input->post('id_user');
        $sub_role = $this->session->sub_role;
        if ($sub_role == 3) {
            $data1 = array('nama_user'=>$this->input->post('nama'),
                          'gender'=>$this->input->post('gender'),
                          'username'=>$this->input->post('username'),
                          'updated_at'=>date("Y-m-d H:i:s"));
        } else if ($sub_role == 4) {
            $data1 = array('nama_user'=>$this->input->post('nama'),
                          'gender'=>$this->input->post('gender'),
                          'username'=>$this->input->post('username'),
                          'updated_at'=>date("Y-m-d H:i:s"));
        }
            
        
        $update_user = $this->db->where("id_user", $id_user)->update("users", $data1);
        
        if($update_user){
            die(json_encode(array('sub_role' => $sub_role, 'status' => 'success', 'title' => 'Berhasil', 'message' => 'Data User berhasil diubah.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data User gagal diubah.')));
            //return false;
        }

    }

    public function updateuser() {
        CheckThenRedirect(!$_SESSION['loggedIn'], base_url());
        $id_user = $this->input->post('id_user');
        $data1 = array('nama_user'=>$this->input->post('nama'),
                      'gender'=>$this->input->post('gender'),
                      'username'=>$this->input->post('username'),
                      'resort_id'=>$this->input->post('resort_id'),
                      'updated_at'=>date("Y-m-d H:i:s"));
        
        $update_user = $this->db->where("id_user", $id_user)->update("users", $data1);
        
        if($update_user){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data User berhasil diubah.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data User gagal diubah.')));
            //return false;
        }

    }

    public function changepass() {
        CheckThenRedirect(!$_SESSION['loggedIn'], base_url());
        /*$password=md5($this->input->post('new_password'));
        $oldpass=md5($this->input->post('old_password'));
        */
        $password=$this->input->post('new_password');
        $oldpass=$this->input->post('old_password');
        $id_user = $this->input->post('id_user');
        $data1 = array('password'=>$password,
                      'updated_at'=>date("Y-m-d H:i:s"));
        
       
        
        if ($oldpass <> $this->input->post('oldpass')){
                die(json_encode(array('status' => 'error', 'title' => 'Peringatan', 'message' => 'Password Lama tidak cocok.')));
        } else {
            $update_pass = $this->db->where("id_user", $id_user)->update("users", $data1);
            if($update_pass){
                die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Password berhasil diubah.')));
            } else
            {
                die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Password gagal diubah.')));
            }
        }


    }

    public function delete() {
        CheckThenRedirect(!$_SESSION['loggedIn'], base_url());
        $id_user = $this->input->post('id_user');
        $delete_user = $this->db->where("id_user", $id_user)->delete("users");
        
        if($delete_user){
            die(json_encode(array('status' => 'success', 'title' => 'Berhasil', 'message' => 'Data User berhasil dihapus.')));
            //return true;
        } else {
            die(json_encode(array('status' => 'error', 'title' => 'Gagal', 'message' => 'Data User gagal dihapus.')));
            //return false;
        }

    }
    public function blank_page() { 
        CheckThenRedirect(!$_SESSION['loggedIn'], base_url());       
        $this->load->view('users/blank_page');
    }
}
