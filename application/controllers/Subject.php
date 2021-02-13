<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subject extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Subject_Model','subject');
        
        if(!isset($_SESSION['login_id']))
            redirect(base_url('login'));

        
    }
	
	public function index($action='')
	{
        $page['title'] = 'Subject';
        $page['page'] = "subject/list";
        $page['action'] =$action;
		$this->load->view('index',$page);
    }

    function manage($id='')
	{
        
        $page['page'] = "subject/manage_subject";
        $page['id'] = $id;
		$this->load->view('subject/manage_subject',$page);
    }
    function save_subject(){

        $save = $this->subject->save();
        if($save)
        echo 1;

    }
    function remove(){

        $remove = $this->subject->remove();
        if($remove)
        echo 1;

    }
    function load_list(){
        $data = $this->subject->load_list();
        if($data)
        echo $data;
    }
}
