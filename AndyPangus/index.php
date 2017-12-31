<?php
/*
*	index.php
*	By: Andrew Page @ www.andypangus.com
*	Date: 2009/06/01
*	Updated: N/A
*
*	This file implements the the Observer design pattern using the UserListObserver, 
*	UserListCountObserver,  and the UserList classes.
*
*/

require_once("UserListObserver.class.php");
require_once("UserListCountObserver.class.php");
require_once("UserList.class.php");

$ul = new UserList();
$users = new UserListObserver();
$num_users = new UserListCountObserver();

$ul->registerObserver($users);
$ul->registerObserver($num_users);
$ul->addUser("Jack");
echo "<br />";
$ul->addUser("Jill");
echo "<br />";
$ul->addUser("John");
echo "<br />";
$ul->removeObserver($users);
$ul->addUser("Judy");
?>