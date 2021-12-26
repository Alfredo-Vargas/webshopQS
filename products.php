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
	<title>QS Products</title>
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
            include ("./scripts/cart_link.php");
        ?>
		<h2>Sustainable Products:</h2>
        <div class="filter_form_container">
            <form name="filter_form" method="POST" action="<?php echo($_SERVER["PHP_SELF"]); ?>">
                <label for="filter_menu"><b>Show products: </b></label>
                <select id="filter_menu" name="filter" onchange="filterProducts(this.value)">
                    <option value="All">All</option>
                    <option value="cheapest">cheapest</option>
                    <option value="party">party</option>
                    <option value="school&office">school&office</option>
                    <option value="personal">personal</option>
                    <option value="cleaning">cleaning</option>
                </select>
                <input type="submit" name="submit_filter" value="Filter" id="filter_button">
            </form>
        </div>
		<br>
        <div class="login_container">
            <br>
            <p>
				Add products by clicking on them (requires registration).
            </p>
            <br>
        </div>
		<div class="products_container" id="prod_container">
			<?php
				require("./scripts/connection.php");
                if (!isset($_POST["submit_filter"]))
                {
                    $query = "SELECT * FROM Products";		// to display all products from the database
                    $result = mysqli_query($link, $query) or die ("There is a problem with the implementation of the query: \"$query\"");
                }
                else
                {
                    require("./scripts/fetch_products.php");
                }
				echo("\n");
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
			?>
		</div>
		<?php
			mysqli_close($link);
		?>
		<footer>
			<a id="foot_ref" href="https://github.com/Alfredo-Vargas">&copy;avp</a>
		</footer>
	</div>
    <?php
        include("./scripts/main_menu.php");
    ?>
</body>
</html>
