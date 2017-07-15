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
}

