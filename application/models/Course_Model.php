<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Course_Model extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }

    function save(){
       extract($_POST);
       
       if(empty($id)){
           $data['course'] = $name;
           $data['description'] = $description;
            $data['department_id'] = $department_id;
        $save = $this->db->insert('courses',$data);
           if($save){
            $this->session->set_flashdata('action_dept','1');
           return 1;
        }
       }else{
        $data['course'] = $name;
        $data['description'] = $description;
        $data['department_id'] = $department_id;
        $save = $this->db->update('courses',$data,array('id'=>$id));
        if($save){
            $this->session->set_flashdata('action_dept','1');
           return 1;
        }
       }
       
    }
    function remove(){
        extract($_POST);
        if(!empty($id)){
            $qry = $this->db->update('courses',array('status'=>0),array('id'=>$id));
            if($qry)
            return 1;
        }
    }

    function load_list(){

        $qry = $this->db->query("SELECT c.*,d.department FROM courses c inner join department_list d on c.department_id = d.id where c.status = 1  ".($_SESSION['login_user_type'] != 1 ? " and c.department_id = {$_SESSION['login_department_id']}  ":''));
        $data=array();
        foreach($qry->result_array() as $row){
            $data[] = $row;
        }
        return json_encode($data);
    }



}