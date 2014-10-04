<?php
/* @var $VIS display */
/* @var $settings settings */
require './inc/startup.php';

// If were logged in, there is no need to reset the users password.
if (user::loggedinUser(false, $settings->mysql_dsn, $settings->mysql_user, $settings->mysql_pass) instanceof user) {
    // Were already logged in
    header('Location: '. $settings->url . '/index.php?msg='.MSG_REDIRECT);
    die('You\'re already logged in, redirecting....');
}

if (isset($_POST['action'])) {
    try {
        switch ($_POST['action']) {
            case 'forgotpass':
                
                $validationError = array();
                
                if(!$_POST['username']){
                    $validationError[] = "Please provide your username.";
                }
                
                if(!$_POST['email']){
                    $validationError[] = "Please provide your email.";
                } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                    $validationError[] = "Please provide a valid email.";
                }
                
                /**
                * Check if any validation error occoured.
                */
               if(count($validationError) > 0){
                   throw new dataError();
               }
                
                // Can throw new exception
                $password = new password($settings->mysql_dsn, $settings->mysql_user, $settings->mysql_pass);
                $password->forgot($_POST['username'], $_POST['email']);
                // Were logged in!
                header('Location: '. $settings->url .'/index.php?msg='.MSG_PASSWORD_RESET);
                die("Your password was reset, redirecting....");
            break;

        }
    }
    catch (notReset $e) {
        // combination of username and password not found in the database. Show error
        $VIS->status = display::$STATUS_ERROR;
        $VIS->message = 'This combination of Username and Email was not found.';
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
}


// If were here, were going to show the loginpage
$VIS->pageTitle = 'Forgot Pass';

$VIS->addBCpath('forgotpass.php', 'Forgot pass');

$VIS->username = "";
$VIS->email = "";

//  Have we tried to reset password before?
if (isset($_POST['action'])) {
    $VIS->username = $_POST['username'];
    $VIS->email = $_POST['email'];
}

/////////////////////////////////////////////
// Display Logic ////////////////////////////
/////////////////////////////////////////////
include HTML_START;

?>

<div class="six columns">
    <form action="forgotpass.php" method="POST">
        <input type="hidden" name="action" value="forgotpass" />
        <div class="field">
            <input class="input" type="text" name="username" value="<?php echo $VIS->username; ?>" placeholder="Username" /> <br>
        </div>
        
        <div class="field">
            <input class="input" type="text" name="email" value="<?php echo $VIS->email; ?>" placeholder="Email" /> <br>
        </div>
        <div class="medium secondary btn">
            <input type="submit" value="Reset password" name="submitting" />    
        </div>
    </form>
</div>

<?php

include HTML_STOP;