<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Chairperson_Model extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }

    function save_chairperson(){
       extract($_POST);
            $data['firstname'] = $fname;
           $data['lastname'] = $lname;
           $data['middlename'] = $middlename;
           $data['id_code'] = $id_code;
           $data['department_id'] = $department_id;
           $data['course_id'] = $course_id;
       if(empty($id)){
           
           $data['auto_generated'] = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 8)), 0, 8);
            $chk = $this->db->query("SELECT * FROM chairperson_list where id_code = '$id_code' ")->num_rows();
            if($chk > 0){
                return json_encode(array('status' => 2,'msg'=>"chairperson Code already exist."));
                exit;
            }
           $save = $this->db->insert('chairperson_list',$data);
           if($save){
               $this->session->set_flashdata('action_save_chairperson','1');
               return json_encode(array('status' => 1));
            }
       }else{
           if(isset($regen) && $regen == 1){
           $data['auto_generated'] = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 8)), 0, 8);
            $data['password'] = '';
        }
           $chk = $this->db->query("SELECT * FROM chairperson_list where id_code = '$id_code' and id !='$id' ")->num_rows();
           if($chk > 0){
               return json_encode(array('status' => 2,'msg'=>"chairperson Code already exist."));
               exit;
           }
           $save = $this->db->update('chairperson_list',$data,array('id'=>$id));
        if($save){
            $this->session->set_flashdata('action_save_chairperson','1');
               return json_encode(array('status' => 1));
        }
       }
       
    }

    function load_list(){

        $qry = $this->db->query("SELECT c.*,d.department as dname,co.course as cname FROM chairperson_list c  inner join department_list d on c.department_id = d.id inner join courses co on co.id = c.course_id  where c.status = 1 ".($_SESSION['login_user_type'] != 1 ? " and c.department_id = {$_SESSION['login_department_id']}  ":''));
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
            $rem = $this->db->update('chairperson_list',array('status'=>0),array('id'=>$id));
            if($rem)
            return 1;
        }
    }

    function load_evaluation(){
        extract($_POST);
            $data = array();
            $id = $this->db->query('SELECT * FROM evaluation_list where status = 1 and is_default = 1 ')->row()->id;
            $get = $this->db->order_by('order_by','asc')->get_where('question_list',array('evaluation_id'=>$id,'question_for'=>2));
            foreach($get->result_array() as $row){
                $data[] = $row;
        }

            return json_encode($data);
    }

    function save_chairperson_evaluation(){
        extract($_POST);
        // $data = array();
        foreach($qid as $k => $v){
            $d = array();
            $d['chairperson_id'] = $_SESSION['login_id'];
            $d['evaluation_id'] = $eid;
            $d['faculty_id'] = $faculty_id;
            $d['question_id'] = $qid[$k];
            $d['answer'] = $answer[$qid[$k]];
            $data[] = $d;
        }
        $save = $this->db->insert_batch("answers",$data);
        $data = array();
        $data['chairperson_id'] = $_SESSION['login_id'];
        $data['evaluation_id'] = $eid;
        $data['comment'] = $comment;
    $save2 = $this->db->insert("comments",$data);
        if($save){
            $this->session->set_flashdata("answer_submitted",1);
            return 1;
        }
    }

}