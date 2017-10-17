<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Wheelset extends MY_Model{
    const DB_TABLE = 'wheelsets';
    const DB_TABLE_PK = 'id';
    
    //Need to list out all the db fields here
    public $id;
    public $wheel_name;
    public $weight;
    public $tubular;
   // public $manufacturer;
   // public $cost;
    
    
    public function __construct(){
        parent::__construct();
       
    }
    
   
    
    
    
    public function density($alt="", $Tair="", $humidity=""){
	 	
		//This only takes into account altitude gain!!!!
		//Pressure dry 
		$P_dry =P_SEALEVEL*pow((1-(TEMP_LAPSE* feet2meters($alt))/T_SEALEVEL), (GRAVITY/(R_AIR*TEMP_LAPSE)));
		//THIS IS CORRECT (IDEAL GAS LAW)
		$t_rank = fariengheight2kelvin($Tair);
		$rho_dry = (($P_dry*1000)/(R_AIR*$t_rank));
		
		//Saturation pressure of wator vapor in air 
		////THIS IS GOOD
		$P_sat = exp((77.345+0.0057*$t_rank-7235/$t_rank))/pow($t_rank,8.2);
		
		$Pw = ($humidity/100)*$P_sat;
		
		$x = 0.62198*$Pw / (($P_dry*1000)-$Pw);
		
		$rho_actual = $rho_dry *((1+$x)/(1+1.609*$x));
		//This is some empherical ratio to determine actual density based on humidity ratio
		
		//populate output table:
		$data['P_sat']=$P_sat;
		$data['P_dry']=$P_dry;
		$data['$Pw']=$Pw;
		$data['x']=$x;
		$data['rho_dry']=$rho_dry;
		$data['rho_actual']=$rho_actual;
		
		return($data);
	 }
	 
	 
	 
	 
	 
	 
	 
	 
	 public function getweather($zip_code=NULL){
	 	/*
	 	/  Key ID
		/
		/3b0387fbc9acfc15
		/Project Name
		/
		/Bike Wheel Selector
		*/
	 	
	 	$api_key = '3b0387fbc9acfc15';
		$url = 'http://api.wunderground.com/api/'.$api_key;
				
		//$this->form_validation->set_rules('zip_code', 'Zip Code', 'required|min_length[5]|max_length[5]');
	 			
	 //	if ($this->form_validation->run()==FALSE){
	 //		$this->session->set_flashdata('message', validation_errors('<p class = "error">','</p>'));
	 //		redirect('wheels');
	 		
	 //	}else{ 
	 		
				
				$url .='/conditions/q/'.$zip_code.'.json';
				
			 	$weather = file_get_contents($url);
			 	$weather = json_decode($weather);
				
				if(isset($weather->response->error->description)){
						$this->session->set_flashdata('message', 'Zip Code not found');
						return FALSE;
				}
				//preprint($weather);
				$data['zip_code']=$zip_code;
				$data['city_name'] = $weather->current_observation->display_location->full;
			 	$data['wind_degrees'] = $weather->current_observation->wind_degrees;
			 	$data['wind_speed'] = $weather->current_observation->wind_mph;
			 	$data['pressure_in'] = $weather->current_observation->pressure_in;
			 	$data['alt'] = $weather->current_observation->display_location->elevation;
			 	$data['temp_f']= $weather->current_observation->temp_f;
			 	$data['relative_humidity']= (int)trim($weather->current_observation->relative_humidity, "%");
			 	
			 	
			 	
			 	$data['density_data'] = $this->wheelset->density($data['alt'],$data['temp_f'],$data['relative_humidity']);
				
				return($data);
			
	 		}
	 		
	 		
	 		
	 		
	 public function calculate_work($data=NULL, $wheelsets = NULL){
	 	echo "HELLO THERE CHILDREN, I just ran the work calc function";
	 	$data['rho']=$data['density']['rho_actual'];
	 	
	 	//create variables to fill out with results
	 	$results = array();
	 	
	 	
	 	$baselinewheel = Wheelset::find_by_id(1);
	 	//Recall wheel ID = 0 is ALWAYS 1
	 	foreach($wheelsets as $wheel){
	 		$id = $wheel->id;
	 		$adjusted_CdA =$this->wheel_adjust_cda($wheel, $data['timeWeighted_CdA'], $baselinewheel);
	 		
	 		//echo $wheel->wheel_name;
	 		$total_weight = $data['bike_weight']+$data['rider_weight']+$wheel->weight/1000;
	 		
	 		$w_climb = $total_weight * GRAVITY * $data['climbing'];
	 	
	 		$w_wind=(1/2) * $data['rho'] * pow($data['v_avg'], 2) * $adjusted_CdA * $data['distance'];
	 		$w_tot=$w_climb+$w_wind;
	 		$pow_avg = $w_tot/(($data['distance']/1000/($data['v_avg']/0.2777778))*3600);
	 		
	 		//populate wheel-indexed array of all the data to output
	 		//also change the work values to kJ instead of just jules
	 		$results[$id] = array(
	 			'pow_avg' => $pow_avg,
	 			'w_tot' => $w_tot/1000,
	 			'w_climb' => $w_climb/1000,
	 			'tot_weight' => $total_weight,
	 			'CdA' => $adjusted_CdA);
	 		
	 		//$total_weights[$wheel->id] = $this-
	 	}
	 	
	 	preprint($results);
	 	preprint($data);
	 	preprint($wheelsets);
	 	
	 	return $results;
	 }
	 
	 
	 //This is a way to adjust how each wheelset impacts 
	 public function wheel_adjust_cda($wheel = NULL, $riderCdA = NULL, $baselinewheel =NULL){
	 	//need to figure out what baseline CdA is
	 	//subtract the baseline cda from time weighted cda
	 	//Add new wheelset cda to the time weighted $cda
	 	
	 	$wind_adjusted_wheel_cda = $this->wind_cor_wheel_cda($wheel);

	 	$wind_adjusted_baselinewheel_cda = $this->wind_cor_wheel_cda($baselinewheel);
	 	
	 	//Add adjustments to compensate for front/wheel rear compensation
	 	//current calculation just does the calculation adjustemt for a wheel by iteslf in
	 	//wind tunnel
	 	
	 	$adjusted_CdA = $riderCdA - $wind_adjusted_baselinewheel_cda + $wind_adjusted_wheel_cda;
	 	
	 	return $adjusted_CdA;
	 }
	 
	 
	 
	 
	 
	 public function wind_cor_wheel_cda($wheel = NULL){
	 	$wheel_drag = Wheelset_drag::find_by('wheelset_id', $wheel->id);
	 	preprint($wheel_drag);
	 	//Dummy calculate drag for zero
	 	return $wheel_drag->deg0;
	 }
	 
	 
	 
	 
	 public function weighted_cda_averages($cda_data, $weighing_array){
	 	
	 	$cda =  $cda_data['cda_drops']*$weighing_array['drops'];
	 	$cda += $cda_data['cda_hoods']*$weighing_array['hoods'];
	 	$cda += $cda_data['cda_tops']*$weighing_array['tops'];
	 	$cda += $cda_data['cda_tt']*$weighing_array['tt'];
	 	
	 	return $cda;
	 	
	 }
	 
	 public function estimate_rider_cda($m_rider, $height){
	 	//takes mass
	 	
	 	//good reference to cda analysis: https://www.cyclingpowerlab.com/CyclingAerodynamics.aspx
	 	
	 	
	 	//This only returns CdA for respective positions
	 	//Need another function in order to claculate 'effective' cdA, or some sort of algo for differnet positions
	 	
	 	
	 	// Rider Cd estimate
		$BSA = 0.007184 * pow($m_rider, 0.425) * pow($height, 0.725);
		//http://olivernash.org/2014/05/25/mining-the-strava-data/cycling_drag_force.pdf
		//
		
		// Body surface estimate form Du Bois method
		$FA_drops = 0.18 * $BSA;
		// Linear correlation of BSA to cyclist frontal area from paper on hour records
		// this is for drops, need to correlate back out to which riding position you're in
		
		$cd_tops = 1.15;
		$cd_hoods = 1;
		$cd_drops = 0.88;
		$cd_tt = 0.70;
		
		$FA_base = $FA_drops / 0.37;
		$FA_hoods = $FA_base* 0.43;
		$FA_tops = $FA_base * 0.65;
		$FA_tt = $FA_base * 0.34;
		
		$data['cda_drops'] = $FA_drops * $cd_drops;
		$data['cda_hoods'] = $FA_hoods * $cd_hoods;
		$data['cda_tops'] = $FA_tops * $cd_tops;
		$data['cda_tt'] = $FA_tt * $cd_tt;
		
		
		return $data;
		// Weighted average of time spent here
		//$A = average(array($A_tops, $A_drops, $A_hoods));

	 }
}

