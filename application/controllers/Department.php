<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Department extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Department_Model','department');
        
        if(!isset($_SESSION['login_id']))
            redirect(base_url('login'));

        
    }
	
	public function index($action='')
	{
        $page['title'] = 'department';
        $page['page'] = "department/list";
        $page['action'] =$action;
		$this->load->view('index',$page);
    }

    function manage($type = 'add',$id='')
	{
        $page['title'] = ucwords($type). ' department'  ;
        $page['page'] = "department/manage_department";
        $page['id'] = $id;
		$this->load->view('index',$page);
    }
    function save_department(){

        $save = $this->department->save();
        if($save)
        echo 1;

    }
    function remove(){

        $remove = $this->department->remove();
        if($remove)
        echo 1;

    }
    function load_list(){
        $data = $this->department->load_list();
        if($data)
        echo $data;
    }
}
