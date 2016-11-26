<?php
//class Constants{

//List of constants that can be used throughout the program
$grav = 9.8067; //m/s
$MMair = 28.965; //g-mol-1
$R_air = 287.06; //J-kg-1 K-1
$TempLapse = 0.0065; //K/m
$T_sl = 288.15;
$P_sl = 101.33; //Sea Level standard pressure kPa




//convert meters to feet;
function feet2meters($ft){return $ft*0.3048;}

//
function inHg2kPa($p){return $p*3.38639;}

//convert celcius to farienheight
function celcius2farienheight($cel){return 1.8*$cel+32;}
function fariengheight2kelvin($t){return Rankine($t)*0.555556;}

function Rankine($t){return $t+459.7;}
function Kelvin($c){return $c+273.15;}

function TotalMass($rider, $bike){return $bike+$rider;}

function densityCalc($Tair, $humidity, $alt){
	global $grav, $MMair, $R_air, $TempLapse, $T_sl, $P_sl;
	
	

	//This only takes into account altitude gain!!!!
	//Pressure dry 
	$P_dry =$P_sl*pow((1-($TempLapse* feet2meters($alt))/$T_sl), ($grav/($R_air*$TempLapse)));
	//THIS IS CORRECT (IDEAL GAS LAW)
	$t_rank = fariengheight2kelvin($Tair);
	$rho_dry = (($P_dry*1000)/($R_air*$t_rank));
	
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
	
	
	return $data;
}

//function densityCalc($Tair, $humidity, $alt, $P_a){
//	global $grav, $MMair, $R_air, $TempLapse, $T_sl, $P_sl;
//	//convert units:
//	$t_rank = fariengheight2kelvin($Tair);
//	$P_a = inHg2kPa($P_a);
//
//	//populate output table:
//	$data['P_a']=$P_a;
//	$data['P_sat']=$P_sat;
//	$data['P_dry']=$P_dry;
//	$data['P_vap']=$P_vap;
//	$data['x']=$x;
//	$data['rho_dry']=$rho_dry;
//	$data['rho_actual']=$rho_actual;
//	
//	
//	return $data;
//}





?>