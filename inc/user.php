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
        $result = $this->query("SELECT * FROM users WHERE id=" . $id . "LIMIT 1", PDO::FETCH_OBJ);

        $this->id = $id;
        $this->fields = mysql_fetch_assoc($result);
        $this->fields['password'] = false;
        return;
    }
    
    public static function loggedinUser ($new = false) {
        // Authorization
        if (isset($_SESSION['loggedin_id']) && $_SESSION['loggedin_id'] != '') {
            if ((self::$loggedinUser instanceof user) && !$new) {
                // Vi har stored information, return it.
                return self::$loggedinUser;
            }
            $user = new user($_SESSION['logged_in']);
            self::$loggedinUser = $user;
            return $user;
        } elseif (isset($_COOKIE['user_rememberme'])) {
            $user = new user($_COOKIE['user_rememberme']);
            self::$loggedinUser = $user;
            $_SESSION['loggedin_id'] = $user->id;
            return $user;
        }

        return false;
    }
    
}
