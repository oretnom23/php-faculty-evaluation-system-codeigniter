<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student extends CI_Controller {

	function __construct() {
        parent::__construct();
        // if(!isset($_SESSION['login_id']))
        //     redirect(base_url('login'));
        $this->load->model('Student_Model','student');

        
    }
	
	public function index()
	{
        
        $page['title'] = 'Home';
        $page['page'] = "student";
		$this->load->view('student',$page);
    }
    
    function list(){
        $page['title'] = 'Student List';
        $page['page'] = "student/list";
		$this->load->view('index',$page);
    }
    function manage($id=''){
        $page['title'] = 'Manage Student';
        $page['page'] = "student/manage_student";
        $page['id'] = $id;
		$this->load->view('index',$page);
    }

    function load_list(){
        $list = $this->student->load_list();
        if($list)
        echo $list;
    }

    function save_student(){
        $save =$this->student->save_student();
        if($save)
        echo $save;
    }
    function remove(){
        $remove = $this->student->remove();
        if($remove)
        echo $remove;
    }
    function load_evaluation(){
        $list = $this->student->load_evaluation();
        if($list)
        echo $list;
    }
    function save_student_evaluation(){
        $save = $this->student->save_student_evaluation();
        if($save)
            echo $save;
    }
}
