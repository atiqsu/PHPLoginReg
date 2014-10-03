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
    
    /**
     * Funcion to check if user credentials already are in database or not
     * @param array $user User info to check agaisnt database. Checks following fields: <br> <ul><li>email</li> <li>username</li></ul>
     */
    public function checkUser($user = array()){
        $validationError = [];
        if(isset($user['email'])){
            $email = $this->prepare("SELECT email FROM users WHERE email=?");
            $email->execute(array($user['email']));
            
            if ($email->rowCount() > 0){
                $validationError[] = "{$user['email']} is already in use.";
            }
        }
        if(isset($user['username'])){
            $username = $this->prepare("SELECT username FROM users WHERE username=?");
            $username->execute(array($user['username']));
            
            if ($username->rowCount() > 0){
                $validationError[] = "{$user['username']} is already in use.";
            }
        }
        return $validationError;
    }
    
    public function registrate($user){
        $registration = $this->prepare("INSERT INTO users (username, pass, email, name, salt, joined, activationhash) VALUES (:username, :password, :email, :name, :salt, now(), :activationhash )");
        
        $username = $user['username'];
        $password = $user['password'];
        $email = $user['email'];
        $name = $user['fname'] . " " . $user['lname'];
        
        $salt = uniqid(mt_rand(), true);
        $hash = sha1($password . $salt);
        
        $activationhash = uniqid(mt_rand(), true);
        
        $registration->execute(array(
            ":username" => $username,
            ":password" => $hash,
            ":email" => $email,
            ":name" => $name,
            ":salt" => $salt,
            ":activationhash" => $activationhash,
        ));
        
        if($registration->rowCount() > 0 ){
            
            // TODO: Send email to user
            
            return true;
        } else {
            return false;
        }
    }
    
}
