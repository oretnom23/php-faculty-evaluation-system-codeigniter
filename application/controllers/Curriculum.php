<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Curriculum extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Curriculum_Model','curriculum');
        if(!isset($_SESSION['login_id']))
            redirect(base_url('login'));

        
    }
	
	public function index()
	{
        $page['title'] = 'curriculum';
        $page['page'] = "curriculum/list";
		$this->load->view('index',$page);
    }

    function manage($type = 'add',$id='')
	{
        $page['title'] = ucwords($type). ' curriculum'  ;
        $page['page'] = "curriculum/manage_curriculum";
        $page['id'] = $id;
		$this->load->view('index',$page);
    }
    function save_curriculum(){

        $save = $this->curriculum->save();
        if($save)
        echo $save;

    }
    function remove(){

        $remove = $this->curriculum->remove();
        if($remove)
        echo $save;

    }
    function load_list(){
        $data = $this->curriculum->load_list();
        if($data)
        echo $data;
    }
}
