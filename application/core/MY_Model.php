<?php

class MY_Model extends CI_Model{
    
  const DB_TABLE = 'abstract';
  const DB_TABLE_PK = 'abstract'; //primary key
  
  private static $db;
  
  /*
  SELF:: refers to the same class in which the keyword/variable/function is written i.e. if i use self in this file I will be referencing something within this file
  STATIC:: refers to whatever calss (i.e. )
  
  */
  
  //This is setup for an individual row...I think
  
  //create record
  function __construct(){
    parent::__construct();
    self::$db =&get_instance()->db;
  }
  
  static function find_all(){
		$query = self::$db->get(static::DB_TABLE)->custom_result_object(get_called_class());
	  $query = empty($query) ? false : $query;
	  return $query;
	}
	
	static function find_by_id($id = ""){
	  $query = self::$db->where('id', $id)->get(static::DB_TABLE)->custom_result_object(get_called_class());
	  return $query[0];
	}
	
	static function find_by($column = "", $column_val = ""){
	  $query = self::$db->where($column, $column_val)->get(static::DB_TABLE)->custom_result_object(get_called_class());
	  return $query;
	}
	  
  public function insert(){
      $this->db->insert(static::DB_TABLE, $this);
      $this->{static::DB_TABLE_PK} = $this->db->insert_id();
  }
  
  
  private function update(){
    $this->db->where('id', $this->{static::DB_TABLE_PK});
    $this->db->update(static::DB_TABLE, $this);
    
  }
  
  
  public function delete(){
    $this->db->delete(static::DB_TABLE, array(static::DB_TABLE_PK => $this->{static::DB_TABLE_PK},));
    unset($this->{static::DB_TABLE_PK});
  }  
  
  public function save(){
    if(isset($this->{static::DB_TABLE_PK})){
      $this->update();
    }
    else {
      $this->insert();
    }
  }
  
  static function get($limit=0, $offset = 0){
    if($limit){
      $query = self::$db->get(static::DB_TABLE, $limit, $offset);
    }else{
        $query = self::$db->get(static::DB_TABLE);
    }
    $ret_val = array();
    $class = get_called_class();
    foreach ($query->result() as $row){
        $model = new $class;
        $model->populate($row);
        $ret_val[$row->{static::DB_TABLE_PK}] = $model;
    }
    return $ret_val;
  }
}


?>