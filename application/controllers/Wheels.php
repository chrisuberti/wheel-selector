<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Wheels extends MY_Controller {

	/**
	 * Index Page for this controller.
	 */
	 
	 function __construct(){
	 	parent::__construct();
	 	$this->load->model(array('wheelset'));
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
	 			'value'=>set_value('air_temp'),
	 			'placeholder'=>'Current air temp'
	 			
	 		);
	
	 	$data['distance']=array(
	 			'name'=>'distance',
	 			'type'=>'number',
	 			'value'=>set_value('distance')
	 			
	 		);
	 	$data['climbing']=array(
	 			'name'=>'climbing',
	 			'type'=>'number',
	 			'value'=>set_value('climbing')
	 			
	 		);
	 		$data['altitude']=array(
	 			'name'=>'altitude',
	 			'type'=>'number',
	 			'placeholder'=>'Altitude of segment',
	 			'value'=>set_value('altitude')
	 			
	 		);
	 		$data['humidity']=array(
	 			'name'=>'humidity',
	 			'type'=>'number',
	 			
	 			'placeholder'=>'Enter Relative Humidity',
	 			'value'=>set_value('humidity')
	 			
	 		);
	 		$data['bike_weight']=array(
	 			'name'=>'bike_weight',
	 			'type'=>'number',
	 			'placeholder'=>'Minus Wheels',
	 			'value'=>set_value('bike_weight')
	 			
	 		);
	 		$data['wheelset']=array(
	 			'name'=>'wheelset'
	 		);
	 		
	 		
	 		$wheelsets = $this->wheelset->find_all();
	 		$data['wheelset_options'] = array();
			if($wheelsets){
				foreach($wheelsets as $wheel_info){
					$data['wheelset_options'][$wheel_info->id]=$wheel_info->wheel_name;
				}
			}
			//$data['wheelset_options']['value'] = set_value('wheelset_options');
			
			
			
	 		$data['ride_type_options']=array(
	 			'solo'=>'Solo Ride',
	 			'group'=>'Group Ride',
	 			'value'=>set_value('wheelset_options')
	 			);
	 		$data['ride_type']=array(
	 			'name'=>'ride_type',
	 			);
	 		$data['rider_weight']=array(
	 			'name'=>'rider_weight',
	 			'type'=>'number',
	 			'value'=>set_value('rider_weight')
	 		);
	 		$data['rider_height']=array(
	 			'name'=>'rider_height',
	 			'type'=>'number',
	 			'value'=>set_value('rider_height')
	 		);
	 		$data['zip_code']=array(
	 			'name'=>'zip_code',
	 			'value'=>set_value('zip_code'),
	 			'type'=>'number');
	 			
	 			
	 		$data['v_avg']=array(
	 			'name'=>'v_avg',
	 			'value'=>set_value('v_avg'),
	 			'type'=>'number');
	 			
	 			
	 		$data['amt_tops']=array(
	 			'name'=>'amt_tops',
	 			'id'=>'amt_tops',
	 			'value'=>set_value('amt_tops')
	 		);
	 		
	 		$data['amt_hoods']=array(
	 			'name'=>'amt_hoods',
	 			'id'=>'amt_hoods',
	 			'type'=>'text',
	 			'value'=>set_value('amt_hoods')
	 		);
	 		
	 		$data['amt_drops']=array(
	 			'name'=>'amt_drops',
	 			'id'=>'amt_drops',
	 			'type'=>'text',
	 			'value'=>set_value('amt_drops')
	 		);
	 		
	 		$data['all_wheelsets'] = Wheelset::find_all();
	 	
	 		
	 			
	 			
	 	if(isset($_POST['weather_submit']) || isset($_POST['wheel_submit'])){
		 	if(isset($_POST['zip_code']) && isset($_POST['weather_submit'])){
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
 	 			$this->form_validation->set_rules('rider_weight', 'Rider Weight', 'required|greater_than[0]');
		 		$this->form_validation->set_rules('rider_height', 'Rider Height', 'required|greater_than[0]');
		 		$this->form_validation->set_rules('bike_weight', 'Bike Weight', 'required|greater_than[0]');
		 		$this->form_validation->set_rules('v_avg', 'Average Speed', 'required|greater_than[0]');
		 		
		 		if($this->form_validation->run()==FALSE){
		 			//weather data fails
		 		}else{
			 		$altitude = $this->input->post('alttitude');
			 		$humidity = $this->input->post('humidity');
			 		$Tair = $this->input->post('air_temp');
	
		 		
			 		$ride_data['density']= $this->wheelset->density($altitude, $Tair, $humidity);
			 		$ride_data['climbing'] = feet2meters($this->input->post('climbing'));
			 		$ride_data['distance'] = $this->input->post('distance');
			 		$ride_data['bike_weight'] = $this->input->post('bike_weight');
			 		//input in lbs
			 		$ride_data['rider_weight'] = lbs2kg($this->input->post('rider_weight'));
			 		//input in inches
			 		$ride_data['rider_height'] = in2meters($this->input->post('rider_height'))*100;
			 		$ride_data['v_avg'] = mph2ms($this->input->post('v_avg'));
			 		
			 		$cda_data = $this->wheelset->estimate_rider_cda($ride_data['rider_weight'], $ride_data['rider_height']);
			 		
			 		$pos_time['drops']=substr($this->input->post('amt_drops'), 0, -1);
			 		$pos_time['hoods']=substr($this->input->post('amt_hoods'), 0, -1);
			 		$pos_time['tops']=substr($this->input->post('amt_tops'), 0, -1);
			 		$pos_time['tt']=0.0;
			 		
			 		//Calculate a time weighted CdA value for the entire ride
			 		$ride_data['timeWeighted_CdA']=$this->wheelset->weighted_cda_averages($cda_data, $pos_time);
			 		//This should be improved later on to only use tops and hoods for climbing
			 		
			 		$work_req = $this->wheelset->calculate_work($ride_data, $wheelsets);
			 		
			 	
		 			
		 		}
		 	

		 		
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
			$this->table->set_heading('Wheelset',array('data'=>'&nbsp', 'style'=>'width:20%'), 'Weight', '');
				
			$wheelsets = $this->wheelset->find_all();
			//preprint($wheelsets);
			if($wheelsets){
				foreach($wheelsets as $wheel_info){
					
					$wheel_name = $wheel_info->wheel_name;
					$wheel_drag = Wheelset_drag::find_by('wheelset_id', $wheel_info->id);
					$title = $wheel_info->wheel_name . "<br>".anchor('wheels/edit_wheelset/'.$wheel_info->id, 'Edit', array('class'=>'btn btn-success'));
					$picture = "blank";
					//$wheel_mfg = $wheel_info->manufacturer; 
					$wheel_weight = $wheel_info->weight;
					
					$del_button = form_open('wheels/del_wheelset/'.$wheel_info->id);
	    			$del_button .= form_submit('del_wheelset', 'Delete', array('class'=>'btn btn-danger',"onClick"=>"return deleteconfirm();"));
	    			$del_button .= form_close();
	    			
	    								
					$edit_button = form_open('wheels/edit_wheelset/'.$wheel_info->id);
	    			$edit_button .= form_submit('edit_wheelset', 'Edit', array('class'=>'btn btn-success'));
	    			$edit_button .= form_close();
					
					$this->table->add_row($wheel_name, $picture, $wheel_weight, $del_button, $edit_button);
					
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
			
			$this->form_validation->set_rules('wheel_name', 'Wheel Name', 'required|max_length[255]');
			$this->form_validation->set_rules('weight', 'Weight', 'required|numeric|greater_than[0]');
			$this->form_validation->set_rules('tubular', 'Tubular', '');
			$this->form_validation->set_rules('deg0', 'CdA at 0 deg', 'required|numeric');
			$this->form_validation->set_rules('deg5', 'CdA at 5 deg', 'required|numeric');
			$this->form_validation->set_rules('deg10', 'CdA at 10 deg', 'required|numeric');
			$this->form_validation->set_rules('deg15', 'CdA at 15 deg', 'required|numeric');
			$this->form_validation->set_rules('deg20', 'CdA at 20 deg', 'required|numeric');
		
			if($id == NULL){
				$this->session->set_flashdata('message', 'No Photo Found');
				
				redirect('wheels/all_wheelsets');
			}elseif($wheelset_info = Wheelset::find_by_id($id)){
				//prepopulate information from edit 
				$data['name'] = $wheelset_info->wheel_name;
				$data['weight']=$wheelset_info->weight;
				$data ['tubular']=$wheelset_info->tubular;
				$data['wheelset_id']=$wheelset_info->id;
				$drag_data = Wheelset_drag::find_by('wheelset_id', $wheelset_info->id);
				
				$data['deg0'] = $drag_data->deg0;
				$data['deg5'] = $drag_data->deg5;
				$data['deg10'] = $drag_data->deg10;
				$data['deg15'] = $drag_data->deg15;
				$data['deg20'] = $drag_data->deg20;
				
				
				if(!empty($_POST)){
					
					preprint($_POST);
					$wheelset_info->wheel_name = $this->input->post('wheel_name');
					$wheelset_info->weight = $this->input->post('weight');
					$wheelset_info->tubular = $this->input->post('tubular')==NULL ? 0 : 1;
					$wheelset_info->save();
					
					$drag_data->deg0 = $this->input->post('deg0');
					$drag_data->deg5 = $this->input->post('deg5');
					$drag_data->deg10 = $this->input->post('deg10');
					$drag_data->deg15 = $this->input->post('deg15');
					$drag_data->deg20 = $this->input->post('deg20');
					$drag_data->save();
					
					$this->session->set_flashdata('message', 'Wheelset Successfully Updated');
					redirect('wheels/edit_wheelset/'.$wheelset_info->id);
				}
				
        		

				$data['del_button']=anchor("wheels/del_wheelset/".$wheelset_info->id, "Delete", array('class'=>'btn btn-danger','onClick'=>"return deleteconfirm();"));
				$this->load->view('wheel_admin/edit_wheelset', $data);
    		}
    		else{
    			$this->session->set_flashdata('message', 'No Wheelset Found');
    			redirect('wheels/all_wheelsets');
    		}
		}
    }
    
    
    	public function add_wheelset(){
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login', 'refresh');
			}else{
				$data['title']='Add new wheelset - '.$this->config->item('site_title', 'ion_auth');
				
				if(!empty($_POST)){	
					
					// redirect them to the home page because they must be an administrator to view this
					$this->form_validation->set_rules('wheel_name', 'Wheel Name', 'required|max_length[255]');
					$this->form_validation->set_rules('weight', 'Weight', 'required|numeric|greater_than[0]');
					$this->form_validation->set_rules('tubular', 'Tubular', '');
					$this->form_validation->set_rules('deg0', 'CdA at 0 deg', 'required|numeric');
					$this->form_validation->set_rules('deg5', 'CdA at 5 deg', 'required|numeric');
					$this->form_validation->set_rules('deg10', 'CdA at 10 deg', 'required|numeric');
					$this->form_validation->set_rules('deg15', 'CdA at 15 deg', 'required|numeric');
					$this->form_validation->set_rules('deg20', 'CdA at 20 deg', 'required|numeric');
					
					if ($this->form_validation->run()==FALSE){
						//not valid
						//These temporary info are used to re-populate fields
						$data['wheel_name'] = $this->input->post('wheel_name');
						$data['weight']= $this->input->post('weight');
						$data['tubular']= $this->input->post('tubular');
						$data['deg0']= $this->input->post('deg0');
						$data['deg5']= $this->input->post('deg5');
						$data['deg10']= $this->input->post('deg10');
						$data['deg15']= $this->input->post('deg15');
						$data['deg20']= $this->input->post('deg20');
						
						
							
						$this->load->view('wheel_admin/add_wheels', $data);
					}else{//form validation works
						$wheel_info = new Wheelset;
						$wheel_drag = new Wheelset_drag;
						
						$wheel_info->wheel_name = $this->input->post('wheel_name');
						$wheel_info->weight = $this->input->post('weight');
						$wheel_info->tubular = $this->input->post('tubular')==NULL ? 0 : 1;
						$wheel_info->save();
						
						$wheel_drag->wheelset_id = $wheel_info->id;
						$wheel_drag->deg0 = $this->input->post('deg0');
						$wheel_drag->deg5 = $this->input->post('deg5');
						$wheel_drag->deg10 = $this->input->post('deg10');
						$wheel_drag->deg15 = $this->input->post('deg15');
						$wheel_drag->deg20 = $this->input->post('deg20');
						$wheel_drag->save();
						
						$this->session->set_flashdata('message', '1 New Wheelset Added!');
						redirect('wheels/all_wheelsets');
					}
				}
				$this->load->view('wheel_admin/add_wheels', $data);
		}
	}
	
	
	public function del_wheelset($id=NULL){
    	if($id==NULL){
    		redirect('wheels/all_wheels');
		}else{
			$wheel = Wheelset::find_by_id($id);
			$drag_data = Wheelset_drag::find_by('wheelset_id', $id);
			
			if($wheel && $drag_data){
				$drag_data->delete();
				$wheel->delete();
				redirect('wheels/all_wheelsets');
			}else{
				$this->session->set_flashdata('Sorry, could not find comment');
				redirect('wheels/all_wheelsets');
				
			}
    	}
    }
	
    
     public function test(){
    	$this->load->view('dressings/header');
     	//echo ' 	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>				<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>"';


     	$this->load->view('test');
     	$this->load->view('dressings/footer');
		echo '<script src="'. asset_url().'js/slider.js"'. '\></script>';

     }


	
	 
	
	 	

  }
  