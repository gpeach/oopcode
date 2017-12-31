<?php
$host = "localhost"; //Host Name
$port = '3306'; //Default MySQL Port
$dbname = "gpeach_usgaymassage"; //Database Name
$db_username = "root"; //MySQL Username
$db_password = "Missy2003"; //MySQL Password

//Connect to DB
try {
	$dsn = "mysql:host=$host;port=$port;dbname=$dbname"; //Data Source Name = Mysql
	@$db = new PDO ( $dsn, $db_username, $db_password ); //Connect to DB
} catch ( PDOException $e ) {
	echo "Failed to get DB handle: " . $e->getMessage () . "\n";
	exit ();
}
?>