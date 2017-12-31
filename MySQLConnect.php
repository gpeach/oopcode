<?php
require 'MySQLResultSet.php';
require 'MySQLException.php';
////////////////////////////////////////////////////////////////////
/**
Implementation of connection class that more closely follows 
the singleton pattern.
*/
class MySQLConnect{
  //data members
  private static $instance = NULL;
  private $connection;
  const ONLY_ONE_INSTANCE_ALLOWED = 5000;

////////////////////////////////////////////////////////////////////
//constructor
////////////////////////////////////////////////////////////////////
/**
private constructor - called from static method getInstance
*/
  private function __construct($hostname, $username, $password){
    if(!$this->connection = mysql_connect($hostname, $username,$password )){
      throw new MySQLException(mysql_error(), mysql_errno());
    }
  }
////////////////////////////////////////////////////////////////////
//destructor
////////////////////////////////////////////////////////////////////
  public function __destruct(){
    $this->close();
  }
////////////////////////////////////////////////////////////////////
// public methods
////////////////////////////////////////////////////////////////////
/**
This static method creates an instance of the class if no 
instance already exists.
*/
  static public function getInstance($hostname, $username, $password){
    //instance must be static in order to be referenced here
    if(self::$instance == NULL ){
      self::$instance = new MySQLConnect($hostname, $username, $password);
      return self::$instance;
    }else{
      $msg = "Close the existing instance of the ".
        "MySQLConnect class.";
      throw new MySQLException($msg, self::ONLY_ONE_INSTANCE_ALLOWED);
    }
  }
////////////////////////////////////////////////////////////////////
  public function createResultSet($strSQL, $databasename){
    $rs = new MySQLResultSet($strSQL, $databasename, $this->connection );
    return $rs;
  }
//////////////////////////////////////////////////////////////////// 
  public function getConnection(){
    return $this->connection;
  }
//////////////////////////////////////////////////////////////////// 
  public function getVersionNumber(){
    //mysql_get_server_info
    return mysql_get_server_info();
  }
////////////////////////////////////////////////////////////////////
   public function close(){
    if(isset($this->connection)){
      mysql_close($this->connection);
      unset($this->connection);      
    }
    self::$instance = NULL;
  }
}//end class
////////////////////////////////////////////////////////////////////
?>
