<?php
/*Include following ontop of every new page to access settings and VIS object*/
/* @var $VIS display */
/* @var $settings settings */

/**
 * Starts sessions. We use this for moving data around our webpage.
 */
session_start();

require 'settings.class.php';

require 'settings.php';

require 'db.php';

require 'registration.php';

require 'display.php';

require 'constant.php';