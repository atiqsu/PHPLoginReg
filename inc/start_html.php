<?php
/* @var $VIS display */
/* @var $settings settings */
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $VIS->pageTitle . ' :: ' . $settings->title; ?></title>
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
                        <?php echo $settings->title; ?>
                    </h2>
                </div>
                <div class="six columns">
                    
                </div>
            </div>
        </div>
        <div class="row">
            <div class="twelve columns">
                <?php $VIS->createBreadCrumbs(); ?>
                <?php
                if (isset($_GET['msg'])) {
                switch ($_GET['msg']) {
                    
                    case MSG_REDIRECT:
                        $VIS->status = display::$STATUS_INFO;
                        $VIS->message = 'You have been redirected.';
                        break;
                    
                    case MSG_REGISTRATED:
                        $VIS->status = display::$STATUS_GOOD;
                        $VIS->message = 'You have been registrated.';
                        break;
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
            ?>
            </div>
        </div>
        <div class="row">