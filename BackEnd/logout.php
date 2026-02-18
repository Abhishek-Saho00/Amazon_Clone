<?php
// Properly clear session and cookie then redirect to auth page
session_start();

// Unset all session variables
$_SESSION = array();

// If session uses cookies, remove the session cookie
if (ini_get("session.use_cookies")) {
	$params = session_get_cookie_params();
	setcookie(session_name(), '', time() - 42000,
		$params["path"], $params["domain"],
		$params["secure"], $params["httponly"]
	);
}

// Destroy the session
session_destroy();

// Redirect back to auth/login page
header("Location: /Amazon_webSite/FrontEnd/auth.php");
exit();
?>
