		<?php
			if (isset($_SESSION["user_login_name"]))
			{
		?>
		<div class="cart_icon_container">
			<div>
				<a href="cart.php" title="Shopping Cart" class="cart_icon" >
					<img src="../website_features/cart.png" alt="shopping cart" id="cart_icon">
					<!-- Original Source of the shopping cart image:-->
					<!--https://www.iconsdb.com/custom-color/shopping-cart-icon.html-->
				</a>
			</div>
		</div>
		<?php
			}
			else
			{
		?>
		<div class="cart_icon_container">
			<div>
				<a href="login.php" title="Shopping Cart" class="cart_icon" >
					<img src="../website_features/cart.png" alt="shopping cart" id="cart_icon">
					<!-- Original Source of the shopping cart image:-->
					<!--https://www.iconsdb.com/custom-color/shopping-cart-icon.html-->
				</a>
			</div>
		</div>
		<?php
			}
		?>