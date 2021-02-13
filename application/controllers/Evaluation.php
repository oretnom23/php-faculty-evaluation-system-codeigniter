<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Evaluation extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Evaluation_Model','evaluation');
        
        if(!isset($_SESSION['login_id']))
            redirect(base_url('login'));

        
    }
	
	public function index()
	{
        $page['title'] = 'evaluation';
        $page['page'] = "evaluation/list";
		$this->load->view('index',$page);
    }
    function manage($id=''){
        $page['id'] = $id;
		$this->load->view('evaluation/manage_evaluation',$page);
    }
    function manage_questionaire($id = '',$for=1){
        if(empty($id)){
            echo "<h1>Access Denied! </h1><br> <small>Can't proceed without a given Identification.</small <br> <a href='".base_url()."'>Back to the page.</a.";
            exit;
        }
        $qry = $this->db->query("SELECT * FROM evaluation_list where id = $id");
                if($qry->num_rows() <= 0){
                        echo "<h1>Unkown Page!</h1> <br> <a href='".base_url()."'>Back to the page.</a.";
                        exit;
                }else{
                    foreach($qry->row() as $k => $v){
                        $meta[$k] = $v; 
                    }
                }
        $page['meta'] = $meta;
        
		$page['title'] = 'evaluation';
        $page['page'] = "evaluation/manage_questionaire";
        $page['for'] = $for;
		$this->load->view('index',$page);
    }

    function evaluation_view($id='')
	{
        if(empty($id)){
            echo "<h1>Access Denied! </h1><br> <small>Can't proceed without a given Identification.</small <br> <a href='".base_url()."'>Back to the page.</a.";
            exit;
        }
        $page['title'] = 'evaluation';
        $page['page'] = "evaluation/evaluation_view";
        $meta = array();
        $qry = $this->db->query("SELECT * FROM evaluation_list where id = $id");
        if($qry->num_rows() <= 0){
                echo "<h1>Unkown Page!</h1> <br> <a href='".base_url()."'>Back to the page.</a.";
                exit;
        }else{
            foreach($qry->row() as $k => $v){
                $meta[$k] = $v; 
            }
        }
        $page['meta'] = $meta;
		$this->load->view('index',$page);
    }
    function load_list(){
        $list = $this->evaluation->load_list();
        if($list){
            echo $list;
        }
    }
    function save_evaluation(){
        $save = $this->evaluation->save_evaluation();
        if($save)
        echo $save;
    }
    function remove(){
        $remove = $this->evaluation->remove();
        if($remove)
        echo $remove;
    }

    function save_questionaire(){
        $save = $this->evaluation->save_questionaire();

        if($save){
            echo $save;
        }
    }
    function load_questions(){
        $list = $this->evaluation->load_questions();
        if($list)
        echo $list;
    }
   
    function manage_restriction($eid = '',$id = ''){
        $data['fid'] = $id;
        $data['eid'] = $eid;
        $this->load->view('evaluation/manage_restriction',$data);
    } 

    function save_restriction(){
        $save = $this->evaluation->save_restriction();
        if($save)
        echo $save;
    }

    function load_faculty(){
        $list = $this->evaluation->load_faculty();
        if($list)
        echo $list;
    }
    function view_handles($eid='',$fid=''){
        $data['eid'] = $eid;
        $data['fid'] = $fid;
        $this->load->view('evaluation/view_handles',$data);
    }

    function make_default(){
        $save = $this->evaluation->make_default();
        if($save)
        echo $save;
    }
    function result(){
        $page['title'] = 'Student Evaluation Result';
        $page['page'] = "result/list";
		$this->load->view('index',$page);
    }
    function result_student($fid=''){
        $page['title'] = 'Student\'s Evaluation Result';
        $page['page'] = "result/result_student";
        $page['fid'] = $fid;
        $page['controller'] = $this;
		$this->load->view('index',$page);
    }
    function result_chairperson($fid=''){
        $page['title'] = 'Chairperson\'s Evaluation Result';
        $page['page'] = "result/result_chairperson";
        $page['fid'] = $fid;
        $page['controller'] = $this;
        $this->load->view('index',$page);
    }
     function get_parent($parent){
               
     $criteria_qry = $this->db->query("SELECT * FROM criteria where id= '$parent' and status = 1");
        foreach($criteria_qry->result_array() as $row):
            $criteria[] = $row;
        endforeach;
        return $criteria;
    }
}
