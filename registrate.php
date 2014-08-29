<?php
/* @var $VIS display */
/* @var $settings settings */
require './inc/startup.php';

try{
    if(!isset($_POST['submitted']) && $_POST['submitted'] != 1){
        throw new notSent();
    }
    $user = [];
    
    $user['email'] = $_POST['email'];
    $user['fname'] = $_POST['fname'];
    $user['lname'] = $_POST['lname'];
    $user['username'] = $_POST['username'];
    $user['password'] = $_POST['password'];
    $user['repassword'] = $_POST['repassword'];
    
    $validationError = array();
    /* Pass1 and Pass2 are used for password validation */
    $pass1 = false;
    $pass2 = false;
    
    
    if(!$user['email']){
        $validationError[] = "Please provide a email.";
    } elseif (!filter_var($user['email'], FILTER_VALIDATE_EMAIL)){
        $validationError[] = "Please provide a valid email.";
    }
    
    if(!$user['fname']) {
        $validationError[] = "Please provide your firstname.";
    }
    
    if(!$user['lname']) {
        $validationError[] = "Please provide your lastname.";
    }
    
    if(!$user['username']) {
        $validationError[] = "Please provide a username.";
    }
    
    if(!$user['password']) {
        $validationError[] = "Please provide your desired password.";
    } else {
        /* First password field succeeded */
        $pass1 = true;
    }
    
    if(!$user['repassword']) {
        $validationError[] = "Please retype your desired password.";
    } else {
        /* Second password field succeeded */
        $pass2 = true;
    }
    
    if($pass1 == true && $pass2 == true){
        /* Both passwords match, proceed with password validation */
        if($user['password'] !== $user['repassword']){
            $validationError[] = "Your passwords doesn't match.";
        }
    }
    
    /**
     * Check if any validation error occoured.
     */
    if(count($validationError) > 0){
        /**
         * OHNO, we have errors.
         */
        throw new dataError();
    }
    
    /**
     * No errors encountered.
     * Proceed with registration
     */
    
    /**
     * First, lets check if any of the credentials are already used.
     */
    $dsn = "mysql:dbname=dev;host=127.0.0.1";
    $dbuser = "root";
    $dbpass = "pass";
    $reg = new registration($dsn, $dbuser, $dbpass);
    $validationError = $reg->checkUser($user);
    if (count($validationError) > 0){
        throw new dataError();
    }
    
    if ($reg->registrate($user)){
        header ('Location: '.$settings->url . '/index.php?msg='. MSG_REGISTRATED );
    } else {
        throw new databaseError();
    }
    
}
catch (dataError $e){
     // Validation error
    $VIS->status = display::$STATUS_ERROR;

    // Create error message
    $message = <<<MESSAGE
Validation error:
<ul>
MESSAGE;
    foreach ($validationError as $error) {
        $message .= '<li>'.$error."</li>\n";
    }
    $message .= <<<MESSAGE
</ul>
These errors needs to be fixed before you can be registrated.
MESSAGE;
                $VIS->message = $message;
}
catch (notSent $e){
     $VIS->status = display::$STATUS_IGNORE;
     $VIS->message = "Please fill the form below to registrate";
}
 catch (databaseError $e){
     $VIS->status = display::$STATUS_ERROR;
     $VIS->message = "We were unable to registrate you. (Unkown error occoured) Please try again later. If this error persists, please contact us.";
 }
$VIS->addBCpath('registrate.php', 'Registration', 'This is where you can create a new user');
$VIS->activateBC();
include HTML_START;
?>
<div class="six columns">
    <form action="registrate.php" method="post">
        <div class="field">
            <input class="input" type="text" name="email" value="<?php echo $user['email'] ?>" placeholder="Email" /> <br>
        </div>
        <div class="field">
            <input class="input" type="text" name="fname" value="<?php echo $user['fname'] ?>" placeholder="First Name" /> <br>
        </div>
        <div class="field">
            <input class="input" type="text" name="lname" value="<?php echo $user['lname'] ?>" placeholder="Last Name" /> <br>
        </div>
        <div class="field">
            <input class="input" type="text" name="username" value="<?php echo $user['username'] ?>" placeholder="Username" /> <br>
        </div>
        <div class="field">
            <input class="input" type="password" name="password" value="" placeholder="Password" /> <br>
        </div>
        <div class="field">
            <input class="input" type="password" name="repassword" value="" placeholder="Repeat password" /> <br>
        </div>
        <div class="medium secondary btn">
            <input type="submit" value="Registrate" name="submit" />    
        </div>
        <input type="hidden" name="submitted" value="1" />
    </form>
</div>

<?php
include HTML_STOP;