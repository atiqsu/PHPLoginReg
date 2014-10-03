<?php
/**
 * Class for user activation
 *
 * @author Alexander Aasebø <alexander@aasebo.net>
 * @version 0.1
 */
class activation extends db {
    
    public function __construct($dsn, $dbuser, $dbpass, $connect = true, $options = array()) {
        parent::__construct($dsn, $dbuser, $dbpass, $connect, $options);        
    }
    
    public function activate1($id, $activation){
        $query = $this->prepare("UPDATE users SET activated = 1 WHERE id = ? AND activationhash = ?");
        $query->execute(array(
            $id,
            $activation,
        ));
        
        if($query->rowCount() == 0){
            throw new notActivated();
        }
        return true;
    }
    
    public function activate2($username, $activation){
        $query = $this->prepare("UPDATE users SET activated = 1 WHERE username = ? AND activationhash = ?");
        $query->execute(array(
            $username,
            $activation,
        ));
        
        if($query->rowCount() == 0){
            throw new notActivated();
        }
        return true;
    }
    
    
    
}
