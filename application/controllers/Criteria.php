<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Criteria extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Criteria_Model','criteria');
        
        if(!isset($_SESSION['login_id']))
            redirect(base_url('login'));

        
    }
	
	public function index($action='')
	{
        $page['title'] = 'criteria';
        $page['page'] = "criteria/criteria";
        $page['action'] =$action;
		$this->load->view('index',$page);
    }

    function manage($type = 'add',$id='')
	{
        $page['title'] = ucwords($type). ' criteria'  ;
        $page['page'] = "criteria/manage_criteria";
        $page['id'] = $id;
		$this->load->view('index',$page);
    }
    function save(){

        $save = $this->criteria->save();
        if($save)
        echo 1;

    }
    function save_order(){

        $save = $this->criteria->save_order();
        if($save)
        echo 1;

    }
    function remove(){

        $remove = $this->criteria->remove();
        if($remove)
        echo 1;

    }
    function load_list(){
        $data = $this->criteria->load_list();
        if($data)
        echo $data;
    }
}
