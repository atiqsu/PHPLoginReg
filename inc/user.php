<?php
/**
 * Class for user management
 *
 * @author Alexander Aasebø <alexander@aasebo.net>
 * @version 0.1
 */
class user extends db {
    protected static $loggedinUser;
    
    public function __construct($id) {
        if(!$id){
            return;
        }
        
        /**
         * Fetch user information from database
         */
        $query = "SELECT * FROM ". DBPRE . "_brukere WHERE bruker_id='" . mesc($id) . "' LIMIT 1";
        $this->query("SELECT * FROM users WHERE id=" . $id . "LIMIT 1");

        if (!$result) {
            throw new MysqlException();
        }

        $this->id = $id;
        $this->felter = mysql_fetch_assoc($result);
        $this->felter['passord'] = false;
        return;
    }
    
}
