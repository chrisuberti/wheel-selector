<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Stock extends MY_Model{
    const DB_TABLE = 'trades';
    const DB_TABLE_PK = 'id'; //primary key

    const YAHOO_BASE_URL = "http://finance.yahoo.com/webservice/v1/";
    
    
    public $id;
    public $user_id;
    public $portfolio_id;
    public $symbol;
    public $purchase_time;
    public $purchase_price;
    public $shares;
    public $sale_time;
    public $sale_price;
    
   //public $stocks=array();
    
    public function __construct(){
        parent::__construct();
       
    }
    
    public function live_quotes($stocks=array()){
        $url ="http://finance.yahoo.com/webservice/v1/". "symbols/";
        $num_stocks = count($stocks);
        
            for($i=0;$i<$num_stocks; $i++){
               if($i<$num_stocks-1){
                    $url .= $stocks[$i].",";
                }else{
                    $url .= $stocks[$i]."/";
                }
            }
            $url .= "quote?format=json";
            $ch = curl_init($url);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);	    
	        $results = json_decode(curl_exec($ch), true);
	        $quotes=$results['list']['resources'];
	        for($i=0;$i<count($quotes); $i++){
	            $quotes_array["{$i}"] = $quotes["{$i}"]['resource']['fields'];
	        }
	        return ($quotes_array);
    }
    
    public function single_quote($symbol=""){
        //this only returns information for a single stock
        //This could possibly be accomplished by the above function alone
        $url = "http://finance.yahoo.com/webservice/v1/" . "symbols/";
        $url .= $symbol."/quote?format=json";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);	    
        $results = json_decode(curl_exec($ch), true);
        $quotes=$results['list']['resources'][0]['resource']['fields'];
        return ($quotes);
        
    }
    public function get_price($symbol=""){
        //this only returns information for a single stock
        //This could possibly be accomplished by the above function alone
        $url = "http://finance.yahoo.com/webservice/v1/" . "symbols/";
        $url .= $symbol."/quote?format=json";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);	    
        $results = json_decode(curl_exec($ch), true);
        $quotes=$results['list']['resources'][0]['resource']['fields'];
        return ($quotes['price']);
        
    }
}
    
