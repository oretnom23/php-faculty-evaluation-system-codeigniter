<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Curriculum_Model extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }

    function save(){
       extract($_POST);
       
        if(empty($id)){
            $data['course_id'] = $course_id;
            $data['year'] = $year;
            $data['section'] = $section;
            $data['department_id'] = $department_id;
            $chk = $this->db->get_where('curriculum_level_list',$data)->num_rows();
            if($chk > 0){
                return 2;
                exit;
            }
            $save = $this->db->insert("curriculum_level_list",$data);
            if($save){
                $this->session->set_flashdata('action_cur',1);
                return 1;
            }
        }else{
            $data['course_id'] = $course_id;
            $data['year'] = $year;
            $data['section'] = $section;
            $data['department_id'] = $department_id;
            $cdata =array_merge($data,array("id!="=>$id));
            $chk = $this->db->get_where('curriculum_level_list',$cdata)->num_rows();
            if($chk > 0){
                return 2;
                exit;
            }
            $save = $this->db->update("curriculum_level_list",$data,array('id'=>$id));
            if($save){
                $this->session->set_flashdata('action_cur',1);
                return 1;
            }
        }
       
    }

    function load_list(){
        extract($_POST);
        $list = $this->db->query("SELECT c.*,d.department as dname,co.course FROM curriculum_level_list c inner join department_list d on c.department_id = d.id inner join courses co on co.id = c.course_id where c.status = 1 order by co.course asc, c.year asc, c.section asc ");
        $data=array();
        foreach($list->result_array() as $row){
            $data[]= $row;
        }
        return json_encode($data);
   
    }
    function remove(){
        extract($_POST);
        if(!empty($id)){
            $rem = $this->db->update('curriculum_level_list',array('status'=>0),array('id'=>$id));
            if($rem)
            return 1;
        }
    }



}