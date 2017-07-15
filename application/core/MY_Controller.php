<?php

class MY_Controller extends CI_Controller {
    function __construct(){
        parent::__construct();
        		$this->load->library(array('form_validation'));
		$this->load->helper(array('language'));
		$this->load->library('table');

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        if (!$this->ion_auth->logged_in()){	redirect('auth/login', 'refresh');	}
        
    }
    
    
    
    
    
    /**
     * 
     *This section below is for functions that need to be accessable via all controllers (similar to a library section) 
     * 
     * 
     * 
     * **/
     function  pretty_date ( $date_in )  {
        if (strlen ($date_in) != 19)
            return $date_in;        // return in confusion!

        $hh = substr ($date_in, 11, 2);
        $mm = substr ($date_in, 14, 2);

        if ($mm > 30)
            $hh++;

        if ( ($hh > 23) OR ($hh == '00'))
            $hh_string = "midnight";
        else
            if ($hh > 12)
                $hh_string = ($hh - 12) ."pm";
            else
                if ($hh == 12)
                    $hh_string = "midday";
                else
                    $hh_string = $hh ."am";

        $output = substr ($date_in, 0, 10) ." ~ ". $hh_string;

        return $output;
   } 
     
}