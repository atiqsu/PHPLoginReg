<?php
/* @var $VIS display */
/* @var $settings settings */
require './inc/startup.php';

// Are we already logged in? Then lets not activate.
if (user::loggedinUser(false, $settings->mysql_dsn, $settings->mysql_user, $settings->mysql_pass) instanceof user) {
    // Were already logged in
    header('Location: '. $settings->url . '/index.php?msg='.MSG_REDIRECT);
    die('Cannot acvtivate, you\'re logged in, redirecting....');
}

// Have we already tried to activate via link and failed?
$attempt = false;
$VIS->attempt = "false";
if (isset($_POST['attempt']) && $_POST['attempt'] == 'true'){
    $attempt = true;
}

if (isset($_GET['a']) && $attempt == false){
    try {
        switch ($_GET['a']) {
            case 'a':                        
                //We can throw new exceptions
            
                $validationError = array();
                // Do we have everything we need?
                if (!isset($_GET['id'])){
                    $validationError[] = "Id";
                }
                if (!isset($_GET['activation'])){
                    $validationError[] = "Activation string";
                }
                
                if (count($validationError) > 0){
                    throw new dataError();
                }
                
                // We have everything we need. Lets activate the user!
                $activation = new activation($settings->mysql_dsn, $settings->mysql_user, $settings->mysql_pass);
                
                if ($activation->activate1($_GET['id'], $_GET['activation'])){
                    // Activated!
                    header('Location: '. $settings->url . '/index.php?msg='.MSG_ACTIVATED);
                    die('Hooray! You\'re activated, redirecting....');
                }
                
                
            break;
        }
    } catch (notActivated $e) {
        // We did not find this combination of id and activation hash, tell the user.
        $VIS->status = display::$STATUS_ERROR;
        $VIS->message = 'Something went wrong. Please fill in the form below with the correct Username and Activation Code';
    } catch (dataError $e){
        $VIS->status = display::$STATUS_ERROR;
        // Create error message
        $message = <<<MESSAGE
Missing:
<ul>
MESSAGE;
    foreach ($validationError as $error) {
        $message .= '<li>'.$error."</li>\n";
    }
    $message .= <<<MESSAGE
</ul>
Please fill in the form below to activate.
MESSAGE;
        $VIS->message = $message;
        $VIS->attempt = "true";
    }
}
elseif (isset($_POST['action'])) {
    try {
        switch ($_POST['action']) {
            case 'activate':
                //We can throw new exceptions
                echo "Before";
                $validationError = array();
                // Do we have everything we need?
                if (!$_POST['username']){
                    $validationError[] = "Username";
                }
                if (!$_POST['activation']){
                    $validationError[] = "Activation string";
                }
                
                if (count($validationError) > 0){
                    throw new dataError();
                }
                
                // We have everything we need. Lets activate the user!
                
                $activation = new activation($settings->mysql_dsn, $settings->mysql_user, $settings->mysql_pass);
                
                if ($activation->activate2($_POST['username'], $_POST['activation'])){
                    // Activated!
                    header('Location: '. $settings->url . '/index.php?msg='.MSG_ACTIVATED);
                    die('Hooray! You\'re activated, redirecting....'); 
                }
                
                
                // User activated!
                header('Location: '. $settings->url .'/index.php?msg='.MSG_ACTIVATED);
                exit;
            break;

        }
    }
    catch (notActivated $e) {
        // combination of username and password not found in the database. Show error
        $VIS->status = display::$STATUS_ERROR;
        $VIS->message = 'Something went wrong. Check your username and activation code.';
    } catch (dataError $e){
        $VIS->status = display::$STATUS_ERROR;
        // Create error message
        $message = <<<MESSAGE
Missing:
<ul>
MESSAGE;
    foreach ($validationError as $error) {
        $message .= '<li>'.$error."</li>\n";
    }
    $message .= <<<MESSAGE
</ul>
Fill in missing fields and try again.
MESSAGE;
        $VIS->message = $message;
    }
}



// If were here, were going to show the loginpage
$VIS->pageTitle = 'Activation';

$VIS->addBCpath('activate.php', 'Activation');

// Standard-values
$VIS->username = "";
$VIS->activation = "";

//  Have we tried to activate before?
if (isset($_POST['action'])) {
    $VIS->username = $_POST['username'];
    $VIS->activation = $_POST['activation'];
    $VIS->attempt = $_POST['attempt'];
}

/////////////////////////////////////////////
// Display Logic ////////////////////////////
/////////////////////////////////////////////
include HTML_START;

?>

<div class="six columns">
    <form action="activate.php" method="POST">
        <input type="hidden" name="action" value="activate" />
        <input type="hidden" name="attempt" value="<?php echo $VIS->attempt ?>" />
        <div class="field">
            <input class="input" type="text" name="username" value="<?php echo $VIS->username ?>" placeholder="Username" /> <br>
        </div>
        
        <div class="field">
            <input class="input" type="text" name="activation" value="<?php echo $VIS->activation ?>" placeholder="Activation code" /> <br>
        </div>
        <div class="medium secondary btn">
            <input type="submit" value="Activate" name="submitting" />    
        </div>
        
        
    </form>
</div>
<?php
include HTML_STOP;