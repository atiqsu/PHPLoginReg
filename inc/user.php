<?php
/**
 * Class for user management
 *
 * @author Alexander Aasebø <alexander@aasebo.net>
 * @version 0.1
 */
class user extends db {
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
    
    protected static $loggedinUser;
    
    public function __construct($id = false, $dsn, $dbuser, $dbpass, $connect = true, $options = array()) {
        parent::__construct($dsn, $dbuser, $dbpass, $connect, $options);
        
        $this->dsn = $dsn;
        $this->dbuser = $dbuser;
        $this->dbpass = $dbpass;
        
        if(!$id){
            return;
        }
        
        /**
         * Fetch user information from database
         */
        $result = $this->prepare("SELECT * FROM users WHERE id=? LIMIT 1");
        
        $result->execute(array(
            $id,
        ));
        
        $this->fields = $result->fetch(PDO::FETCH_OBJ);
        $this->fields->pass = false;
        return;
    }
    
    public static function loggedinUser ($new = false, $dsn, $dbUser, $dbPass) {
        // Authorization
        if (isset($_SESSION['loggedin_id']) && $_SESSION['loggedin_id'] != '') {
            if ((self::$loggedinUser instanceof user) && !$new) {
                // We have stored information, return it.
                return self::$loggedinUser;
            }
            $user = new user($_SESSION['loggedin_id'], $dsn, $dbUser, $dbPass);
            self::$loggedinUser = $user;
            return $user;
        } elseif (isset($_COOKIE['user_rememberme'])) {
            $user = new user($_COOKIE['user_rememberme'], $dsn, $dbUser, $dbPass);
            self::$loggedinUser = $user;
            $_SESSION['loggedin_id'] = $user->id;
            return $user;
        }

        return false;
    }
    
    private function getSalt($username){
        $query = $this->prepare("SELECT salt FROM users WHERE username=?");
        $query->execute(array($username));
        
        if ($query->rowCount() == 0){
            throw new notAuthorized('User not authorized');
        }
        
        $salt = $query->fetch(PDO::FETCH_OBJ);
        return $salt->salt;
    }

    public function authenticateUser ($username, $password, $rememberMe = false, $settings) {
        //Before we do anything, lets get the password salts from our database and then encrypt the users password.
        $salt = $this->getSalt($username);
        $hash = sha1($password . $salt);
        
        // Does anyone exist in the database with supplied credentials?
        $login = $this->prepare("SELECT * FROM users WHERE username=? AND pass=?");
        $login->execute(array(
            $username,
            $hash,
        ));

        if ($login->rowCount() == 0) {
            throw new notAuthorized('User not authorized');
        }
        $row = $login->fetch(PDO::FETCH_OBJ);
        
        if ($row->activated == 0){
            throw new notActivated();
        }
        
        $id = $row->id;
        // Put user ID into a session, so we know were logged in
        $_SESSION['loggedin_id'] = $id;

        // Should the user be remembered?
        if ($rememberMe) {
            setcookie('user_rememberme', $id, time()+60*60*24*3);
        }
        $this->close_connection();
        return new user($id, $this->dsn, $this->dbuser, $this->dbpass);
    }
    
}
