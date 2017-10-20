<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Calc extends MY_Controller {

	 public function __construct(){
	 	parent::__construct();
	 	$this->load->model(array('wheelset'));
	 	$this->load->library(array('form_validation', 'table'));
		$this->load->helper(array('url','language', 'constants', 'form'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		
		
		$data['title']='Wheelsets - '.$this->config->item('site_title', 'ion_auth');
		
		$this->load->vars($data);
	 }

	 	 	
	 
	 public function index(){
		if (!$this->ion_auth->logged_in()){
			$data['logged_in']=FALSE;
		}else{
			$data['logged_in']=TRUE;
		}
	 	//Block of code dictating the input fields for the CI forms of wheels/input
		$data['title']='Wheel Calculation Input';
		$data = array_merge($data, $this->input_fields());
		
	 	//Create function in controller to build out display table of drag metrics
	 			
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
		 			$ride_data['climbing'] = feet2meters($this->input->post('climbing'));
			 		$ride_data['distance'] = mi2m($this->input->post('distance'));
			 		$ride_data['bike_weight'] = $this->input->post('bike_weight');
			 		$ride_data['rider_weight'] = lbs2kg($this->input->post('rider_weight'));
			 		$ride_data['rider_height'] = in2meters($this->input->post('rider_height'));
			 		$ride_data['v_avg'] = mph2ms($this->input->post('v_avg'));
			 		$ride_data['selected_wheelset'] = $this->input->post('wheelset');
			 		$pos_time['drops']=substr($this->input->post('amt_drops'), 0, -1)/100;
			 		$pos_time['hoods']=substr($this->input->post('amt_hoods'), 0, -1)/100;
			 		$pos_time['tops']=substr($this->input->post('amt_tops'), 0, -1)/100;
			 		$pos_time['tt']=0.0;
			 		
			 		$ride_data['density']= $this->wheelset->density($altitude, $Tair, $humidity);
			 		$cda_data = $this->wheelset->estimate_rider_cda($ride_data['rider_weight'], $ride_data['rider_height']*100);
			 		$ride_data['time'] = $ride_data['distance']/$ride_data['v_avg'];
			 		$ride_data['timeWeighted_CdA']=$this->wheelset->weighted_cda_averages($cda_data, $pos_time);
			 		
			 		$work_req = $this->wheelset->calculate_work($ride_data, Wheelset::find_all());
			 	}
		 	}
		}
		//Create table of results form the work calc function (maybe create indepndent function within controller to do this)
		if(isset($work_req)){ $data['output_table'] = $this->output_table_gen($work_req, $ride_data['selected_wheelset']);}
		
		//Create plot function of wheelset data
		
	    $this->load->view('wheel_input', $data);
	    $this->load->view('dressings/footer');
	     
	    
	 }
	 
	 
	 
	 
	 public function output_table_gen($data = NULL, $ref_ws_id = NULL){
	     //ideally would like to make this table sortable -- for future reference
	     $table = "<table data-toggle='table' class='table table-striped table-bordered table-hover' id='post_summary_table'><thead><tr>";
	     $table .= "<th data-sortable = 'true'>Wheelset</th>";
	     $table .= "<th data-sortable = 'true'>Total Work (kJ)</th>";
	     $table .= "<th data-sortable = 'true'>Average Power (Watts)</th>";
	     $table .= "<th data-sortable = 'true'>Climbing Work (kJ)</th>";
	     $table .= "<th data-sortable = 'true'>Air Resistance Work (kJ)</th>";
	     $table .= "<th data-sortable = 'true'>Total Weight (kg)</th>";
	     $table .= "<th data-sortable = 'true'>CdA</th>" . "</tr></head>";
	     $table .= "<tbody>";
	     
	     //Re-order array
		foreach($data as $id => $run_data){
		    $the_wheelset = Wheelset::find_by_id($id);
		    $wheel_name = $the_wheelset->wheel_name;
		    if($id == $ref_ws_id){
		    	$table .= "<tr class = 'success'>";
		    }else{
		    	$table .= "<tr>";
		    }
		    $table .= "<td>".$wheel_name."</td><td>".pretty_num($run_data['w_tot'])."</td><td>".pretty_num($run_data['pow_avg'])."</td><td>".pretty_num($run_data['w_climb']);
		    $table .= "</td><td>".pretty_num($run_data['w_air'])."</td><td>".pretty_num($run_data['tot_weight'])."</td><td>".number_format($run_data['CdA'], 4, '.','' )."</td>";
			$table .= "</tr>";
			
			
		    //<tr class="success">...</tr> 
		    //might need to undue the CI table function to have a little more control over the inputs
		}
		$table .= "</tbody></table>";
		
		return $table;
	 }
	 
	 
	 
	 
	 
	 public function input_fields(){
	    $data['air_temp']=array('name'=>'air_temp','type'=>'number','value'=>set_value('air_temp'),'placeholder'=>'Currentairtemp');
		$data['distance']=array('name'=>'distance','type'=>'number','value'=>set_value('distance'));
		$data['climbing']=array('name'=>'climbing','type'=>'number','value'=>set_value('climbing'));
		$data['altitude']=array('name'=>'altitude','type'=>'number','placeholder'=>'Altitudeo f segment','value'=>set_value('altitude'));
		$data['humidity']=array('name'=>'humidity','type'=>'number','placeholder'=>'Enter Relative Humidity','value'=>set_value('humidity'));
		$data['bike_weight']=array('name'=>'bike_weight','type'=>'number','placeholder'=>'Minus Wheels','value'=>set_value('bike_weight'));
		$data['wheelset']=array('name'=>'wheelset');
		$wheelsets=$this->wheelset->find_all();
		$data['wheelset_options']=array();
		if($wheelsets){foreach($wheelsets as $wheel_info){$data['wheelset_options'][$wheel_info->id]=$wheel_info->wheel_name;}}
		$data['ride_type_options']=array('solo'=>'Solo Ride','group'=>'Group Ride','value'=>set_value('wheelset_options'));
		$data['ride_type']=array('name'=>'ride_type');
		$data['rider_weight']=array('name'=>'rider_weight','type'=>'number','value'=>set_value('rider_weight'));
		$data['rider_height']=array('name'=>'rider_height','type'=>'number','value'=>set_value('rider_height'));
		$data['zip_code']=array('name'=>'zip_code','value'=>set_value('zip_code'),'type'=>'number');
		$data['v_avg']=array('name'=>'v_avg','value'=>set_value('v_avg'),'type'=>'number', 'placeholder'=>'Average Speed');
		$data['amt_tops']=array('name'=>'amt_tops','id'=>'amt_tops','value'=>set_value('amt_tops'));
		$data['amt_hoods']=array('name'=>'amt_hoods','id'=>'amt_hoods','type'=>'text','value'=>set_value('amt_hoods'));
		$data['amt_drops']=array('name'=>'amt_drops','id'=>'amt_drops','type'=>'text','value'=>set_value('amt_drops'));
		 
	 	$data['all_wheelsets'] = Wheelset::find_all();
	 	return $data;
	 }
}	