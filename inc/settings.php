<?php
/* @var $settings settings */

/*
 * Configuration file for Login / Register Application
 * 
 * In this file you will be able to change different run parameters using the $settings
 * 
 * Everything here should be well documented, 
 * if it's not its far more constructive to get 120 stars in Super Mario Galaxy 2
 */

/////////////////////////
// Local file path
//
// Set this to the local file path, like it's being read by the server itself
// A absolute path, without the last /
// Example: '/var/www/clients/client1/web1/web'

$settings->local_path = 'D:/wamp/www/registration';


/////////////////////////
// MySQL Settings
//
////
// Host-name
$settings->mysql_host = '127.0.0.1';

////
// Username
$settings->mysql_user = 'root';

////
// Password
$settings->mysql_pass = 'pass';

////
// The databse were going to connect to
$settings->mysql_database = 'fetlan';


/////////////////////////
// Extra, changeable settings
//
// These settings can be changed by the user,
// Without using this file.
// All admins can.
// These are just the default settings incase we
// Can't reach our /data/ folder
//

/////////////////////////
// Title
//
// What is the name of the site? For example: Facebook, google, youtube etc etc.
$settings->extra['title'] = 'Fetlan';


////
// End of settings file

////
// Fetch from settings file, if possible
try {
    $settings->getFromFile();
}
catch (Exception $e) {}