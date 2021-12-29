<?php
	// this becomes a top error handler
	include_once("./scripts/error_handler.php");
	session_start();
	if (isset($_POST["logout_action"]) && isset($_SESSION["user_login_name"]))
	{
		session_unset();
		session_destroy();
		header("Location: index.php");
	}
?>