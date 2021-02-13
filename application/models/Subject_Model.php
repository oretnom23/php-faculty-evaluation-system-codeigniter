<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Subject_Model extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }

    function save(){
       extract($_POST);
       
       if(empty($id)){
           $data['subject'] = $name;
           $data['description'] = $description;
        $save = $this->db->insert('subjects',$data);
           if($save){
            $this->session->set_flashdata('action_subject','1');
           return 1;
        }
       }else{
            $data['subject'] = $name;
           $data['description'] = $description;
           $save = $this->db->update('subjects',$data,array('id'=>$id));
        if($save){
            $this->session->set_flashdata('action_subject','1');
           return 1;
        }
       }
       
    }
    function remove(){
        extract($_POST);
        if(!empty($id)){
            $qry = $this->db->update('subjects',array('status'=>0),array('id'=>$id));
            if($qry)
            return 1;
        }
    }

    function load_list(){

        $qry = $this->db->query("SELECT * FROM subjects  where status = 1 ");
        $data=array();
        foreach($qry->result_array() as $row){
            $data[] = $row;
        }
        return json_encode($data);
    }



}