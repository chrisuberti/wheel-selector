<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Wheelset extends MY_Model{
    const DB_TABLE = 'wheelsets';
    const DB_TABLE_PK = 'id';
    
    //Need to list out all the db fields here
    public $id;
    public $wheel_name;
    public $weight;
    public $tubular;
    
    
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
}

