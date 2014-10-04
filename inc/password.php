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
    
    public function forgot($username, $email){
         // Does anyone exist in the database with supplied credentials?
        $salt = uniqid(mt_rand(), true);
        $pass = substr($salt, 0, 10);
        $hash = sha1($pass);
        
        $login = $this->prepare("UPDATE users SET pass = '{$hash}' WHERE username = ? AND email = ?");
        
        
        
        $login->execute(array(
            $username,
            $email,
        ));

        if ($login->rowCount() == 0) {
            throw new notReset();
        }
        
        // TODO: Send user an email with their new password.
        mail("alexander@aasebo.net", "Password", "Ditt nye passord er: $pass");
        
        return true;
    }
    
}
