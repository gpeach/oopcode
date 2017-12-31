<?php 

include_once('User_Info_Class.php');




$User=new UserInfo();
$myName=$User->get_info('username');
echo('name:'.$myName->username);
?>