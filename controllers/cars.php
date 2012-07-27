<?php
/*
 * Implement CRUD operations for cars.
 */ 
class Cars extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		// I imagine these can go somewhere else.
		$config['hostname'] = "localhost";
		$config['username'] = "";
		$config['password'] = "";
		$config['database'] = "test";
		$config['dbdriver'] = "mysql";
		$config['dbprefix'] = "";
		$config['pconnect'] = FALSE;
		$config['db_debug'] = TRUE;

		$this->load->model('cars_model', '', $config);
	}

	/*
	 * List all the cars.
	 */
	public function index()
	{
	  $this->load->helper('url');
	  
	  $data['cars'] = $this->cars_model->get_cars();
	  $data['title'] = 'List of cars';

	  $this->load->view('templates/header', $data);
	  $this->load->view('cars/index', $data);
	  $this->load->view('templates/footer');
	}
	
	private function re_edit()
	{
	    // Recover the data from _POST. Can we use set_value()?
	    $data['title'] = 'Add a new car';
	    $data['id'] = $_POST['id'];
	    $data['car_desc'] = $_POST['car_desc'];
	    $data['car_year'] = $_POST['car_year'];
	    $data['car_make'] = $_POST['car_make'];
	    $data['car_model'] = $_POST['car_model'];
	    
	    $this->load->view('templates/header', $data);
	    $this->load->view('cars/edit', $data);
	    $this->load->view('templates/footer');
	}
	
	/*
	 * Save information of a car. It can be used to insert if it is a 
	 * new record or to update if it is an existing record.
	 */
	public function save()
	{
	  $this->load->helper(array('form', 'url'));
	  $this->load->library('form_validation');
	  
	  // Validate the form
	  $this->form_validation->set_error_delimiters('<div class="error">', '</div>');	  
	  $this->form_validation->set_rules('car_desc', 'Description', 'required');
		$this->form_validation->set_rules('car_year', 'Year', 'exact_length[4]|numeric|required');
		$this->form_validation->set_rules('car_make', 'Make', 'required');
		$this->form_validation->set_rules('car_model', 'Model', 'required');

	  if ($this->form_validation->run() == FALSE) {
	    // There was a validation error, we need to go back to the edit view.
	    $this->re_edit();
	    return;
	  }
	  	  	    
    // No validation errors. We can attempt to save the record.
    $record = array(
      'car_desc' => $this->input->post('car_desc'),
      'car_year' => $this->input->post('car_year'),
      'car_make' => $this->input->post('car_make'),
      'car_model' => $this->input->post('car_model')
      );
    
    // id comes in a hidden field.
    $id = $this->input->post('id');
    if ($id == '') {
      // New record.
      $id = $this->cars_model->insert($record);
    }
    else {
      // Existing record.
      $this->cars_model->update($id, $record);
    }
    
    if (isset($_FILES['userfile']) && !$this->upload_image($id)) {
        $_POST['id'] = $id;
        $this->re_edit();
        return;
    }

    // Tell the user that it was saved successfully.
    $data['title'] = 'Car saved';
    $this->load->view('templates/header', $data);
    $this->load->view('cars/saved', $data);
    $this->load->view('templates/footer');
	}

	/*
	 * Display a car with id = $car_id
	 */
	public function view($car_id)
	{
	  $this->load->helper('url');
 	  $cars_item = $this->cars_model->get_cars($car_id);

	  if (empty($cars_item)) {
	    show_404();
	  }

	  $cars_item['title'] = 'View car';
 
	  $this->load->view('templates/header', $cars_item);
	  $this->load->view('cars/view', $cars_item);
	  $this->load->view('templates/footer');
	}	
	
	function upload_image($id)
	{
	  
	  $x = explode('.', $_FILES['userfile']['name']);
	  $file_name = "car$id.".end($x);
	  log_message('debug', "file_name=$file_name");
	  
	  //$upload_path = '/var/www/html/uploads/';
	  $upload_path = getcwd() . "/" . APPPATH . "user_images";
	  log_message('debug', "upload_path=$upload_path");
	  
	  $config['upload_path'] = $upload_path;
	  $config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		$config['file_name'] = $file_name;

		$this->load->library('upload', $config);

		return $this->upload->do_upload('userfile');
	}
	
	/*
	 * Display the view to edit a car with id = $car_id
	 */
	public function edit($car_id)
	{
	  $this->load->helper('url');

	  // Fetch the record for this car.
 	  $cars_item = $this->cars_model->get_cars($car_id);

	  if (empty($cars_item)) {
	    show_404();
	  }

	  $this->load->helper(array('form', 'url'));
	  $this->load->library('form_validation');
		$this->load->library('upload');
	  
	  $cars_item['title'] = 'Edit car';
 
	  $this->load->view('templates/header', $cars_item);
	  $this->load->view('cars/edit', $cars_item);
	  $this->load->view('templates/footer');
	}
	
	/*
	 * Display the view to add a new car. 
	 */
	public function new_car()
	{
	  $this->load->helper(array('form', 'url'));
	  $this->load->library('form_validation');
	  
	  // Set up the default values.
	  $data['id'] = "";
	  $data['title'] = 'Add a new car';
	  $data['car_desc'] = "";
	  $data['car_year'] = "";
	  $data['car_model'] = "";
	  $data['car_make'] = "";
	  
	  $this->load->view('templates/header', $data);
	  $this->load->view('cars/edit', $data);
	  $this->load->view('templates/footer');
	}
}
