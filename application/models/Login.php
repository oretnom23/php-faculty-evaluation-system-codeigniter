<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        

        
    }
	
	public function index()
	{
        if(isset($_SESSION['login_id']))
            redirect(base_url());
		$this->load->view('login');
    }

    function login(){
       
        extract($_POST);
		$data['username'] = $username;
        $data['password'] = md5($password);
        $qry = $this->db->get_where('users',$data);
        if($qry->num_rows() > 0){
            foreach($qry->row() as $k => $val){
                if($k != 'password')
                    $this->session->set_userdata('login_'.$k,$val);
            }
            echo json_encode(array('status'=>1));
        }else{
            echo json_encode(array('status'=>2,'msg'=>'Username or password incorrect'));
        }
    }
    function logout(){
        $this->session->sess_destroy();
        redirect(base_url('login'));
    }
   
}
