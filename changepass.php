<?php
/* @var $VIS display */
/* @var $settings settings */
require './inc/startup.php';

// If were logged in, there is no need to reset the users password.
if (user::loggedinUser(false, $settings->mysql_dsn, $settings->mysql_user, $settings->mysql_pass) instanceof user) {
    // Were logged in, lets fill in the username.
    $user = new user($_SESSION['loggedin_id'], $settings->mysql_dsn, $settings->mysql_user, $settings->mysql_pass);
    $VIS->username = $user->fields->username;
} elseif(!user::loggedinUser(false, $settings->mysql_dsn, $settings->mysql_user, $settings->mysql_pass) instanceof user){
    // Were not logged in, redirect to mainpage.
    header('Location: '. $settings->url .'/index.php?msg='.MSG_LOGIN_FIRST_CHANGEPASS);
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
                die();
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
$VIS->pageTitle = 'Change Pass';

$VIS->addBCpath('changepass.php', 'Change pass');

/////////////////////////////////////////////
// Display Logic ////////////////////////////
/////////////////////////////////////////////
include HTML_START;

?>

<div class="six columns">
    <form action="forgotpass.php" method="POST">
        <input type="hidden" name="action" value="forgotpass" />
        <div class="field">
            <input class="input" type="text" name="username" value="<?php echo $VIS->username; ?>" placeholder="Username" disabled /> <br>
        </div>
        
        <div class="field">
            <input class="input" type="password" name="currpass" value="" placeholder="Current password" /> <br>
        </div>
        
        <div class="field">
            <input class="input" type="password" name="newpass1" value="" placeholder="New password" /> <br>
        </div>
        
        <div class="field">
            <input class="input" type="password" name="newpass2" value="" placeholder="Repeat password" /> <br>
        </div>
        
        <div class="medium secondary btn">
            <input type="submit" value="Change password" name="submitting" />    
        </div>
    </form>
</div>

<?php

include HTML_STOP;