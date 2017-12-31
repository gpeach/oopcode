<?php
/*
*	UserList class
*	By: Andrew Page @ www.andypangus.com
*	Date: 2009/06/01
*	Updated: N/A
*
*	This UserList class implements the Subject interface and is designed 
*	to be implmented as part of the Observer design pattern.
*
*/
require_once("Subject.interface.php");

class UserList implements Subject  {
	
	private $_observers = array();	//list of observers
	private $_data = array();		//the data being sent out to the observers
	private $_ul = array();			//the userlist which stores the entire list --> for demo purposes only
	
	public function registerObserver($o)  {
		array_push($this->_observers, $o);
	}
	
	public function removeObserver($o)  {
		$index = array_search($o, $this->_observers);
		
		if($index >= 0)  {
			$filter = array($index);
			$this->_observers = array_diff_key($this->_observers, array_flip($filter));
		}
	}
	
	public function notifyObservers()  {
		foreach($this->_observers as $obs)  {
			$obs->update($this, $this->_data);
		}
	}
	
	public function addUser($name)  {
		//add the user to our userlist
		array_push($this->_ul, $name);
		
		//create our data array to be shipped out
		$keys = array('Name', 'Users');
		$values = array($name, sizeof($this->_ul));
		$this->_data = array_combine($keys, $values);
		
		$this->notifyObservers();
	}
}
?>