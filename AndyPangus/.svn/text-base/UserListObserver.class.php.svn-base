<?php
/*
*	UserListObserver class
*	By: Andrew Page @ www.andypangus.com
*	Date: 2009/06/01
*	Updated: N/A
*
*	This UserListObserver class implements the Observer interface and is 
*	designed to be implmented as part of the Observer design pattern.
*
*/
require_once("Observer.interface.php");

class UserListObserver implements Observer {
	public function update($sender, $args)  {
		echo $args['Name'] . " has joined our user list.<br />";
	}
}
?>