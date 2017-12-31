<?php
if (! isset ( $_SESSION )) {
	session_start ();
}
if (isset ( $_GET ['recordID'] )){
	$recordID = $_GET ['recordID'];
} else {
	echo('you need a record id - exiting');
	die;
}

/*usgay massage detail page using pdo and oop*/
include_once ('ConfigLocalhostConnection.php');

//Query masseur details
//$query_MasseurDetails = "SELECT * from contact";

$query_MasseurDetails = "SELECT *, contact.state AS country FROM contact, locations where contact.adapproved = 'Y' and contact.id=locations.id and locations.home= 'Y' and contact.id = ?";
$statement_MasseurDetails = $db->prepare ( $query_MasseurDetails ); 
$statement_MasseurDetails->execute ( array ($recordID ) );
$row_MasseurDetails=$statement_MasseurDetails->fetchObject();
if (isset($row_MasseurDetails)) {
	echo ('masseur id: ' . $row_MasseurDetails->id . '<br />headline: ' . $row_MasseurDetails->headline . '<br />site name: ' . $row_MasseurDetails->sitename);
} else {
	echo ('no profile');
}
?>