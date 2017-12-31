<?php
class MyException extends Exception {
	
	public function __construct($message = null, $code = 0) {
		if ($code < 5000) {
			$message = $message . ' -- Connection Error -- ';
		}
		if ($code >= 5000) {
			$message = "-- Programmer Error - misuse of class --";
		}
		parent::__construct ( $message, $code );
	}

}
?>