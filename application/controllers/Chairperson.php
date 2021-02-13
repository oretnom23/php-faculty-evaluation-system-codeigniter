<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chairperson extends CI_Controller {

	function __construct() {
        parent::__construct();
        // if(!isset($_SESSION['login_id']))
        //     redirect(base_url('login'));
        $this->load->model('Chairperson_Model','chairperson');

        
    }
	
	public function index()
	{
        
        $page['title'] = 'Home';
        $page['page'] = "chairperson";
		$this->load->view('chairperson',$page);
    }
    
    function list(){
        $page['title'] = 'chairperson List';
        $page['page'] = "chairperson/list";
		$this->load->view('index',$page);
    }
    function manage($id=''){
        $page['title'] = 'Manage chairperson';
        $page['page'] = "chairperson/manage_chairperson";
        $page['id'] = $id;
		$this->load->view('index',$page);
    }

    function load_list(){
        $list = $this->chairperson->load_list();
        if($list)
        echo $list;
    }

    function save_chairperson(){
        $save =$this->chairperson->save_chairperson();
        if($save)
        echo $save;
    }
    function remove(){
        $remove = $this->chairperson->remove();
        if($remove)
        echo $remove;
    }
    function load_evaluation(){
        $list = $this->chairperson->load_evaluation();
        if($list)
        echo $list;
    }
    function save_chairperson_evaluation(){
        $save = $this->chairperson->save_chairperson_evaluation();
        if($save)
            echo $save;
    }
}
