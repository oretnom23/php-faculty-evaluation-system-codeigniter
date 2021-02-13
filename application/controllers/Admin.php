<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct() {
        parent::__construct();
        if(!isset($_SESSION['login_id']))
            redirect(base_url('login'));

        
	}
	
	public function index()
	{
        $page['title'] = 'Home';
        $page['page'] = "dashboard";
		$this->load->view('index',$page);
	}
}
