<?php
/**
 * Class for user password handling, change password and forgot password.
 *
 * @author Alexander Aasebø <alexander@aasebo.net>
 * @version 0.1
 */
class password extends db {
    
    public function __construct($dsn, $dbuser, $dbpass, $connect = true, $options = array()) {
        parent::__construct($dsn, $dbuser, $dbpass, $connect, $options);        
    }
    
}
