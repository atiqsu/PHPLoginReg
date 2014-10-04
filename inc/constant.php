<?php
// To be changed
define('CRYPTING_SALT', 'I dont wanna sew');
// MSG - Message codes
define('MSG_REDIRECT',              crypt(1, CRYPTING_SALT));
define('MSG_REGISTRATED',           crypt(2, CRYPTING_SALT));
define('MSG_LOGGED_OUT',            crypt(3, CRYPTING_SALT));
define('MSG_LOGGED_IN',             crypt(4, CRYPTING_SALT));
define('MSG_ACTIVATED',             crypt(5, CRYPTING_SALT));
define('MSG_ACTIVATE_FIRST',        crypt(6, CRYPTING_SALT));
define('MSG_PASSWORD_RESET',        crypt(7, CRYPTING_SALT));
define('MSG_LOGIN_FIRST_CHANGEPASS',crypt(8, CRYPTING_SALT));

define('MSG_GOES_HERE',             crypt(100, CRYPTING_SALT));


// Files
define('HTML_START', $settings->local_path . '/inc/start_html.php'); 
define('HTML_STOP', $settings->local_path . '/inc/stop_html.php');