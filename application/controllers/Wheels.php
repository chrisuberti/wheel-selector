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
		
		
		$data['title']='Wheelsets - '.$this->config->item('site_title', 'ion_auth');
		
		$this->load->vars($data);
	 }

	 	
	 	
	 
	 public function index(){

	 	
	 	
	 	$data['title']='Wheel Calculation Input';
	 
	 	
	 	$data['air_temp']=array(
	 			'name'=>'air_temp',
	 			'type'=>'number',
	 			'placeholder'=>'Current air temp'
	 			
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
	 			'placeholder'=>'Altitude of segment'
	 			
	 		);
	 		$data['humidity']=array(
	 			'name'=>'humidity',
	 			'type'=>'number',
	 			'placeholder'=>'Enter Relative Humidity'
	 			
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
	 			
	 			
	 	if(isset($_POST['weather_submit']) || isset($_POST['wheel_submit'])){
		 	if(isset($_POST['zip_code'])){
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
		 	}elseif(isset($_POST['wheel_submit'])){
		 		//the Overall wheel calculation button has been pressed
		 		$this->form_validation->set_rules('air_temp', 'Air Temperature', 'required|less_than[130]|greater_than[-20]');
		 		$this->form_validation->set_rules('distance', 'Distance', 'required|greater_than[0]');
		 		$this->form_validation->set_rules('altitude', 'Altitude', 'required|less_than[29000]|greater_than[0]');
		 		$this->form_validation->set_rules('humidity', 'Humidity', 'required|less_than[100]|greater_than[0]');
		 		
		 		if($this->form_validation->run()){
			 		$altitude = $this->input->post('alttitude');
			 		$humidity = $this->input->post('humidity');
			 		$Tair = $this->input->post('air_temp');
			 		
			 		$density = $this->wheelset->density($altitude, $Tair, $humidity);
		 		}
		 		$this->form_validation->set_rules('rider_weight', 'Rider Weight', 'required|greater_than[0]');
		 		$this->form_validation->set_rules('rider_height', 'Rider Height', 'required|greater_than[0]');
		 		$this->form_validation->set_rules('bike_weight', 'Bike Weight', 'required|greater_than[0]');
		 		
		 		echo "hey this is a test";
	 		break;
		 		
		 	}

	     
		}
		$this->load->view('dressings/header');
	    $this->load->view('wheel_input', $data);
	    $this->load->view('dressings/footer');
	     
	    
	 }
	 
	 public function all_wheelsets(){
	 	    	if (!$this->ion_auth->logged_in()){
			redirect('auth/login', 'refresh');
		}else{
			$this->table->set_template(array('table_open'=>"<table class='table table-striped table-bordered table-hover' id='post_summary_table'>"));
			$this->table->set_heading('Wheelset',array('data'=>'&nbsp', 'style'=>'width:20%'), 'Manufacturer', 'Weight', '');
				
			$wheelsets = $this->wheelset->find_all();
			if($wheelsets){
				foreach($wheelsets as $wheeleset){
					$wheel_drag = $this->wheelset_drag->find_by_id($wheelset->id);
					$title = $wheelset->wheel_name . "<br>".anchor('wheels/edit_wheelset/'.$wheelset->id, 'Edit', array('class'=>'btn btn-success'));
					$picture = "blank";
					$wheel_mfg = $wheelset->manufacturer; 
					$wheel_weight = $wheelset->weight;
					
					$del_button = form_open('wheels/del_wheelset/'.$wheelset->id);
	    			$del_button .= form_submit('del_wheelset', 'Delete', array('class'=>'btn btn-danger',"onClick"=>"return deleteconfirm();"));
	    			$del_button .= form_close();
					
					$this->table->add_row($wheel_name, $picture, $wheel_mfg, $wheel_weight);
					
				}
				$data['wheelset_table']=$this->table->generate();
			}else{
				$data['wheelset_table']="<br> There are no Wheels yet add some wheels";
			}
			$this->load->view('wheel_admin/all', $data);
		}
			
	}
		
	
	 
	 public function edit_wheelset($id=NULL){
    	if (!$this->ion_auth->logged_in()){
			redirect('auth/login', 'refresh');
		}else{
			
			if($id == NULL){
				$this->session->set_flashdata('message', 'No Photo Found');
				
				redirect('wheels/new_wheelset');
			}elseif($wheelset = Wheelset::find_by_id($id)){
				if(isset($_POST['submit'])){
					$wheelset->name = $_POST['name'];
					$wheelset->weight = $_POST['weight'];
					$wheelset->tubular = $_POST['tubular'];
					$wheelset->caption = $_POST['caption'];
					$wheelset->visible = $_POST['visible'];
					$wheelset->save();
				}
				
        		

				$data['del_button']=anchor("wheels/del_wheelset/".$photo->id, "Delete", array('class'=>'btn btn-danger','onClick'=>"return deleteconfirm();"));
				$this->load->view('admin/edit_wheelset', $data);
    		}
		}
    }

	
	 
	
	 	

  }
  