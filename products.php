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
	<title>QS Products</title>
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

		<h2>Sustainable Products:</h2>
		<div class="products_container">
			<?php
				$host = "localhost";
				$user = "Webuser";
				$password = "Lab2021";
				$database = "qswebshop";
				$link = mysqli_connect($host, $user, $password) or die ("There was not connection acquired with $host");
				mysqli_select_db($link, $database) or die ("Database $database not available");
				$query = "SELECT * FROM Products";		// to display all products from the database
				$result = mysqli_query($link, $query) or die ("There is a problem with the implementation of the query: \"$query\"");
				echo("\n");
				while ($row = mysqli_fetch_array($result))
				{
					echo("\t\t\t<div class=product>\n");
						echo("\t\t\t\t<figure>\n");
							echo("\t\t\t\t\t<img src=\"" . $row['imageLocation'] . "\" alt=\"" . $row['name'] . "\"" . ">\n");
							//echo("<figcaption><strong>" .$row['name'] . "</strong></figcaption>\n");
							//echo("\t\t\t\t\t<figcaption>" . "<strong>" . $row['name'] . "</strong>. - " . $row['description'] . "</figcaption>\n");
						echo("\t\t\t\t</figure>\n");
						echo("\t\t\t\t\tPrice: <strong> &euro;" . $row['price']. "</strong>\n");
					echo("\t\t\t</div>\n");
				}
				echo("\n");
			?>
		</div>
		<?php
			mysqli_close($link);
		?>
		<footer>
			<a id="foot_ref" href="https://github.com/Alfredo-Vargas">&copy;avp</a>
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