<?php
/**
 * Class for user registration
 *
 * @author Alexander Aasebø <alexander@aasebo.net>
 * @version 0.1
 */
class registration extends db{
    /**
     * Class for user registration, uses database class
     * @param MixedString $dsn Used to specify which driver to use, which db to user and which host. <br> Example: $dsn="mysql:dbname=DBNAME;Host=127.0.0.1";
     * @param String $dbuser Which database user to user
     * @param String $dbpass Password for database user
     * @param boolean $connect If set to true, class creates a database connection when instanciated, if fales it stores provided credentials
     * @param Array $options [Optonal]
     */
    public function __construct($dsn, $dbuser, $dbpass, $connect = true, $options = array()) {
        parent::__construct($dsn, $dbuser, $dbpass, $connect, $options);
    }
    
}
