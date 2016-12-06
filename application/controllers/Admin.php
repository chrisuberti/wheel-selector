<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller{

	function __construct(){
	    parent::__construct();
		$this->load->library(array('form_validation'));
		$this->load->helper(array('url','language'));
		$this->load->model('stocks_model');

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
	}


}
