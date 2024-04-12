<?php
if($_SERVER['HTTP_X_FORWARDED_PROTO'] == "http") {
	if($_server['HTTPS'] != "on") {
		$redirect = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		header('Location:'.$redirect);
	}
}
?>
<?php include "variables.php"; ?>
<?php
// Initialize the session.
// If you are using session_name("something"), don't forget it now!
session_start();

// Unset all of the session variables.
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session.
session_destroy();
//setcookie('email', 'gone',time() - (60 * 1), "/");
//setcookie('password', 'gone',time() - (60 * 1), "/");
header('Location:'.$adminurl);
?>
