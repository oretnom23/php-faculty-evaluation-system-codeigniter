<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Student_Model extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }

    function save_student(){
       extract($_POST);
            $data['firstname'] = $fname;
           $data['lastname'] = $lname;
           $data['middlename'] = $middlename;
           $data['student_code'] = $student_code;
           $data['cl_id'] = $cl_id;
           $data['department_id'] = $department_id;
       if(empty($id)){
           
           $data['auto_generated'] = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 8)), 0, 8);
            $chk = $this->db->query("SELECT * FROM student_list where student_code = '$student_code' ")->num_rows();
            if($chk > 0){
                return json_encode(array('status' => 2,'msg'=>"Student Code already exist."));
                exit;
            }
           $save = $this->db->insert('student_list',$data);
           if($save){
               $this->session->set_flashdata('action_save_student','1');
               return json_encode(array('status' => 1));
            }
       }else{
           if(isset($regen) && $regen == 1){
           $data['auto_generated'] = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 8)), 0, 8);
            $data['password'] = '';
        }
           $chk = $this->db->query("SELECT * FROM student_list where student_code = '$student_code' and id !='$id' ")->num_rows();
           if($chk > 0){
               return json_encode(array('status' => 2,'msg'=>"Student Code already exist."));
               exit;
           }
           $save = $this->db->update('student_list',$data,array('id'=>$id));
        if($save){
            $this->session->set_flashdata('action_save_student','1');
               return json_encode(array('status' => 1));
        }
       }
       
    }

    function load_list(){

        $qry = $this->db->query("SELECT s.*,d.department as dname,concat(c.`year`,'-',c.section) as cl FROM student_list s  inner join department_list d on s.department_id = d.id inner join curriculum_level_list c on c.id =s.cl_id  where s.status = 1 ");
        $data=array();
        foreach($qry->result_array() as $row){
            $row['name'] = ucwords($row['lastname'].', '.$row['firstname'].' '.$row['middlename']);
            $data[] = $row;
        }
        return json_encode($data);
    }
    function remove(){
        extract($_POST);
        if(!empty($id)){
            $rem = $this->db->update('student_list',array('status'=>0),array('id'=>$id));
            if($rem)
            return 1;
        }
    }

    function load_evaluation(){
        extract($_POST);
            $data = array();
            $id = $this->db->query('SELECT * FROM evaluation_list where status = 1 and is_default = 1 ')->row()->id;
            $get = $this->db->order_by('order_by','asc')->get_where('question_list',array('evaluation_id'=>$id,'question_for'=>1));
            foreach($get->result_array() as $row){
                $data[] = $row;
        }

            return json_encode($data);
    }

    function save_student_evaluation(){
        extract($_POST);
        // $data = array();
        foreach($qid as $k => $v){
            $d = array();
            $d['student_id'] = $_SESSION['login_id'];
            $d['evaluation_id'] = $eid;
            $d['faculty_id'] = $faculty_id;
            $d['subject_id'] = $subject_id;
            $d['restriction_id'] = $restriction_id;
            $d['question_id'] = $qid[$k];
            $d['answer'] = $answer[$qid[$k]];
            $d['other_details'] = json_encode($other_details);
            $data[] = $d;
        }
        $save = $this->db->insert_batch("answers",$data);
         $data = array();
            $data['student_id'] = $_SESSION['login_id'];
            $data['evaluation_id'] = $eid;
            $data['comment'] = $comment;
            $data['restriction_id'] = $restriction_id;
        $save2 = $this->db->insert("comments",$data);
        if($save){
            $this->session->set_flashdata("answer_submitted",1);
            return 1;
        }
    }

}