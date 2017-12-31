<?php
/**
 * Extension of exception class test
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
try {
	throw new MyException ( '', 5000 );
} 

catch ( MyException $e ) {
	echo $e->getMessage ();
	exit ();
}

?>