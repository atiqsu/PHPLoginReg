<?php
/* @var $VIS display */
/* @var $settings settings */
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $settings->title . ' :: ' . $VIS->pageTitle; ?></title>
        <meta charset="ISO-8859-15">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/gumby.css">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <div class="shaded">
            <div class="row">
                <div class="six columns">
                    <h2>
                        <?php echo $settings->title;
                        if($VIS->pageTitle != 'Error'){
                            echo " :: " . $VIS->pageTitle;
                        } ?>
                    </h2>
                </div>
                <div class="six columns" id="nav">
                    <ul>
                        <li><a href="<?php echo $settings->url; ?>/index.php" <?php $VIS->nav("index.php"); ?>>Home</a></li>
                        <?php
                        if(user::loggedinUser(false, $settings->mysql_dsn, $settings->mysql_user, $settings->mysql_pass) instanceof user){
                            $loggedinUser = user::loggedinUser(false, $settings->mysql_dsn, $settings->mysql_user, $settings->mysql_pass);
                            echo "<li><a href='logout.php'>Logout from <b>{$loggedinUser->fields->username}</b></a></li>";
                        } else {
                            ?><li><a href="login.php">Login</a></li><?php
                        }
                        ?>
                        <li><a href="#">Compoer</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="twelve columns">
                <span> <?php echo $VIS->description; ?></span>
            </div>
        </div>
        
        <div class="row">
            <div class="twelve columns">
                <?php
                if (isset($_GET['msg'])) {
                switch ($_GET['msg']) {
                    
                    case MSG_REDIRECT:
                        $VIS->status = display::$STATUS_INFO;
                        $VIS->message = 'You have been redirected.';
                        break;
                    
                    case MSG_REGISTRATED:
                        $VIS->status = display::$STATUS_GOOD;
                        $VIS->message = 'You have been registrated. <br> Activation link sent to your email';
                        break;
                    
                    case MSG_LOGGED_IN:
                        $VIS->status = display::$STATUS_GOOD;
                        $VIS->message = 'You have been logged in.';
                        break;
                    
                    case MSG_LOGGED_OUT:
                        $VIS->status = display::$STATUS_GOOD;
                        $VIS->message = 'You have been logged out.';
                        break;
                    
                    case MSG_ACTIVATED:
                        $VIS->status = display::$STATUS_GOOD;
                        $VIS->message = 'You have been activated.';
                        break;
                    
                    case MSG_ACTIVATE_FIRST:
                        $VIS->status = display::$STATUS_WARNING;
                        $VIS->message = 'You need to activate your user before logging in.';
                        
                }
            }
            
            if($VIS->status != display::$STATUS_IGNORE){
                $status_class = false;
                $status_picture = false;
                switch ($VIS->status) {
                    case display::$STATUS_GOOD:
                        $status_class = 'status_good';
                        $status_picture = $status_class;
                        break;

                    case display::$STATUS_WARNING:
                        $status_class = 'status_warning';
                        $status_picture = $status_class;
                        break;

                    case display::$STATUS_ERROR:
                        $status_class = 'status_error';
                        $status_picture = $status_class;
                        break;

                    case display::$STATUS_INFO:
                        $status_class = 'status_info';
                        $status_picture = $status_class;
                        break;

                    default:
                        throw new Exception('Unrecognized status message "'.$VIS->status.'"');
                }
                // Show status message
                ?>
                <div class="<?php echo $status_class; ?>" id="statusfield">
                    <img src="img/<?php echo $status_picture; ?>.png" alt="" />
                    <?php if (isset($VIS->message)) echo $VIS->message; ?>
                </div>
                <?php
            }
            $VIS->createBreadCrumbs();
            ?>
            </div>
        </div>
    <div class="row">
