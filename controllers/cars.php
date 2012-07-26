<?php
class Cars extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
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

	public function index()
	{
	  $this->load->helper('url');
	  
	  $data['cars'] = $this->cars_model->get_cars();
	  $data['title'] = 'List of cars';

	  $this->load->view('templates/header', $data);
	  $this->load->view('cars/index', $data);
	  $this->load->view('templates/footer');
	}
	
	public function save()
	{
	  $this->load->helper(array('form', 'url'));
	  $this->load->library('form_validation');
	  
	  $this->form_validation->set_error_delimiters('<div class="error">', '</div>');	  
	  $this->form_validation->set_rules('car_desc', 'Description', 'required');
		$this->form_validation->set_rules('car_year', 'Year', 'exact_length[4]|numeric|required');
		$this->form_validation->set_rules('car_make', 'Make', 'required');
		$this->form_validation->set_rules('car_model', 'Model', 'required');

	  if ($this->form_validation->run() == FALSE) {
	    $data['title'] = 'Add a new car';
	    $data['car_desc'] = $_POST['car_desc'];
	    $data['car_year'] = $_POST['car_year'];
	    $data['car_make'] = $_POST['car_make'];
	    $data['car_model'] = $_POST['car_model'];
	    $this->load->view('templates/header', $data);
	    $this->load->view('cars/edit', $data);
	    $this->load->view('templates/footer');
	  }
	  else {
	    
	    $id = $this->input->post('id');
	    $record = array(
	      'car_desc' => $this->input->post('car_desc'),
	      'car_year' => $this->input->post('car_year'),
	      'car_make' => $this->input->post('car_make'),
	      'car_model' => $this->input->post('car_model')
	      );
	    
	    if ($id == '') {
	      $this->cars_model->insert($record);
	    }
	    else {
	      $this->cars_model->update($id, $record);
	    }

	    $data['title'] = 'Car saved';
	    $this->load->view('templates/header', $data);
	    $this->load->view('cars/saved', $data);
	    $this->load->view('templates/footer');
	  }
	}

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
	
	public function edit($car_id)
	{
	  $this->load->helper('url');
 	  $cars_item = $this->cars_model->get_cars($car_id);

	  if (empty($cars_item)) {
	    show_404();
	  }

	  $this->load->helper(array('form', 'url'));
	  $this->load->library('form_validation');
	  
	  $cars_item['title'] = 'Edit car';
 
	  $this->load->view('templates/header', $cars_item);
	  $this->load->view('cars/edit', $cars_item);
	  $this->load->view('templates/footer');
	}
	
	public function new_car()
	{
	  $this->load->helper(array('form', 'url'));
	  $this->load->library('form_validation');
	  
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
