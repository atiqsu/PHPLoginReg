<?php
/* @var $VIS display */
/* @var $settings settings */
require './inc/startup.php';

// Where are we going to redirect to later on?

$redirectPath = $settings->url . '/index.php?msg='.MSG_LOGGED_OUT;
// What are we going todo?
if (isset($_GET['a']) && $_GET['a'] == 'b') {
    // Were logging out a user
    // Delete rememberMe-cookien
    setCookie('user_rememberme', '', 0);
}

// From PHP.net. Delete all session variables.
$_SESSION = array();

// Delete cookies.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroy sessions
session_destroy();

header('Location: ' . $redirectPath);
?>Redirecting...