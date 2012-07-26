<?php

/*
 * This is a gateway for the Cars table.
 */
class Cars_model extends CI_Model {

  /*
   * Constructor.
   */
	public function __construct()	{
		$this->load->database();
	}
	
  /*
   * Returns the car with id = $car_id 
   * Or returns all the cars.
   */
	public function get_cars($car_id = FALSE)	{
	  if ($car_id === FALSE)
	  {
	    $query = $this->db->get('cars');
	    return $query->result_array();
	  }
	
	  $query = $this->db->get_where('cars', array('id' => $car_id));
	  return $query->row_array();
	}
	
  /*
   * Insert a new record.
   */
	public function insert($record) {
	  
	  $this->db->set($record);
	  $this->db->insert('cars');
	  
	}
	
  /*
   * Update the record with id = $id.
   */
	public function update($id, $record) {
	  
	  $this->db->where('id', $id);
	  $this->db->update('cars', $record);
	  
	}
}
