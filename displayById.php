<?php
/**
 * Multiple query test of Database Class
 * @author Gary Peach
 * @copyright 2011
 */
/**
 * function __autoload
 * @param class $class (class to autoload)
 */
function __autoload($class) {
	include_once ($class . '.php');
}
include_once 'localhost_db.inc.php';

// Connect to server and DB
$db = Database::make_connection ( $host, $db_username, $db_password, $dbname );
$db->connect ();
$db->selectDb ();

// query by id
$id=2;
$login_query = 'select * from login, contact where login.id=contact.id and login.id='.$id;
$login_prepared = $db->prep ( $login_query );
$login = $db->queryDB ( $login_prepared );
//echo '<br />rows: ' . $db->totalRows ( $login ) . '<br /><br />';
While ( $login_row = $db->fetchRow ( $login ) ) {

$image='http://LOCALHOST/goo/images/gary2.jpg';
$imageProcess="ImageDisplayUtility.php?unprocessedImage=$image&imageHeight=150";

echo $login_row['sitename'].'<br/>';
echo "<img src=$imageProcess><br/>";
echo '<a href="mailto:'.$login_row['username'].'">Email Address</a><br/>';
echo $login_row['contactphone1'].'<br/>';
} // end while



/*// query contact table
$contact_query = 'select * from contact';
$contact_prepared = $db->prep ( $contact_query );
$contact = $db->queryDB ( $contact_prepared );
echo '<br />rows: ' . $db->totalRows ( $contact ) . '<br /><br />';
While ( $contact_row = $db->fetchRow ( $contact ) ) {
	echo $contact_row ['sitename'] . '<br />';
} // end while*/

?>

