<?php
class Cars_model extends CI_Model {

	public function __construct()	{
		$this->load->database();
	}
	
	public function get_cars($car_id = FALSE)	{
	  if ($car_id === FALSE)
	  {
	    $query = $this->db->get('cars');
	    return $query->result_array();
	  }
	
	  $query = $this->db->get_where('cars', array('id' => $car_id));
	  return $query->row_array();
	}
	
	public function insert($record) {
	  
	  $this->db->set($record);
	  $this->db->insert('cars');
	  
	}
	
	public function update($id, $record) {
	  
	  $this->db->where('id', $id);
	  $this->db->update('cars', $record);
	  
	}
}
