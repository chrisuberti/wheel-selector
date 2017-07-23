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
	 			'value'=> set_value('air_temp', 10)
	 			
	 		);
	 	
	 	 
	 	//$value = isset('weather_submit') && isset($this->session->flashdata('weather_data')) 
	 	
	 	
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
	 		$data['zip_code']=array(
	 			'name'=>'zip_code',
	 			'value'=>set_value('zip_code'),
	 			'type'=>'number');
	 			
	 			
	 	if(isset($_POST['weather_submit'])){
	 		$this->form_validation->set_rules('zip_code', 'Zip Code', 'required|min_length[5]|max_length[5]');
	 		if($this->form_validation->run() == FALSE){
	 			//zip code form validation fails
	 		}else{
	 			//zip code form validation is successful
	 			$weather_data = $this->wheelset->getweather($_POST['zip_code']);
	 			$data['air_temp']['value']=$weather_data['temp_f'];
		 	 	$data['altitude']['value']=$weather_data['alt']; 
		 	 	$data['humidity']['value']=$weather_data['relative_humidity']; 
		 	 	$data['zip_code']['value']=$weather_data['zip_code']; 
	 		}
	 		
	 	}
	 	if(isset($_POST['wheel_submit'])){
	 		//the Overall wheel calculation button has been pressed
	 		$this->form_validation->set_rules('air_temp', 'Air Temperature', 'required');
	 		$this->form_validation->set_rules('distance', 'Distance', 'required');
	 		$this->form_validation->set_rules('altitude', 'Altitude', 'required');
	 		$this->form_validation->set_rules('bike_weight', 'Bike Weight', 'required');
	 		$this->form_validation->set_rules('humidity', 'Humidity', 'required');
	 		$this->form_validation->set_rules('rider_weight', 'Rider Weight', 'required');
	 		$this->form_validation->set_rules('rider_height', 'Rider Height', 'required');
	 		
	 		
	 		
	 	
	 	}
	 	$this->load->view('dressings/header');
	     $this->load->view('wheel_input', $data);
	     $this->load->view('dressings/footer');
	     
	    
	     
	 }

	 //Will reassign this to density calculator
	 public function wheel_calc(){
	 	
	 }
	 
	
	 	

  }
  