<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');


class Commons extends CI_Controller{

	public function __construct(){
		parent::__construct();
		//$this->load->model("m_commons");
	}

	public function header(){
		
		$this->load->view('design/header');
	}

	public function footer(){
		$this->load->view('design/footer');
	}

	public function penyu(){
		$data['judul'] = "Profil Konservasi Penyu";
        $this->load->view('penyu/profil_user',$data);
	}

	public function topbar(){
		$data['username'] = NULL;
		$data['nama'] = NULL;
		$data['loggedin'] = 0;
		$data['roles'] = NULL;
		$data['gender'] 	= NULL;
		$data['roles_id'] = 0;
		$data['sub_role'] = 0;
		$data['color'] = "green";
		$data['satker_kode'] 	= NULL;
        $data['nama_satker'] 	= NULL;
		if ($this->session->loggedIn == 1){
			$data['user_id'] 	= $this->session->user_id;
			$data['username'] 	= $this->session->username;
			$data['nama'] 		= $this->session->namauser;
			$data['loggedin'] 	= $this->session->loggedIn;
			$data['roles'] 	= $this->session->roles;
            $data['roles_id'] 	= $this->session->roles_id;
            $data['sub_role'] 	= $this->session->sub_role;
            $data['gender'] 	= $this->session->gender;
            $data['color'] 	= $this->session->color;
            $data['satker_kode'] 	= $this->session->satker_kode;
        	$data['nama_satker'] 	= $this->session->nama_satker;
		}

		

        /*//SIMAKSI
        $qNewSIMAKSI = $this->db->get_where('simaksi', array('status_id' => 2));
        $data['countNewSIMAKSI'] = $qNewSIMAKSI->num_rows();
        $qVerifSIMAKSI = $this->db->get_where('simaksi', array('status_id' => 3));
        $data['countVerifSIMAKSI'] = $qVerifSIMAKSI->num_rows();
        $qSIMAKSI1 = $this->db->get_where('simaksi', array('status_id' => 4));
        $data['countTerbitSIMAKSI'] = $qSIMAKSI1->num_rows();
        $qSIMAKSI2 = $this->db->get_where('simaksi', array('status_id' => 5));
        $data['countTolakSIMAKSI'] = $qSIMAKSI2->num_rows();

        //data_monitoring
        $qNew = $this->db->get_where('data_monitoring', array('flag_id' => 1));
        $data['countNew'] = $qNew->num_rows();
        $qValid = $this->db->get_where('data_monitoring', array('flag_id' => 2));
        $data['countValid'] = $qValid->num_rows();
        $qTrash = $this->db->get_where('data_monitoring', array('flag_id' => 3));
        $data['countTrash'] = $qTrash->num_rows();*/

		$this->load->view('design/topbar',$data);
	}

	public function sidebar($title,$icon){

		$data['username'] = NULL;
		$data['nama'] = NULL;
		$data['loggedin'] = 0;
		$data['roles'] = NULL;
		$data['roles_id'] = 0;
		$data['sub_role'] = 0;
		$data['gender'] = NULL;
		$data['titleBreadcumb'] = $title;
		$data['iconBreadcumb'] = $icon;
		$data['kode_satker'] 	= NULL;
        $data['nama_satker'] 	= NULL;
		if ($this->session->loggedIn == 1){
			$data['user_id'] 	= $this->session->user_id;
			$data['username'] 	= $this->session->username;
			$data['nama'] 		= $this->session->namauser;
			$data['loggedin'] 	= $this->session->loggedIn;
			$data['roles'] 	= $this->session->roles;
            $data['roles_id'] 	= $this->session->roles_id;
            $data['sub_role'] 	= $this->session->sub_role;
            $data['gender'] 	= $this->session->gender;
            $data['kode_satker'] 	= $this->session->kode_satker;
        	$data['nama_satker'] 	= $this->session->nama_satker;
            
		}
		$this->load->view('design/sidebar', $data);
	}
	
}

/* end of file commons/controllers/Commons.php */
?>