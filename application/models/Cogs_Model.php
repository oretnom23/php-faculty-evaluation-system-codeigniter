<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cogs_Model extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }

    function users_list(){
        $list = $this->db->query("SELECT * from users where status=1 ")->result_array();
        $data = array();
        foreach($list as $row){
            $row['name'] = ucwords($row['lastname'].", ".$row['firstname']." ".$row['middlename']);
            $data[] = $row;
        }
        return json_encode($data);
    }
    function log_list(){
        $list = $this->db->query("SELECT l.*,concat(u.lastname,', ',u.firstname,' ',u.middlename) as uname from logs l inner join users u on u.id = l.user_id  order by id desc ")->result_array();
        $data = array();
        foreach($list as $row){
            $row['date_created'] = date("M d, Y H:i",strtotime($row['date_created']));
            $data[] = $row;
        }
        return json_encode($data);
    }

    function save_users(){
        extract($_POST);
        $data['firstname'] =  $firstname;
        $data['lastname'] =  $lastname;
        $data['middlename'] =  $middlename;
        $data['username'] =  $username;
        if(isset($user_type)){
        $data['user_type'] =  $user_type;
        $data['department_id'] =  $department_id;
    }
        if(!empty($password))
            $data['password'] =  md5($password);
            
        if(empty($id)){
            $chk = $this->db->get_where('users',array("username"=>$username,'status'=>1))->num_rows();
            if($chk > 0){
                return json_encode(array("status"=>2,"msg"=>"Username already exist."));
                exit;
            }
            $save = $this->db->insert("users",$data);
        }else{
            $chk = $this->db->get_where('users',array("username"=>$username,'status'=>1,'id!='=>$id))->num_rows();
            if($chk > 0){
                return json_encode(array("status"=>2,"msg"=>"Username already exist."));
                exit;
            }
            $save = $this->db->update("users",$data,array('id'=>$id));
        }
        if($save)
         return json_encode(array("status"=>1));

    }
    function update_password(){
        extract($_POST);
        $user = $this->db->get_where('student_list',array('id'=>$id));
        foreach($user->row() as $k=> $v){
            $$k = $v;
        }
        $current = empty($auto_generated) ? $password : md5($auto_generated);
        if($current != md5($opassword)){
            return 2;
            exit;
        }
        if($_SESSION['login_user_type'] == 1)
        $save = $this->db->update("student_list",array("password"=>md5($npassword),"auto_generated"=>''),array('id'=>$id));
        else
        $save = $this->db->update("chairperson_list",array("password"=>md5($npassword),"auto_generated"=>''),array('id'=>$id));
        if($save)
        return 1;
    }

    function save_log($msg="",$action = ''){
        $data['log_msg'] = $msg;
        $data['action_made'] = $action;
        $data['user_id'] = $_SESSION['login_id'];

        $this->db->insert("logs",$data);

    }
}