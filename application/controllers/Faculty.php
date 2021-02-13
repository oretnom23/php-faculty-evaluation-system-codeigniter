<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faculty extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Faculty_Model','faculty');
        
        if(!isset($_SESSION['login_id']))
            redirect(base_url('login'));

        
    }
	
	public function index()
	{
        $page['title'] = 'faculty';
        $page['page'] = "faculty/list";
		$this->load->view('index',$page);
    }

    function manage($type = 'add',$id='')
	{
        $page['title'] = ucwords($type). ' faculty'  ;
        $page['page'] = "faculty/manage_faculty";
        $page['id'] = $id;
		$this->load->view('faculty/manage_faculty',$page);
    }
    function save_faculty(){

        $save = $this->faculty->save();
        if($save)
        echo 1;

    }
    function remove(){

        $remove = $this->faculty->remove();
        if($remove)
        echo 1;

    }
    function load_list(){
        $data = $this->faculty->load_list();
        if($data)
        echo $data;
    }
}
