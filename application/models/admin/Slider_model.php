<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Slider_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

	public function get_sliders($id=null,$search_string=null, $order=null, $order_type='Asc', $limit_start, $limit_end)
    {
	    
		$this->db->select('slider.id');
		$this->db->select('slider.addDate');
		$this->db->select('slider.image');
		$this->db->select('slider.title');
		$this->db->select('slider.subtitle');
		$this->db->select('slider.link_value');
		$this->db->select('slider.link_title');
		$this->db->select('slider.status');
		$this->db->from('slider');
		if($id != null && $id != 0){
			$this->db->where('id', $id);
		}
		if($search_string){
			$this->db->like('title', $search_string);
		}

		$this->db->group_by('slider.id');

		if($order){
			$this->db->order_by($order, $order_type);
		}else{
		    $this->db->order_by('id', $order_type);
		}


		if($limit_start!=0)
		$this->db->limit($limit_start, $limit_end);
		//$this->db->limit('4', '4');


		$query = $this->db->get();
		
		return $query->result_array(); 	
    }
    
	public function save($data)
	{
		$insert = $this->db->insert('slider', $data);
	    $insert_id = $this->db->insert_id();
		
		return $insert_id;
	}
	public function update($id,$data)
	{
		$this->db->where('id', $id);
		$this->db->update('slider', $data);
		$report = array();
		
		if($report !== 0){
			return true;
		}else{
			return false;
		}
	}
	public function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('slider'); 	
	}
}
