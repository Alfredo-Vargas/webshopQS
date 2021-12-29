<?php
    require ("./scripts/php_header.php");
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
				<img src="./website_features/qslogo.png" alt="qs logo">
				<!-- Original Source of the logo:-->
				<!-- https://www.shutterstock.com/it/image-vector/qs-company-linked-letter-logo-green-332472272-->
			</a>
		</header>
        <?php
            include("./scripts/cart_link.php");
        ?>
		<div class="login_container">
			<div class="form_container">
				<form name="login_form" method="POST" action="<?php echo($_SERVER["PHP_SELF"]); ?>">
					<p>Login Name:</p>
					<p><input type="text" name="login_name"></p>
					<br>
					<p>Password</p>
					<p><input type="password" name="pass"></p>
					<p><input class="submit_form_button" type="submit" name="login_submitted" value="Log in"></p>
				</form>
			</div>
		</div>
		<?php
			if (isset($_POST["login_submitted"]) && !empty($_POST["login_name"]) && !empty($_POST["pass"]))
			{
				require("./scripts/connection.php");
				// Create a prepare statement to load user credentials/data after login
				$login_query = "SELECT * FROM Users WHERE loginName = ?";
				$stmt = mysqli_prepare($link, $login_query);
				// Bind parameters
				$searchLoginName = trim($_POST["login_name"]);
				mysqli_stmt_bind_param($stmt, "s", $searchLoginName);
				// Execute query
				mysqli_stmt_execute($stmt);
				// echo mysqli_stmt_num_rows($stmt);
				// Bind results
				mysqli_stmt_bind_result($stmt, $t_userID, $t_loginName, $t_email, $t_firstName, $t_lastName, $t_gender, $t_isAdmin, $_dateOfBirth, $t_address, $t_hashPassword);
				mysqli_stmt_fetch($stmt);

				if (password_verify($_POST["pass"], $t_hashPassword))
				{
                    $_SESSION["userID"] = htmlspecialchars($t_userID);
					$_SESSION["user_login_name"] = htmlspecialchars($t_loginName);
					$_SESSION["user_fullname"] = htmlspecialchars($t_firstName) . " " . htmlspecialchars($t_lastName);
					$_SESSION["user_gender"] = htmlspecialchars($t_gender);
					$_SESSION["user_email"] = htmlspecialchars($t_email);
					$_SESSION["user_dateOfBirth"] = htmlspecialchars($t_dateOfBirth);
					$_SESSION["user_address"] = htmlspecialchars($t_address);
					$_SESSION["user_isAdmin"] = htmlspecialchars($t_isAdmin);
					$_SESSION["user_cart"] = array();
					$_SESSION["user_items"] = 0;
					$_SESSION["user_total"] = 0;
					$_SESSION["user_just_ordered"] = false;

					mysqli_stmt_close($stmt);
					mysqli_close($link);
                    if ($_SESSION["user_isAdmin"] == "1")
                    {
                        header("Location: admin.php");
                    }
                    else
                    {
                        header("Location: products.php");
                    }
				}
				else
				{
					mysqli_stmt_close($stmt);
					mysqli_close($link);
					trigger_error(" Failed login attempt.", E_USER_WARNING);
		?>
					<div class="login_container">
						The login credentials are incorrect. Login process failed.<br>
						Please verify login name and password and try again.
					</div>
		<?php
				}
			}
		?>
		<div class="login_container">
			<br>
			Not yet registered? 
			<br>
			<form name="register_form_action" method="POST" action="<?php echo($_SERVER["PHP_SELF"]); ?>">
				<input class="submit_form_button" type="submit" name="register_action" value="Start Registration">
			</form>
		</div>
		<?php
			// Here begins register action if user has pressed Start Registration and if the user is not logged in.
			if (isset($_POST["register_action"]) && !isset($_SESSION["username"]))
			{
			echo("\n"); // to get rid off the auto tab feature of HTML
		?>

			<form name="register_form" method="POST" action="<?php echo($_SERVER["PHP_SELF"]); ?>" onSubmit="return validatePassword()">
				<div class="login_container">
					<br>
					<label><b>Login Name:</b></label><br>
					<input type="text" class="reg" name="login_name_reg" placeholder="Enter Login Name" required><br>
					<br>
					<label><b>Password:</b></label><br>
					<input type="password" class="reg" id="js_pass" name="password_reg" placeholder="Enter Password" required><br>
					<br>
					<label><b>Repeat Password:</b></label><br>
					<input type="password" class="reg" id="js_pass_rep" name="password_repeat_reg" placeholder="Repeat Password" required><br>
					<br>
					<label><b>Email:</b></label><br>
					<input type="text" class="reg" name="email_reg" placeholder="Enter Email" required><br>
					<br>
					<label><b>Fistname:</b></label><br>
					<input type="text" class="reg" name="firstname_reg" placeholder="Enter Firstname" required><br>
					<br>
					<label><b>Lastname:</b></label><br>
					<input type="text" class="reg" name="lastname_reg" placeholder="Enter Lastname" required><br>
					<br>
					<label><b>Gender:</b></label><br>
					<input type="radio" name="gender_reg" id="male" value="MA">
					<label for="male">Male</label>&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" name="gender_reg" id="female" value="FE">
					<label for="female">Female</label>&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" name="gender_reg" id="non_binary" value="NB">
					<label for="non_binary">Non Binary</label><br>
					<br>
					<label><b>Date of Birth:</b></label><br>
					<input type="date" name="birthdate_reg" required><br>
					<br>
					<label><b>Address:</b></label><br>
					<input type="text" name="address_reg" placeholder="Enter Address" required><br>
					<br>
					<input class="submit_form_button" type="submit" name="submit_registration" value="Register"><br>
					<br>
				</div>	
			</form>
		<?php
			}
			// Here ends registration form
		?>
		<?php
			// check if POST array exists:
			if (isset($_POST["submit_registration"]))
			{
        ?>
        <?php
                require("./scripts/register_new_user.php");
			}
		?>
		<footer>
			<a id="foot_ref" href="https://github.com/Alfredo-Vargas/webshopQS">&copy;avp</a>
		</footer>
	</div>
    <?php
        include("./scripts/main_menu.php");
    ?>
</body>
</html>
