<?php
/**
 * Class for database communication
 * 
 * @author Alexander Aasebø <alexander@aasebo.net>
 * @version 0.1
 */
class db {
    /**
     * PHP Data Object Object. Used for database communication
     * @var PDOObject 
     */
    protected $PDO_;
    /**
     * Used to specify which driver to use, which db to user and which host. <br> Example: $dsn="mysql:dbname=DBNAME;Host=127.0.0.1";
     * @var MixedString 
     */
    protected $dsn;
    /**
     * Which database user to user
     * @var String 
     */
    protected $dbuser;
    /**
     * Password for database user
     * @var String 
     */
    protected $dbpass;
    /**
     * Options for PDO [Optional]
     * @var Array 
     */
    protected $options;
    /**
     * Class for database communication
     * @param MixedString $dsn Used to specify which driver to use, which db to user and which host. <br> Example: $dsn="mysql:dbname=DBNAME;Host=127.0.0.1";
     * @param String $dbuser Which database user to user
     * @param String $dbpass Password for database user
     * @param boolean $connect If set to true, class creates a database connection when instanciated, if fales it stores provided credentials
     * @param Array $options [Optonal]
     */
    public function __construct($dsn, $dbuser, $dbpass, $connect = true, $options = array()) {
        // If $connect is true and credentials are present, try to connect.
        if($connect == true && $dsn && $dbuser && $dbpass){
            try {
                $this->PDO_ = new PDO($dsn, $dbuser, $dbpass, $options);
                $this->PDO_->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->change_credentials($dsn, $dbuser, $dbpass, $options);
            } catch (PDOException $e) {
                echo $e->getMessage(), "<br>";
                die();
            }
        } else if ($dsn && $dbuser && $dbpass) {
            $this->change_credentials($dsn, $dbuser, $dbpass, $options);
        }
        
    }
    /**
     * 
     * @param string $query Query to t be run through the database
     * @return PDOStatementObject Returns an object of whats being querried
     */
    public function query($query){
        return $this->PDO_->query($query);
    }
    /**
     * Closes the database connection
     * @return boolean
     */
    public function close_connection(){
        $this->PDO_ = null;
        return true;
    }  
    /**
     * Opens the database connection with credentials set in the class
     * @return boolean
     */
    public function open_connection(){
        try {
            $this->PDO_ = new PDO($this->dsn, $this->dbuser, $this->dbpass, $this->options);
            $this->PDO_->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage(), "<br>";
            die();
        }
    }
    /**
     * Changes the credentials to use with the database
     * @param string $dsn Used to specify which driver to use, which db to user and which host. <br> Example: $dsn="mysql:dbname=DBNAME;Host=127.0.0.1";
     * @param string $dbuser Which database user to user
     * @param string $dbpass Password for database user
     * @return boolean 
     */
    public function change_credentials($dsn, $dbuser, $dbpass, $options = array()){
        if ($dsn && $dbuser && $dbpass && $options) {
            $this->dsn = $dsn;
            $this->dbuser = $dbuser;
            $this->dbpass = $dbpass;
            $this->options = $options;
            return true;
        } else {
            return false;
        }
    }
    /**
     * prepares a SQL string for database insertion
     * @param string $sql SQL String to prepare in for database insertion
     * @return PDOStatementObject 
     */
    public function prepare($sql) {
        return $this->PDO_->prepare($sql);
    }
    /**
     * Returns the Id of the last inserted row
     * @return int Id of last inserted row
     */
    public function lastInsertId() {
        return $this->PDO_->lastInsertId();
    }
    
    /**
     * Returns true if PDO is created / False if not
     * @return boolean True if connected, False is not
     */
    public function checkConnection(){
        if(!$this->PDO_){
            return false;
        }
        return true;
    }
}

