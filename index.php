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
	<title>QS Home</title>
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

		<div class="random_phrase">
			<?php
				$filename = "phrases.txt";	
				if (!file_exists($filename))
				{
					echo ("<h1>When sustainability meets quality.</h1>");
				}
				else{
					$file = @fopen($filename, "r") or die ("Unable to open the file"); 
					$phrases = array();
					$index = 0;
					while(!feof($file))
					{
						$line = fgets($file);
						$phrases[$index] = $line;
						$index++;
					}
					$random = rand(0, $index - 1);
					echo ("<h1>" . $phrases[$random] . "</h1>");
					@fclose($file);
				}
			?>
		</div>
		<div class="products_container">
			<div class="concept">
				<strong>Q&S. </strong> It is not surprising that these two characteristics do not always come together in a single product. 
				In one hand we have products that have been manufactured using the most high technology which results
				in a high quality product at a reasonable price but which are not sustainable to the environment. On the 
				other hand you have new products which are eco-friendly but have not yet reach the quality of the other non-eco friendly
				products. If you are customer like me who encounters this dilema frequently, you've come to the right place. Here I will present to you
				<strong>only</strong> products which meet these two standards: Quality & Sustaniablity. 
			</div>
			<?php
				$host = "localhost";
				$user = "Webuser";
				$password = "Lab2021";
				$database = "qswebshop";
				$link = mysqli_connect($host, $user, $password) or die ("There was not connection acquired with $host");
				mysqli_select_db($link, $database) or die ("Database $database not available");

				// To display one product of each category in the index page
				$query = "SELECT DISTINCT * FROM Products GROUP BY Category";  

				$result = mysqli_query($link, $query) or die ("There is a problem with the implementation of the query: \"$query\"");
				echo("\n");
				$number_of_categories = mysqli_num_rows($result);
				while ($row = mysqli_fetch_array($result))
				{
					$imageLocation = htmlspecialchars($row['imageLocation']);
					$name = htmlspecialchars($row['name']);
					$description = htmlspecialchars($row['description']);
					$price = htmlspecialchars($row['price']);
					echo ("\t\t\t\t<div class=\"product_example\">\n");
						echo("\t\t\t\t<figure>\n");
							echo("\t\t\t\t\t<img src=\"" . $imageLocation . "\" alt=\"" . $name . "\"" . ">\n");
							echo("\t\t\t\t\t<figcaption>" . "<strong>" . $name . "</strong>. - " . $description . "</figcaption>\n");
						echo("\t\t\t\t</figure>\n");
						echo("\t\t\t\t\tPrice: <strong> &euro;" . $price . "</strong>\n");
					echo("\t\t\t\t</div>\n");
				}
			?>
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