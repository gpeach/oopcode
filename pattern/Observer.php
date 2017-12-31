<?php

/**
 *
 */
interface Observer {
	public function update($content);
}

/**
 *
 */
interface Subject {
	public function notifyObservers($s);
	public function registerObserver($s);
	public function removeObserver($s);

}
/**
 *
 */
interface Display {
	public function display();
}

/** 
 * @author Gary
 * 
 * 
 */
class Publisher implements Subject {
	
	private $_subscribers = array ();
	private $_content;
	
	/**
	 * 
	 * @see Subject::notifyObservers()
	 */
	public function notifyObservers($s) {
		foreach ( $this->_subscribers as $s ) {
			$s->update ( $this->_content );
		}
	}
	
	/**
	 * 
	 * @see Subject::registerObserver()
	 */
	public function registerObserver($s) {
		array_push ( $this->_subscribers, $s );
	}
	
	/**
	 * 
	 * @see Subject::removeObserver()
	 */
	public function removeObserver($s) {
		
		foreach ( $this->_subscribers as $key => $val ) {
			if ($s == $val) {
				unset ( $this->_subscribers [$key] );
			}
		}
	}
	
	/**
	 * @return the $content
	 */
	public function getContent() {
		return $this->_content;
	}
	
	/**
	 * @param field_type $content
	 */
	public function setContent($content) {
		$this->_content = $content;
		$this->notifyObservers ( $this->_subscribers );
	}
	/**
	 * 
	 */
	public function publishContent() {
		$this->notifyObservers ( $this->_subscribers );
	}
}
/** 
 * @author Gary
 * 
 * 
 */
class DisplayObserver1 implements Observer, Display {
	
	private $_content;
	private $_subscribers;
	
	/**
	 * 
	 * @see Observer::update()
	 */
	public function update($content) {
		
		$this->_content = $content;
		$this->display ();
	}
	
	/**
	 * 
	 * @see Display::display()
	 */
	public function display() {
		echo 'DisplayObserver1: ' . $this->_content;
	}

}
class DisplayObserver2 implements Observer, Display {
	
	private $_content;
	private $_subscribers;
	
	/**
	 * 
	 * @see Observer::update()
	 */
	public function update($content) {
		
		$this->_content = $content;
		$this->display ();
	}
	
	/**
	 * 
	 * @see Display::display()
	 */
	public function display() {
		echo 'DisplayObserver2: ' . $this->_content;
	}

}

?>