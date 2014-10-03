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

define('MSG_IKKE_TILGANG',          crypt(6, CRYPTING_SALT));
define('MSG_COMPO_OPPRETTET',       crypt(7, CRYPTING_SALT));
define('MSG_COMPO_SLETTET',         crypt(8, CRYPTING_SALT));
define('MSG_NY_DELTAKELSE',         crypt(9, CRYPTING_SALT));
define('MSG_FJERNET_DELTAKELSE',    crypt(10, CRYPTING_SALT));
define('MSG_REDIRECT_NODELTAKER',   crypt(11, CRYPTING_SALT));
define('MSG_COMPO_OPPDATERT',       crypt(12, CRYPTING_SALT));
define('MSG_DELTAKER_STATUS_OK',    crypt(13, CRYPTING_SALT));
define('MSG_NY_BRUKER',             crypt(14, CRYPTING_SALT));
define('MSG_INNSTILLINGER_OK',      crypt(15, CRYPTING_SALT));


// Filer
define('HTML_START', $settings->local_path . '/inc/start_html.php'); 
define('HTML_STOP', $settings->local_path . '/inc/stop_html.php');