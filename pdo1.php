<table>
<tr>
<td bgcolor="gray">id</td><td bgcolor="gray">username</td><td bgcolor="gray">field</td>
</tr>
<?php

/*
*       Code Written by Shane Perreault
*       http://shaneprrlt.tumblr.com
*       Written for WebDevRefinery.com
*
*       Notes:
*       
*       We will be learning PDO today. PDO or PHP Data Objects 
*       is a library of PHP that is much faster, secure, and in my
*       opinion, easier to write in. We will be covering these ideas.
*       *Connect to a DB
*       *Passing Queries with Prepared Statements
*       *Parameterizing Queries
*       *Looping While Statements for DB items
*       
*/




//Connect to DB
  try {
$host = "localhost"; //Host Name
$port = '3306'; //Default MySQL Port
$dbname = "gpeach_usgaymassage"; //Database Name
$db_username = "root"; //MySQL Username
$db_password = "Missy2003"; //MySQL Password
$table_n = "login"; //Our Table where we will hold people

$dsn = "mysql:host=$host;port=$port;dbname=$dbname"; //Data Source Name = Mysql
@$db = new PDO($dsn, $db_username, $db_password); //Connect to DB
  } catch (PDOException $e) {
    echo "Failed to get DB handle: " . $e->getMessage() . "\n";
    exit;
  }
//I like to first make a query string and put it in a variable.
$query = "SELECT * FROM ".$table_n;

//Now let's create our Statement where we will do our query.
$statement = $db->prepare($query); //We are calling the DB which is an object
//      And telling it to prepare our query. All operators will be displayed below.

//Our Name will be Bob
$queryParam = 'flhardinpeach@aol.com';

//Now let's execute our query
$statement->execute();

//Now we create a while loop for every entry in our DB where the name is Bob.
while($row = $statement->fetchObject()) //This is similar to mysql_fetch_array, only we're 
{
$id = $row->id;
$username = $row->username;
$password = $row->password;



?>
<tr>
<td><?php echo($id); ?></td><td><?php echo($username); ?></td><td><?php echo($password); ?></td>
</tr>
<?php
}

?>
</table>
