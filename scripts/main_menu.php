    <div class="menu_items">
            <ul>
		<li><a href="index.php">Home</a></li>
		<li><a href="products.php">Products</a></li>
		<?php
			if (isset($_SESSION["user_login_name"]))
			{
                if($_SESSION["user_isAdmin"] == "1")
                {
        ?>
				<li><a href="promotions.php">Promotions</a></li>
				<li><a href="cart.php">Cart</a></li>
				<li><a href="admin.php">Admin</a></li>
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
				<li><a href="promotions.php">Promotions</a></li>
				<li><a href="cart.php">Cart</a></li>
				<li>
					<form name="logout_form" method="POST" action="<?php echo($_SERVER["PHP_SELF"]); ?>">
						<input id="logout" type="submit" name="logout_action" value="Logout">
					</form>
				</li>
        <?php
                }
		?>
		<?php
			}
			else
			{
		?>
				<li><a href="login.php">Login</a></li>
		<?php
			}
		?>
		</ul>
		<a class="myref" href="https://github.com/Alfredo-Vargas">&copy;avp</a>
	</div>