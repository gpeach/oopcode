<?php
/**
 * Multiple query test of Database Class with extended exception handling
 * 
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
try {
	$db = Database::make_connection ( $host, $db_username, $db_password, $dbname );
	$db->connect ();
	$db->selectDb ();
} catch ( MyException $e ) {
	echo $e->getMessage ();
	die ();
}

// query login table
$login_query = 'select * from login';
$login_prepared = $db->prep ( $login_query );
$login = $db->queryDB ( $login_prepared );
echo '<br />rows: ' . $db->totalRows ( $login ) . '<br /><br />';
While ( $login_row = $db->fetchRow ( $login ) ) {
	echo $login_row ['id'] . '<br />';
} // end while


// query contact table
$contact_query = 'select * from contact';
$contact_prepared = $db->prep ( $contact_query );
$contact = $db->queryDB ( $contact_prepared );
echo '<br />rows: ' . $db->totalRows ( $contact ) . '<br /><br />';
While ( $contact_row = $db->fetchRow ( $contact ) ) {
	echo $contact_row ['sitename'] . '<br />';
} // end while


?>

