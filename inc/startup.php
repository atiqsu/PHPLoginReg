<?php

/**
 * Starts sessions. We use this for moving data around our webpage.
 */
session_start();

include 'db.php';

include 'errorhandler.php';

include 'registration.php';

include 'validator.php';

include 'display.php';
