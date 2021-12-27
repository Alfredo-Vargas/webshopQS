<?php
    require("./scripts/php_header.php");
    if (!isset($_SESSION["user_login_name"]))
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
	<title>QS Shopping Cart</title>
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
				<!-- https:www.shutterstock.com/it/image-vector/qs-company-linked-letter-logo-green-332472272 -->
			</a	>
		</header>
        <?php
            include("./scripts/cart_link.php");
			include("./scripts/place_order.php");
			if (!empty($_SESSION["user_cart"]) && !$_SESSION["user_just_ordered"])
			{
		?>
		<form name="shopping_cart_form" method="POST" action="<?php echo($_SERVER["PHP_SELF"]); ?>">
		<?php
				require("./scripts/connection.php");
				$array_of_keys = array_keys($_SESSION["user_cart"]);
				$set_of_products = "(" . implode(',', $array_of_keys) . ")";
				$products_query = "SELECT * FROM Products WHERE productID IN". $set_of_products;
				$result = mysqli_query($link, $products_query) or die ("There is a problem with the implementation of the query: \"$products_query\"");
				$number_of_products = mysqli_num_rows($result);
				echo("\n");
				echo("\t\t\t<div class=\"cart_container\">\n");
				$i = 0;
				$total = 0;
				while ($row = mysqli_fetch_array($result))
				{
					$imageLocation = htmlspecialchars($row['imageLocation']);
					$name = htmlspecialchars($row['name']);
					$price = htmlspecialchars($row['price']);
					echo("\t\t\t\t<div class=\"cart_product\">\n");
						echo("\t\t\t\t\t<label> Name: " . $name . "</label><br>\n");
						echo("\t\t\t\t\t<img src=\"" . $imageLocation . "\" alt=\"" . $name . "\"" . " class=\"prod_im_cart\"><br>\n");
						echo("\t\t\t\t\t<label> Quantity: </label>");
						echo("<input type=\"number\" name=\"" . $array_of_keys[$i] . "\" value=\"" . $_SESSION["user_cart"][$array_of_keys[$i]] . "\" class=\"cart_items\" id=\"" . $price . "\" onkeyup=\"updateTotal()\">\n");
					echo("\t\t\t\t</div>\n");
					$total += $price * $_SESSION["user_cart"][$array_of_keys[$i]];
					$i++;
				}
				$_SESSION["user_total"] = $total;
				echo("\t\t\t</div>\n");
				echo("\t\t\t<label id=\"total_price\"> Total: &euro;" . $_SESSION["user_total"] . ";</label><br>\n");
		?>
			<input class="submit_form_button" type="submit" name="place_order_action" value="Place Order">
		</form>
		<?php
			echo("\n");
			}
			elseif ($_SESSION["user_just_ordered"])
			{
		?>
				<div class="login_container">
						<br>
						Your order completed succesfully. Thanks for purchasing from <strong>Q</strong>uality and <strong>S</strong>ustainability.
						<br>
						You can go back to the home index by clickng the <strong>QS</strong> logo (top left corner).
						<br>
						<br>
						<?php $_SESSION["user_just_ordered"] = false; ?>
				</div>
		<?php
			}
			else
			{
		?>
				<div class="login_container">
						<br>
						Hi <?php echo($_SESSION["user_fullname"]); ?>, please do not forget to add some items before placing your order.
						<br>
						Then you can come here to adjust the quantity and finalize your order.
						<br>
						<br>
				</div>
		<?php
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
<?php
	mysqli_stmt_close($stmt);
	mysqli_close($link);
?>
