<?php

/**
 * OOP MySQL Database Wrapper
 * @author Gary Peach - http://www.deadlineswebdevelopers.com
 * @copyright 2011
 * updated for mysqli 12/27/2017
 */

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

/**
 * Singleton Database Wrapper Class
 */
class Database {

    private static $instances;
    private $debug = 0;
    private $host;
    private $username;
    private $password;
    private $dbname;
    private $mysqli;
    private $result;

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
    }

//end __construct

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
            throw new MyException('', 5000);
        }
        if (!self::$instances) {
            self::$instances = new Database($host, $username, $password, $dbname);
        }
        return self::$instances;
    }

//end make_connection

    /**
     * Function connect to server
     * @return resource $this->linkId
     */
    public function connect() {
        try {
            $this->mysqli = new mysqli($this->host, $this->username, $this->password, $this->dbname);
            if ($this->debug == 1) {
                print_r($this->mysqli);
                echo 'connected';
            }
        } catch (mysqli_sql_exception $e) {
            if ($this->debug == 1) {
                echo $e->getMessage();
            }
        }
    }

//end connect

    /**
     * function select db
     */
    public function selectDb($dbName) {
            $myDb = $this->mysqli->select_db($dbName);
            if ($myDb && $this->debug == 1) {
                echo 'selected db ' . $dbName;
            }
    }

//end selectDb

    /**
     * function prepare query (escape and strip slashes if necessary)
     * @param mixed $query
     * @return string safe query
     */
    public function prep($query) {
        if (get_magic_quotes_runtime()) {
            stripslashes($query);
        }
        $prepped_query = mysqli_real_escape_string($this->mysqli, $query);
        return $prepped_query;
    }

//end escapeQuery

    /**
     * query db
     * @param string $query
     * @return mixed $queryId (resource id for query)
     */
    public function queryDb($query) {
            $queryId = $this->mysqli->query($query);
            if ($queryId && $this->debug == 1) {
                print_r($queryId);
            }
        return $queryId;
    }

//end queryDb

    /**
     * function fetch row
     * @param mixed $queryId
     * @return array (associative row of results)
     */
    public function fetchRow($queryId) {
            $row = $queryId->fetch_array(MYSQLI_ASSOC);
            if ($row && $this->debug == 1) {
                print_r($row);
            }
        return $row;
    }

//end fetchQuery

    /**
     * function return affected rows
     * @param mixed $queryId
     * @return mixed affected rows
     */
    public function totalRows($queryId) {
            $rows = $queryId->num_rows;
            if ($rows && $this->debug == 1) {
                print_r($rows);
            }
        return $rows;
    }

//end totalRows

    public function closeDb() {
        mysqli_close($this->mysqli);
    }

}

//end class
?>