<?php
	session_start();
	if (isset($_SESSION["username"]))
	{
		session_unset();
		session_destroy();
	}
?>
<?php
	// login matrix to be retrieve from the database (to be implemented)
	$login_matrix = array(
		array(htmlspecialchars("Alfi"), password_hash("godislove", PASSWORD_DEFAULT)),
		array(htmlspecialchars("Tabi"), password_hash("superman", PASSWORD_DEFAULT)),
		array(htmlspecialchars("Dani"), password_hash("blink182", PASSWORD_DEFAULT))
	);
	// search function
	function search_user($user, $pass, $login_matrix)
	{
		foreach($login_matrix as $valid_user)
		{
			if(($valid_user[0] == $user) && password_verify($pass, $valid_user[1]))
			{
				return 1;
			}
		}
		return 0;
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="/css/reset.css" rel="stylesheet">
	<link href="/css/main.css" rel="stylesheet">
	<script src="/js/general.js"></script>
	<title>QS Login</title>
</head>
<body>
	<button id="menu" onclick="toggleMenu()">
		&plus;
	</button>
	<div class="wrapper">
		<header>
			<a href="index.php" title="Home" class="logo">
				<img src="qslogo.png" alt="qs logo">
				<!-- Original Source of the logo:-->
				<!-- https://www.shutterstock.com/it/image-vector/qs-company-linked-letter-logo-green-332472272-->
			</a>
		</header>
		<div class="login_container">
			<div class="form_container">
				<form name="loginForm" method="POST" action="<?php echo($_SERVER["PHP_SELF"]); ?>">
					<p>Login Name:</p>
					<p><input type="text" name="login_name"></p>
					<br>
					<p>Password</p>
					<p><input type="password" name="pass"></p>
					<p><input class="submit_form_button" type="submit" name="login_submitted" value="Log in"></p>
				</form>
			</div>
		</div>
		<div class="login_container">
			<br>
			Not yet registered? 
			<br>
			<form name="register_form" method="POST" action="<?php echo($_SERVER["PHP_SELF"]); ?>">
				<input class="submit_form_button" type="submit" name="register_action" value="Start Registration">
			</form>
		</div>
		<?php
			if (isset($_POST["register_action"]) && !isset($_SESSION["username"]))
			{
		?>
				<div class="login_container">
					<br>
					<label for="login_name_reg"><b>Login Name:</b></label><br>
					<input type="input" class="reg" name="login_name_reg" placeholder="Enter Login Name" required><br>
					<br>
					<label for="password_reg"><b>Password:</b></label><br>
					<input type="password" class="reg" name="password_reg" placeholder="Enter Password" required><br>
					<br>
					<label for="password_repeat_reg"><b>Repeat Password:</b></label><br>
					<input type="password" class="reg" name="password_repeat_reg" placeholder="Repeat Password" required><br>
					<br>
					<label for="email_reg"><b>Email:</b></label><br>
					<input type="text" class="reg" name="email_reg" placeholder="Enter Email" required><br>
					<br>
					<label for="firstname_reg"><b>Fistname:</b></label><br>
					<input type="text" class="reg" name="firstname_reg" placeholder="Enter Firstname" required><br>
					<br>
					<label for="lastname_reg"><b>Lastname:</b></label><br>
					<input type="text" class="reg" name="lastname_reg" placeholder="Enter Lastname" required><br>
					<br>
					<label for="gender_reg"><b>Gender:</b></label><br>
					<input type="radio" name="gender_reg" id="male" value="MA">
					<label for="male">Male</label>&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" name="gender_reg" id="female" value="FE">
					<label for="female">Female</label>&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" name="gender_reg" id="non_binary" value="NB">
					<label for="non_binary">Non Binary</label><br>
					<br>
					<label for="birthdate_reg"><b>Date of Birth:</b></label><br>
					<input type="date" name="birthdate_reg" required><br>
					<br>
					<label for="address_reg"><b>Address:</b></label><br>
					<input type="text" name="address_reg" placeholder="Enter Address" required><br>
					<br>
					<input class="submit_form_button" type="submit" name="submit_registration" value="Register"><br>
					<br>
				</div>	
		<?php
			}
		?>
		<footer>
			<a id="foot_ref" href="https://github.com/Alfredo-Vargas">&copy;avp</a>
		</footer>
	</div>
	<div class="menu_items">
		<ul>
		<li><a href="index.php">Home</a></li>
		<li><a href="producst.php">Products</a></li>
		<li><a href="login.php">Login</a></li>
		</ul>
		<a class="myref" href="https://github.com/Alfredo-Vargas">&copy;avp</a>
	</div>
	<?php
		if (isset($_POST["login_submitted"]) && !empty($_POST["login_name"]) && !empty($_POST["pass"]))
		{
			$user = htmlspecialchars($_POST["login_name"]);
			$pass = htmlspecialchars($_POST["pass"]);

			$validLogin = search_user($user, $pass, $login_matrix);

			if ($validLogin)
			{
				$_SESSION["username"] = $user;
				$_SESSION["pass_hash"] = $pass;
				header("Location: products.php");
			}
		}
	?>
</body>
</html>