<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Faculty_Model extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }

    function save(){
       extract($_POST);
       
       if(empty($id)){
           $data['firstname'] = $fname;
           $data['lastname'] = $lname;
           $data['name_pref'] = $pref;
           $data['department_id'] = $department;
           $save = $this->db->insert('faculty_list',$data);
           if($save){
               $this->session->set_flashdata('action_fac','1');
                return 1;
           }
       }else{
        $data['firstname'] = $fname;
        $data['lastname'] = $lname;
        $data['name_pref'] = $pref;
        $data['department_id'] = $department;
        $save = $this->db->update('faculty_list',$data,array('id'=>$id));
        if($save){
            $this->session->set_flashdata('action_fac','1');
             return 1;
        }
       }
       
    }

    function load_list(){

        $qry = $this->db->query("SELECT f.*,d.department as dname FROM faculty_list f  inner join department_list d on f.department_id = d.id  where f.status = 1 ".($_SESSION['login_user_type'] != 1 ? " and f.department_id = {$_SESSION['login_department_id']}  ":''));
        $data=array();
        foreach($qry->result_array() as $row){
            $row['name'] = ucwords($row['lastname'].' '.$row['name_pref'].', '.$row['firstname']);
            $data[] = $row;
        }
        return json_encode($data);
    }
    function remove(){
        extract($_POST);
        if(!empty($id)){
            $rem = $this->db->update('faculty_list',array('status'=>0),array('id'=>$id));
            if($rem)
            return 1;
        }
    }



}