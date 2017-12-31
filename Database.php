<?php
/**
 * OOP MySQL Database Wrapper
 * @author Gary Peach - http://www.gapwebdesign.com
 * @copyright 2011
 */
/**
 * Singleton Database Wrapper Class
 */
class Database {
	
	private static $instances;
	private $linkId;
	private $debug = 0;
	private $host;
	private $username;
	private $password;
	
	/**
	 * database wrapper constructor (just sets instance vars)
	 * @param string $host
	 * @param string $username
	 * @param string $password
	 * @param string $dbname
	 */
	private function __construct($host, $username, $password, $dbname) {
		if ($this->debug == 1) {
			echo $host . ' ' . $username . ' ' . $password . ' ' . $dbname;
		}
		$this->host = $host;
		$this->username = $username;
		$this->password = $password;
		$this->dbname = $dbname;
	} //end __construct
	

	/**
	 * Singleton call to constructor
	 * @param string $host
	 * @param string $username
	 * @param string $password
	 * @param string $dbname
	 * @return mixed self::$instances
	 */
	static public function make_connection($host, $username, $password, $dbname) {
		if (self::$instances) {
			throw new MyException ( '', 5000 );
		}
		if (! self::$instances) {
			self::$instances = new Database ( $host, $username, $password, $dbname );
		}
		return self::$instances;
	} //end make_connection
	

	/**
	 * Function connect to server
	 */
	public function connect() {
            
            
		
		$this->linkId = @mysql_connect ( $this->host, $this->username, $this->password );
		if (! $this->linkId) {
			throw new MyException ( mysql_error () );
		}
		if ($this->linkId && $this->debug == 1) {
			echo ('link id ' . $this->linkId);
			echo 'connected';
		}
	} //end connect
	

	/**
	 * function select db
	 */
	public function selectDb() {
		$myDB = mysql_select_db ( $this->dbname, $this->linkId );
		if ($myDB && $this->debug == 1) {
			echo 'selected db ' . $this->dbname;
		}
	} //end selectDb
	

	/**
	 * function prepare query (escape and strip slashes if necessary)
	 * @param mixed $query
	 * @return string safe query
	 */
	public function prep($query) {
		if (get_magic_quotes_runtime ()) {
			stripslashes ( $query );
		}
		$query = mysql_real_escape_string ( $query, $this->linkId );
		return $query;
	} //end escapeQuery
	

	/**
	 * query open db
	 * @param string $query
	 * @return mixed $queryId (resource id for query)
	 */
	public function queryDb($query) {
		$queryId = mysql_query ( $query, $this->linkId );
		if ($this->debug == 1) {
			print_r ( $queryId );
		}
		return $queryId;
	} //end queryDb
	

	/**
	 * function fetch row
	 * @param mixed $queryId
	 * @return array (associative row of results)
	 */
	public function fetchRow($queryId) {
		$result = mysql_fetch_assoc ( $queryId );
		if ($this->debug == 1) {
			print_r ( $result );
		}
		return $result;
	} //end fetchQuery
	

	/**
	 * function return affected rows
	 * @param mixed $queryId
	 * @return mixed affected rows
	 */
	public function totalRows($queryId) {
		$result = mysql_num_rows ( $queryId );
		return $result;
	} //end totalRows
	

	public function closeDb() {
		mysql_close ( $this->linkId );
	}

} //end class


?>