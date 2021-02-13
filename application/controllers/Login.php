<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        

        
    }
	
	public function index($type = 'student')
	{
        if(isset($_SESSION['login_id']))
            redirect(base_url());
            $data['type'] = $type;
		$this->load->view('login',$data);
    }
    function admin($type = 'admin')
	{
        if(isset($_SESSION['login_id']))
            redirect(base_url());
            $data['type'] = $type;
		$this->load->view('login',$data);
    }

    function login(){
       
        extract($_POST);
        if($user_type == 1){
            $data['username'] = $username;
            $data['password'] = md5($password);
            $qry = $this->db->get_where('users',$data);
            if($qry->num_rows() > 0){
                foreach($qry->row() as $k => $val){
                    if($k != 'password')
                        $this->session->set_userdata('login_'.$k,$val);
                }
                echo json_encode(array('status'=>1,'type'=>$_SESSION['login_user_type']));
            }else{
                echo json_encode(array('status'=>2,'msg'=>'Username or password incorrect'));
            }  
        }else{
            if($user_type == 2):
            $chk = $this->db->query("SELECT s.*,concat(co.course,' ',c.year,'-',c.section) as cls from student_list s inner join curriculum_level_list c on c.id = s.cl_id inner join courses co on co.id = c.course_id where s.student_code ='$username' ");
            else:
            $chk = $this->db->query("SELECT * from chairperson_list where id_code ='$username' ");
            endif;
            if($chk->num_rows() > 0){
                if(!empty($chk->row()->password) && $chk->row()->status == 1){
                    if(md5($password) == $chk->row()->password){
                        foreach($chk->row() as $k => $val){
                            if($k != 'password')
                                $this->session->set_userdata('login_'.$k,$val);
                        }
                        $this->session->set_userdata('login_user_type',2);

                        $sy = $this->db->query('SELECT * FROM evaluation_list where status = 1 and is_default = 1 ')->row();
                        foreach($sy as $k => $v){
                            $this->session->set_userdata('sy_'.$k,$v);
                        }
                        
                        echo json_encode(array('status'=>1));
                    }else{
                        echo json_encode(array('status'=>2,'msg'=>'Username or password incorrect'));
                    }
                }else{
                    if($password == $chk->row()->auto_generated  && $chk->row()->status == 1){
                        foreach($chk->row() as $k => $val){
                            if($k != 'password')
                                $this->session->set_userdata('login_'.$k,$val);
                        }
                        $this->session->set_userdata('login_user_type',3);
                        $sy = $this->db->query('SELECT * FROM evaluation_list where status = 1 and is_default = 1 ')->row();
                        foreach($sy as $k => $v){
                            $this->session->set_userdata('sy_'.$k,$v);
                        }
                        echo json_encode(array('status'=>1));
                    }else{
                        echo json_encode(array('status'=>2,'msg'=>'Username or password incorrect'));
                    }
                }
            }else{
                echo json_encode(array('status'=>2,'msg'=>'Username or password incorrect'));
            }
        }
		
    }
    function logout(){
        $type = $_SESSION['login_user_type'];
        $this->session->sess_destroy();
        if($type > 1)
        redirect(base_url('login'));
        else
        redirect(base_url('login/index/admin'));

    }
   
}
