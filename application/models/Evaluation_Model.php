<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Evaluation_Model extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }

    function save_evaluation(){
       extract($_POST);
       
        if(empty($id)){
            $data['school_year'] = $school_year;
            $data['semester'] = $semester;
            $save = $this->db->insert("evaluation_list",$data);
            $id = $this->db->insert_id();
            if($save){
                $this->session->set_flashdata('action_eval',1);
                return $id;
            }
        }else{
            $data['school_year'] = $school_year;
            $data['semester'] = $semester;
            $save = $this->db->update("evaluation_list",$data,array('id'=>$id));
            if($save){
                $this->session->set_flashdata('action_eval',1);
                return $id;
            }
        }
       
    }

    function load_list(){
        extract($_POST);
        $list = $this->db->order_by('school_year desc')->get_where("evaluation_list",array('status'=>1));
        $data=array();
        foreach($list->result_array() as $row){
            $data[]= $row;
        }
        return json_encode($data);
   
    }
    function remove(){
        extract($_POST);
        if(!empty($id)){
            $rem = $this->db->update('evaluation_list',array('status'=>0),array('id'=>$id));
            if($rem)
            return 1;
        }
    }

    function save_questionaire(){
        extract($_POST);
      
        $count = count($_POST['question']);
        $saved = 0;
        $id_arr = array();
        for($i = 0;$i < $count;$i++){
           if(empty($qid[$i])){
               $data['evaluation_id'] = $id;
               $data['question_for'] = $question_for;
               $data['order_by'] = $i;
               $data['question'] = $question[$i];
               $data['criteria_id'] = $criteria_id[$i];
               $data['type'] = $type[$i];
               $insert = $this->db->insert('question_list',$data);
               $insert_id = $this->db->insert_id();
               if($insert){
                   $saved++;
                   $id_arr[]=$insert_id;
               }
           }else{
            $data['evaluation_id'] = $id;
            $data['question_for'] = $question_for;
            $data['order_by'] = $i;
            $data['question'] = $question[$i];
            $data['criteria_id'] = $criteria_id[$i];
            $data['type'] = $type[$i];
            $insert = $this->db->update('question_list',$data,array('id'=>$qid[$i]));
            if($insert){
                $saved++;
                $id_arr[]=$qid[$i];
            }
           }
        }
        $id_arr = implode(',',$id_arr);
        $delete = $this->db->query("DELETE FROM question_list where id not in (".$id_arr.") and evaluation_id = $id and question_for = $question_for ");
        $data = array();
        // $data['TEST DELETE'] = $delete;
        if($count == $saved){
            $data['status'] = 1;
            $data['msg'] = "Questionaire successfully saved.";
        }elseif($saved < $count){
            $data['status'] = 2;
            $data['msg'] = "Some questions failed to save.";
        }elseif($saved == 0){
            $data['status'] = 2;
            $data['msg'] = "Questionaire failed to save.";
        }
        return json_encode($data);
    }

    function load_questions(){
        extract($_POST);
        if(!empty($id)){
            $data = array();
            $get = $this->db->order_by('order_by','asc')->get_where('question_list',array('evaluation_id'=>$id,'question_for'=>$for));
            foreach($get->result_array() as $row){
                $data[] = $row;
            }
            return json_encode($data);
        }
    }
    function save_restriction(){
        extract($_POST);
        $del = $this->db->query("DELETE FROM restriction_list where evaluation_id = $eid and faculty_id = $faculty_id ");
        if(isset($cl_id) && count($cl_id) > 0){
        foreach($cl_id as $k => $v){
            $meta['evaluation_id'] = $eid;
            $meta['faculty_id'] = $faculty_id;
            $meta['curriculum_id'] = $v;
            $meta['subject_id'] = $subject_id[$k];
            $chk =  $this->db->query("SELECT * FROM restriction_list where evaluation_id = $eid and faculty_id = $faculty_id and curriculum_id = '$v' and subject_id='{$subject_id[$k]}' ");
            if($chk->num_rows() <= 0)
            $data[] = $meta;

        }
        if(isset($data)){
            $save = $this->db->insert_batch("restriction_list",$data);
            if($save){
                $this->session->set_flashdata('action_save_restriction',1);
                return 1;
            }
        }
    }else{
        return 1;
    }

       
    }
    function load_faculty(){
        extract($_POST);
        $faculty = $this->db->query("SELECT *,concat(firstname,' ',lastname,' ',name_pref) as name  FROM faculty_list where id in (SELECT faculty_id from restriction_list where evaluation_id = '$id' ) ");
        $data = array();
        foreach($faculty->result_array() as $row){
            $row['name'] = ucwords($row['name']);
            $data[] = $row;
        }
        return json_encode($data);
    }
    function make_default(){
        extract($_POST);
        $save1 = $this->db->update('evaluation_list',array('is_default'=> 0),array('id!='=> $id));
        $save2 = $this->db->update('evaluation_list',array('is_default'=> 1),array('id'=> $id));
        if($save2){
            $this->session->set_flashdata('action_def',1);
            return 1;
        }
    }

}