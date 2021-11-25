<?php
	session_start();
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
	<title>QS Shopping Cart</title>
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
		<div class="cart_icon_container">
			<div>
				<a href="cart.php" title="Shopping Cart" class="cart_icon" >
					<img src="cart.png" alt="shopping cart" id="cart_icon">
					<!-- Original Source of the shopping cart image:-->
					<!--https://www.iconsdb.com/custom-color/shopping-cart-icon.html-->
				</a>
			</div>
		</div>
		<div class="cart_container">
			<div class="cart_product">Product1</div>
			<div class="cart_product">Product2</div>
			<div class="cart_product">Product3</div>
			<div class="cart_product">Product4</div>
			<div class="cart_product">Product1</div>
			<div class="cart_product">Product2</div>
			<div class="cart_product">Product3</div>
			<div class="cart_product">Product4</div>
			<div class="cart_product">Product1</div>
			<div class="cart_product">Product2</div>
			<div class="cart_product">Product3</div>
			<div class="cart_product">Product4</div>
			<div class="cart_product">Product1</div>
			<div class="cart_product">Product2</div>
			<div class="cart_product">Product3</div>
			<div class="cart_product">Product4</div>
		</div>
		<footer>
			<a id="foot_ref" href="https://github.com/Alfredo-Vargas/webshopQS">&copy;avp</a>
		</footer>
	</div>
	<div class="menu_items">
		<ul>
		<li><a href="index.php">Home</a></li>
		<li><a href="products.php">Products</a></li>
		<?php
			if (isset($_SESSION["user_login_name"]))
			{
		?>

				<li><a href="promotions.php">Promotions</a></li>
				<li><a href="cart.php">Cart</a></li>
				<li>
					<form name="logout_form" method="POST" action="<?php echo($_SERVER["PHP_SELF"]); ?>">
						<input id="logout" type="submit" name="logout_action" value="Logout">
					</form>
				</li>
		<?php
			}
			else
			{
		?>

				<li><a href="login.php">Login</a></li>
		<?php
			}
			if (isset($_POST["logout_action"]) && isset($_SESSION["user_login_name"]))
			{
				session_unset();
				session_destroy();
				header("Location: index.php");
			}
		?>
		</ul>
		<a class="myref" href="https://github.com/Alfredo-Vargas">&copy;avp</a>
	</div>
</body>
</html>