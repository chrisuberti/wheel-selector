<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Wheels extends MY_Controller {

	/**
	 * Index Page for this controller.
	 */
	 
	 function __construct(){
	 	parent::__construct();
	 	$this->load->model(array('post', 'wheelset'));
	 	$this->load->library(array('ion_auth','form_validation'));
		$this->load->helper(array('url','language', 'constants', 'form'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		
	 }
	 public function index(){
	 	$data['title']='Wheel Calculation Input';
	 	
	 	$data['air_temp']=array(
	 			'name'=>'air_temp',
	 			'type'=>'number',
	 			'value'=>70
	 			
	 		);
	 	$data['distance']=array(
	 			'name'=>'distance',
	 			'type'=>'number'
	 			
	 		);
	 	$data['climbing']=array(
	 			'name'=>'climbing',
	 			'type'=>'number'
	 			
	 		);
	 		$data['altitude']=array(
	 			'name'=>'altitude',
	 			'type'=>'number',
	 			'value'=>0
	 			
	 		);
	 		$data['humidity']=array(
	 			'name'=>'humidity',
	 			'type'=>'number',
	 			'value'=>50
	 			
	 		);
	 		$data['bike_weight']=array(
	 			'name'=>'bike_weight',
	 			'type'=>'number',
	 			'placeholder'=>'Minus Wheels'
	 			
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

	 //Will reassign this to density calculator
	 public function wheel_calc(){
	 	
	 }
	 
	 public function get_weather(){
	 	/*
	 	/  Key ID
		/
		/3b0387fbc9acfc15
		/Project Name
		/
		/Bike Wheel Selector
		/Company Website
		/
		/radical-design.us
		/Contact Phone
		/
		/Contact Email
		/
		/chris@radical-design.us
		/
	 	*/
	 	
		$api_key = '3b0387fbc9acfc15';
		
		
	 	$weather = file_get_contents('http://api.wunderground.com/api/3b0387fbc9acfc15/conditions/q/45214.json');
		$weather = json_decode($weather);
		//preprint($weather);
	 	$data['wind_degrees'] = $weather->current_observation->wind_degrees;
	 	$data['wind_speed'] = $weather->current_observation->wind_mph;
	 	$data['pressure_in'] = $weather->current_observation->pressure_in;
	 	$data['alt'] = $weather->current_observation->display_location->elevation;
	 	$data['temp_f']= $weather->current_observation->temp_f;
	 	$data['relative_humidity']= (int)trim($weather->current_observation->relative_humidity, "%");
	 	
	 	
	 	
	 	$data['density_data'] = $this->wheelset->density($data['alt'],$data['temp_f'],$data['relative_humidity']);
	 	preprint($data);
	 	return($data);
	 	//http://api.wunderground.com/api/3b0387fbc9acfc15/conditions/q/CA/San_Francisco.json
	 }

  }
  