<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Department_Model extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }

    function save(){
       extract($_POST);
       
       if(empty($id)){
           $data['department'] = $name;
           $data['description'] = $description;
           $save = $this->db->insert('department_list',$data);
           if($save){
            $this->session->set_flashdata('action_dept','1');
           return 1;
        }
       }else{
        $data['department'] = $name;
        $data['description'] = $description;
        $save = $this->db->update('department_list',$data,array('id'=>$id));
        if($save){
            $this->session->set_flashdata('action_dept','1');
           return 1;
        }
       }
       
    }
    function remove(){
        extract($_POST);
        if(!empty($id)){
            $qry = $this->db->update('department_list',array('status'=>0),array('id'=>$id));
            if($qry)
            return 1;
        }
    }

    function load_list(){

        $qry = $this->db->query("SELECT * FROM department_list where status = 1 ");
        $data=array();
        foreach($qry->result_array() as $row){
            $data[] = $row;
        }
        return json_encode($data);
    }



}