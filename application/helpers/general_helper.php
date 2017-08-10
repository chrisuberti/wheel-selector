  <?php

//General set of custom functions to be used for this project helper fiel
function asset_url(){return base_url().'assets/';}

function img_url(){return base_url().'assets/imgs/';}

function  pretty_date ( $date_in )  {
    if (strlen ($date_in) != 19)
        return $date_in;        // return in confusion!

    $hh = substr ($date_in, 11, 2);
    $mm = substr ($date_in, 14, 2);
    $date_in = strtotime($date_in);

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

    $output = date("D", $date_in). ' ';
    $output .= date("F", $date_in). ' ';
    $output .= date("j", $date_in). ' ';
    $output .= date("Y", $date_in). ' ';
    $output .= " -- ". $hh_string;

    return $output;
} 
 

function preprint($arr){
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
}

function print_money($value){
    return money_format('$%i',$value);
}

function percentage($value){
    return round((float)$value * 100, 3) . '%';
}


function sanitize_filename($string, $force_lowercase = true, $anal = false) {
    $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
                   "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
                   "â€”", "â€“", ",", "<", ".", ">", "/", "?");
    $clean = trim(str_replace($strip, "", strip_tags($string)));
    $clean = preg_replace('/\s+/', "-", $clean);
    $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;
    return ($force_lowercase) ?
        (function_exists('mb_strtolower')) ?
            mb_strtolower($clean, 'UTF-8') :
            strtolower($clean) :
        $clean;
}

function output_message($messages=""){
	$return_str = "";
	if (!empty($messages) && is_array($messages)) {
		foreach ($messages as $message) {
			$return_str .= "<p class \"message\">{$message}</p>";
		} 
		return $return_str;
	}elseif(!empty($messages)){
		return "<p class \"message\">{$messages}</p>";
	}
		return "";
}
	
function makeDir($path){
	return is_dir($path) || mkdir($path);
}