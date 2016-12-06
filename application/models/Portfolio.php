<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Portfolio extends MY_Model{
    const DB_TABLE = 'portfolios';
    const DB_TABLE_PK = 'id'; //primary key
    
    public $id;
    public $portfolio_name;
    public $current_cap;
    public $beginning_cap;
    public $last_trade;
    public $starting_date;
    public $user_id;
    public $commision;
    public $commision_bool;
    
    public function __construct(){
        parent::__construct();
       
    }


    
}