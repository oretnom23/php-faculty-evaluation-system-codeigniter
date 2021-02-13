<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Criteria_Model extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }

    function save(){
       extract($_POST);
        $data['criteria'] = $criteria;
        $data['parent_id'] = $parent_id;
        $order_by = $this->db->query("SELECT * FROM criteria order by order_by desc limit 1");
        $order_by = $order_by->num_rows() > 0 ? $order_by->row()->order_by : 1;
        $data['order_by'] = $order_by;
        if(empty($id)){
        $save = $this->db->insert('criteria',$data);
           if($save){
            $this->session->set_flashdata('action_criteria','1');
           return 1;
        }
       }else{
        $save = $this->db->update('criteria',$data,array('id'=>$id));
        if($save){
            $this->session->set_flashdata('action_criteria','1');
           return 1;
        }
       }
       
    }
    function save_order(){
       extract($_POST);
       $data  = json_decode($jsonData);
        $i = 0;
       foreach($data as $row){
           $id = $row->id;
            $this->db->update("criteria",array('order_by'=>$i),array('id'=>$id));
           $i++;
       }
       return 1;
    }
    function remove(){
        extract($_POST);
        if(!empty($id)){
            $qry = $this->db->update('criteria',array('status'=>0),array('id'=>$id));
            if($qry)
            return 1;
        }
    }

    function load_list(){

        $qry = $this->db->query("SELECT * FROM criteria where status = 1 order by order_by asc ");
        $data=array();
        foreach($qry->result_array() as $row){
            $data[] =array('id'=>$row['id'], 'parent'=>($row['parent_id']>0)? $row['parent_id'] : "#", 'text'=>$row['criteria'],'data'=>"");;
        }
        return json_encode($data);
        }



}