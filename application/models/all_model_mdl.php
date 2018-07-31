<?php

class All_model_mdl extends CI_Model {
	
	private $table;
    function __construct($table_name = "") {
		if($table_name!=""){
			$this->table = $table_name;
		}
        parent::__construct();
    }
	
	function set_table_name($table_name){
		$this->table = $table_name;
	}

    function get($type = 'all',$where = "",$like = "",$order_by = "" ,$limit = '-',$offset = '-'){
		$this->db->select('*');
		if($where!=""){
			$this->db->where($where);
		}
		if($like!=""){
			$this->db->like($like);
		}
		if($order_by!=''){
			$this->db->order_by($order_by);
		}
		if($limit!='-'){
			$this->db->limit($limit);
		}
		if($offset!='-'){
			$this->db->offset($offset);
		}
		if($type=='all'){
			return $this->db->get($this->table)->result();
		}else if($type=='row'){
			return $this->db->get($this->table)->row();
		}
	}
	
	function count_result($where = "",$like = ""){
		$this->db->select('count('.$this->table.'_id) as count_result');
		if($where!=""){
			$this->db->where($where);
		}
		if($like!=""){
			$this->db->like($like);
		}
		return $this->db->get($this->table)->row()->count_result;
	}
	
	function insert($array_data){
		$this->db->insert($this->table, $array_data);
	}
	
	function update($id, $array_data) {
        $this->db->where($this->table.'_id', $id);
        $this->db->update($this->table, $array_data);
    }
	
	function delete($id) {
        $this->db->where($this->table.'_id', $id);
        $this->db->delete($this->table);
    }
	
	function get_by_id($id){
		$this->db->select('*');
		$this->db->where($this->table.'_id', $id);
        return $this->db->get($this->table)->row();
	}
	
	function custom_fetch_query($query = "",$type = 'all'){
		if($type == "all"){
			return $this->db->query($query)->result();
		}else{
			return $this->db->query($query)->row();
		}
	}

}
