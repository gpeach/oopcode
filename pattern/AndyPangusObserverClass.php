<?php
//our interface file
require_once('AndyPangusObserverInterface.php');

class UserList implements Subject  {

    private $_observers = array();
    private $_data = array();
    private $_ul = array();

    public function registerObserver($o)  {
        array_push($this->_observers, $o);
    }

    public function removeObserver($o)  {
        $index = array_search($o, $this->_observers);
		
        if($index >= 0)  {
            $filter = array($index);
            $this->_observers = array_diff_key(
			$this->_observers, array_flip($filter));
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