<?php 
class UserInfo{
	
 private $user_information; //create a private variable for the users informaion
 //that will be loaded from the database.
 
 public function __construct()
 {
 //the constructor will load up the user information.
 
 
//Connect to DB
  try {
$host = "localhost"; //Host Name
$port = '3306'; //Default MySQL Port
$dbname = "gpeach_usgaymassage"; //Database Name
$db_username = "root"; //MySQL Username
$db_password = "Missy2003"; //MySQL Password
$table_n = "login"; //Our Table where we will hold people

$dsn = "mysql:host=$host;port=$port;dbname=$dbname"; //Data Source Name = Mysql
$db = new PDO($dsn, $db_username, $db_password); //Connect to DB
  } catch (PDOException $e) {
    echo "Failed to get DB handle: " . $e->getMessage() . "\n";
    exit;
  }
//I like to first make a query string and put it in a variable.
$query = "SELECT username FROM ".$table_n;

//Now let's create our Statement where we will do our query.
$statement = $db->prepare($query); //We are calling the DB which is an object
//      And telling it to prepare our query. All operators will be displayed below.


//Now let's execute our query
$statement->execute();

$count=$statement->rowCount();
echo('count: '.$count);


 //put the user information into the "user_information" variable.
 $this->user_information = $statement->fetchObject();
 }
 
public function __toString()
    {
        return $this->user_information;
    }
	
public function get_info($field)
 {
 //use this function to get a piece of information that is stored in the database
 if($field == "")
 {
 //there was no requested field
 return 0;
 }
 
 if(!key_exists($field, $this->user_information))
 {
 //the requested information does not exist
 return 0;
 }
  //return the key
$surName=$this->user_information;
   
 return $this->user_information;
 }



	
	
}


?>