<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Events_model extends CI_Model {
 	
	private $id;
	private $addDate;
	private $lastModified;
	private $event_title;
	private $host_id;
	private $event_date;
	private $event_start;
	private $event_start_hours;
	private $event_start_minutes;
	private $event_start_AmPm;
	private $event_duration;
	private $event_timezone;
	private $event_image;
	private $event_desc;
	private $event_tags;
	private $status;
	
    /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
        //$this->load->database(); 	// AMD
		parent::__construct();
    }

    /**
    * Get event by his is
    * @param int $event_id 
    * @return array
    */
    public function get_event_by_id($id)
    {
		$this->db->select('*');
		$this->db->from('events');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->result_array(); 
    }

    /**
    * Fetch products data from the database
    * possibility to mix search, filter and order
    * @param int $manufacuture_id 
    * @param string $search_string 
    * @param strong $order
    * @param string $order_type 
    * @param int $limit_start
    * @param int $limit_end
    * @return array
    */
    public function get_events($host_id=null, $search_string=null, $order=null, $order_type='Asc', $limit_start, $limit_end)
    {
	    
		$this->db->select('events.id');
		$this->db->select('events.event_title');
		$this->db->select('events.event_desc');
		$this->db->select('events.host_id');
		$this->db->select('events.event_date');
		$this->db->select('events.event_start');
		$this->db->select('events.event_duration');
		$this->db->select('events.event_image');
		$this->db->select('events.timezone');
		$this->db->select('events.event_tags');
		$this->db->select('events.status');
		$this->db->select('users.first_name as f_name');
		$this->db->select('users.last_name as l_name');
		$this->db->from('events');
		if($host_id != null && $host_id != 0){
			$this->db->where('host_id', $host_id);
		}
		if($search_string){
			$this->db->like('event_title', $search_string);
		}

		$this->db->join('users', 'events.host_id = users.id', 'left');

		$this->db->group_by('events.id');

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
	
	public function get_attendees($event_id=null, $search_string=null, $order=null, $order_type='Asc', $limit_start, $limit_end)
    {
	    
		$this->db->select('event_attendees.id');
		$this->db->select('event_attendees.addDate');
		$this->db->select('event_attendees.lastModified');
		$this->db->select('event_attendees.user_id');
		$this->db->select('event_attendees.event_id');
		$this->db->select('event_attendees.status');
		$this->db->select('events.event_title');
		$this->db->select('events.event_image');
		$this->db->select('users.first_name as f_name');
		$this->db->select('users.last_name as l_name');
		$this->db->from('event_attendees');
		if($event_id != null && $event_id != 0){
			$this->db->where('event_attendees.event_id', $event_id);
		}
		if($search_string){
			$this->db->like('event_title', $search_string);
		}

		$this->db->join('events', 'event_attendees.event_id = events.id', 'left');
		$this->db->join('users', 'event_attendees.user_id = users.id', 'left');

		$this->db->group_by('events.id');

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
	
    
	/**
    * Count the number of rows
    * @param int $host_id
    * @param int $search_string
    * @param int $order
    * @return int
    */
    function count_events($host_id=null, $search_string=null, $order=null)
    {
		$this->db->select('*');
		$this->db->from('events');
		if($host_id != null && $host_id != 0){
			$this->db->where('host_id', $host_id);
		}
		if($search_string){
			$this->db->like('event_title', $search_string);
		}
		if($order){
			$this->db->order_by($order, 'Asc');
		}else{
		    $this->db->order_by('id', 'Asc');
		}
		$query = $this->db->get();
		return $query->num_rows();        
    }

    /**
    * Store the new item into the database
    * @param array $data - associative array with data to store
    * @return boolean 
    */
    function store_event($data)
    {
		$insert = $this->db->insert('events', $data);
	    return $insert;
	}

    /**
    * Update product
    * @param array $data - associative array with data to store
    * @return boolean
    */
    function update_event($id, $data)
    {
		$this->db->where('id', $id);
		$this->db->update('events', $data);
		$report = array();
		//$report['error'] = $this->db->_error_number();
		//$report['message'] = $this->db->_error_message();
		if($report !== 0){
			return true;
		}else{
			return false;
		}
	}

    /**
    * Delete event
    * @param int $id - event id
    * @return boolean
    */
	function delete_event($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('events'); 
	}
	
 
}
?>