<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Course extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Course_Model','course');
        
        if(!isset($_SESSION['login_id']))
            redirect(base_url('login'));

        
    }
	
	public function index($action='')
	{
        $page['title'] = 'course';
        $page['page'] = "course/list";
        $page['action'] =$action;
		$this->load->view('index',$page);
    }

    function manage($type = 'add',$id='')
	{
        $page['title'] = ucwords($type). ' course'  ;
        $page['page'] = "course/manage_course";
        $page['id'] = $id;
		$this->load->view('index',$page);
    }
    function save_course(){

        $save = $this->course->save();
        if($save)
        echo 1;

    }
    function remove(){

        $remove = $this->course->remove();
        if($remove)
        echo 1;

    }
    function load_list(){
        $data = $this->course->load_list();
        if($data)
        echo $data;
    }
}
