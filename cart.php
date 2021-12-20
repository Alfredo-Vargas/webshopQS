<?php
    include("./scripts/php_header.php");
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
	<button id="menu" onclick="toggleMenu()">
<body>
		&plus;
	</button>
	<div class="wrapper">
		<header>
			<a href="index.php" title="Home" class="logo">
				<img src="./website_features/qslogo.png" alt="qs logo">
				<!-- Original Source of the logo:-->
				<!-- https://www.shutterstock.com/it/image-vector/qs-company-linked-letter-logo-green-332472272-->
			</a	>
		</header>

        <?php
            include("./scripts/cart_link.php");
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
								echo("<input type=\"text\" name=\"" . $array_of_keys[$i] . "\" value=\"" . $_SESSION["user_cart"][$array_of_keys[$i]] . "\" class=\"cart_items\" id=\"" . $price . "\" onkeyup=\"updateTotal()\">\n");
							echo("\t\t\t\t</div>\n");
							$total += $price * $_SESSION["user_cart"][$array_of_keys[$i]];
							$i++;
						}
						$_SESSION["user_total"] = $total;
				/*
				while ($row = mysqli_fetch_array($result))
				{
                    $productID = htmlspecialchars($row['productID']);
					$imageLocation = htmlspecialchars($row['imageLocation']);
					$name = htmlspecialchars($row['name']);
					$description = htmlspecialchars($row['description']);
					$price = htmlspecialchars($row['price']);
					echo("\t\t\t<div class=product>\n");
						echo("\t\t\t\t<figure>\n");
							echo("\t\t\t\t\t<img src=\"" . $imageLocation . "\" id=\"". $productID ."\" alt=\"" . $name . "\"" . " title=\"Click to Add to Shopping Cart\" onclick=\"change_cart(this.id)\" class=\"prod_im\">\n");
							echo("\t\t\t\t\t<figcaption>" . "<strong>" . $name . "</strong>. - " . $description . "</figcaption>\n");
						echo("\t\t\t\t</figure>\n");
						echo("\t\t\t\t\tPrice: <strong> &euro;" . $price . "</strong>\n");
					echo("\t\t\t</div>\n");
				}
				echo("\n");
				*/
				echo("\t\t\t</div>\n");
				echo("\t\t\t<label id=\"total_price\"> Total: &euro;" . $_SESSION["user_total"] . ";</label><br>\n");
			?>
			<input class="submit_form_button" type="submit" name="place_order_action" value="Place Order">
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
