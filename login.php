<?php
/* @var $VIS display */
/* @var $settings settings */
require './inc/startup.php';

// Are we going to login someone, or just show the login page?
if (user::loggedinUser(false, $settings->mysql_dsn, $settings->mysql_user, $settings->mysql_pass) instanceof user) {
    // Were already logged in
    header('Location: '. $settings->url . '/index.php?msg='.MSG_REDIRECT);
    die('You\'re already logged in, redirecting....');
}
if (isset($_POST['action'])) {
    try {
        switch ($_POST['action']) {
            case 'user':
                // Can throw new exception
                $rememberMe = false;
                if (isset($_POST['rememberMe']) && $_POST['rememberMe'] == true) {
                    $rememberMe = true;
                }
                $user = new user(false, $settings->mysql_dsn, $settings->mysql_user, $settings->mysql_pass);
                $login = $user->authenticateUser($_POST['username'], $_POST['password'], $rememberMe, $settings);
                // Were logged in!
                header('Location: '. $settings->url .'/index.php?msg='.MGS_LOGGED_IN);
                exit;
            break;

        }
    }
    catch (notAuthorized $e) {
        // combination of username and password not found in the database. Show error
        $VIS->status = display::$STATUS_ERROR;
        $VIS->message = 'Wrong username or password.';
    }
}



// If were here, were going to show the loginpage
$VIS->pageTitle = 'Login';

$VIS->addBCpath('login.php', 'Login');

// Standard-values
$VIS->username = "";
$VIS->rememberMe = "";


//  Have we tried to login before?
if (isset($_POST['action'])) {
    $VIS->username = $_POST['username'];
    if (isset($_POST['rememberMe']) && $_POST['rememberMe'] == true) {
        $VIS->rememberMe = " CHECKED";
    }
}



/////////////////////////////////////////////
// Display Logic ////////////////////////////
/////////////////////////////////////////////
include HTML_START;

?>

<div class="six columns">
    <form action="login.php" method="POST">
        <input type="hidden" name="action" value="user" />
        <div class="field">
            <input class="input" type="text" name="username" value="<?php echo $VIS->username ?>" placeholder="Username" /> <br>
        </div>
        
        <div class="field">
            <input class="input" type="password" name="password" value="" placeholder="Password" /> <br>
        </div>
        <div>
            <label class="checkbox" for="rememberMe">
                <input name="rememberMe" id="rememberMe" value="1" type="checkbox" <?php echo $VIS->rememberMe ?>>
                <span>Remember me</span> 
            </label>
        </div>
        <div>
            <a href="<?php echo $settings->url;?>/registrate.php">Not registered?</a>
        </div>
        <div class="medium secondary btn">
            <input type="submit" value="Login" name="submitting" />    
        </div>
        
    </form>
</div>
<?php
include HTML_STOP;