<?php
/*
*	UserListCountObserver class
*	By: Andrew Page @ www.andypangus.com
*	Date: 2009/06/01
*	Updated: N/A
*
*	This UserListCountObserver class implements the Observer interface and is 
*	designed to be implmented as part of the Observer design pattern.
*
*/
require_once("Observer.interface.php");

class UserListCountObserver implements Observer {
	public function update($sender, $args)  {
		echo "We now have " . $args['Users'] . " users!<br /><br />";
	}
}
?>