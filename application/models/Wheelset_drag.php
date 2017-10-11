<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Wheelset_drag extends MY_Model{
    const DB_TABLE = 'wheelset_drag';
    const DB_TABLE_PK = 'id';
    
    //Need to list out all the db fields here
    public $id;
    public $wheelset_id;
    public $deg0;
    public $deg5;
    public $deg10;
    public $deg15;
    public $deg20;
    
    
    public function __construct(){
        parent::__construct();
       
    }
}

