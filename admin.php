<?php
    include("./scripts/php_header.php");
    if (!isset($_SESSION["user_login_name"]) || $_SESSION["user_isAdmin"] != "1")
    {
		header("Location: login.php");
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
	<title>QS Administrator</title>
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
            require("./scripts/connection.php");
        ?>
        <form name="admin_form" method="POST" action="<?php echo($_SERVER["PHP_SELF"]); ?>">
            <label for="admin_options"><b>Choose a table to display:</b></label><br>
            <input type="radio" name="admin_options" id="u_table" value="u_table">
            <label for="u_table">Users Table</label>&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" name="admin_options" id="p_table" value="p_table">
            <label for="p_table">Products Table</label>&nbsp;&nbsp;&nbsp;&nbsp;
            <p><input class="submit_form_button" type="submit" name="display_table" value="Show Table"></p>
        </form>
		<footer>
			<a id="foot_ref" href="https://github.com/Alfredo-Vargas/webshopQS">&copy;avp</a>
		</footer>
	</div>
    <?php
        include("./scripts/main_menu.php");
    ?>
</body>
</html>