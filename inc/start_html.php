<?php
/* @var $VIS display */
/* @var $settings settings */
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $VIS->pageTitle . ' :: ' . $settings->title; ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/gumby.css">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <div class="row">
            <div class="six columns centered">
                <?php $VIS->createBreadCrumbs(); ?>
                <?php
                if($VIS->status != display::$STATUS_IGNORE){
                    $status_class = false;
                    $status_bilde = false;
                    switch ($VIS->status) {
                        case display::$STATUS_GOOD:
                            $status_class = 'status_bra';
                            $status_bilde = $status_class;
                            break;

                        case display::$STATUS_WARNING:
                            $status_class = 'status_advarsel';
                            $status_bilde = $status_class;
                            break;

                        case display::$STATUS_ERROR:
                            $status_class = 'status_feil';
                            $status_bilde = $status_class;
                            break;

                        case display::$STATUS_INFO:
                            $status_class = 'status_info';
                            $status_bilde = $status_class;
                            break;

                        default:
                            throw new Exception('Unrecognized status message "'.$VIS->status.'"');
                    }
                    // Show status message
                    ?>
                    <div class="<?php echo $status_class; ?>" id="statusfield">
                        <img src="img/<?php echo $status_bilde; ?>.png" alt="" />
                        <?php if (isset($VIS->message)) echo $VIS->message; ?>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="row">