<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Wheels extends MY_Controller {

	/**
	 * Index Page for this controller.
	 */
	 
	 function __construct(){
	 	parent::__construct();
	 	$this->load->model('post');
	 	$this->load->library(array('ion_auth','form_validation'));
		$this->load->helper(array('url','language', 'constants', 'form'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		
	 }
	 public function index(){
	 	$data['title']='Wheel Calculation Input';
	 	
	 	$data['air_temp']=array(
	 			'name'=>'air_temp',
	 			'type'=>'number'
	 			
	 		);
	 	$data['distance']=array(
	 			'name'=>'distance',
	 			'type'=>'number'
	 			
	 		);
	 	$data['climbing']=array(
	 			'name'=>'climbing',
	 			'type'=>'number'
	 			
	 		);
	 		$data['humidity']=array(
	 			'name'=>'humidity',
	 			'type'=>'number'
	 			
	 		);
	 		$data['bike_weight']=array(
	 			'name'=>'bike_weight',
	 			'type'=>'number'
	 			
	 		);
	 		$data['wheelset']=array(
	 			'name'=>'wheelset'
	 		);
	 		$data['wheelset_options']=array(
	 			'44mm'=>'44mm Boyd',
	 			'60mm'=>'60mm Boyd',
	 			'90mm'=>'90mm Boyd',
	 			);
	 		$data['ride_type_options']=array(
	 			'solo'=>'Solo Ride',
	 			'group'=>'Group Ride'
	 			);
	 		$data['ride_type']=array(
	 			'name'=>'ride_type',
	 			);
	 		$data['rider_weight']=array(
	 			'name'=>'rider_weight',
	 			'type'=>'number',
	 		);
	 		$data['rider_height']=array(
	 			'name'=>'rider_height',
	 			'type'=>'number',
	 		);
	 	
	     $this->load->view('dressings/header');
	     $this->load->view('wheel_input', $data);
	     $this->load->view('dressings/footer');
	     
	    
	     
	 }
	 public function density(){
	 	
	 }
	 //Will reassign this to density calculator
	 public function wheel_calc(){
	 	
	 }

  }