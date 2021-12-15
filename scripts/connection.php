<?php
	$host = "localhost";
	$user = "Webuser";
	$password = "Lab2021";
	$database = "QSWebShop";
	$link = mysqli_connect($host, $user, $password) or die ("There was not connection acquired with $host");
	mysqli_select_db($link, $database) or die ("Database $database not available");
?>
