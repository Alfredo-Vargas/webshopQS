<?php
    include("./scripts/php_header.php");
    if (!isset($_SESSION["user_login_name"]) || $_SESSION["user_isAdmin"] != "1")
    {
		header("Location: login.php");
    }
    if (isset($_POST["modify_product_action"]) && !empty($_POST["c_product_name"]) && !empty($_POST["c_product_manufacturer"]) && !empty($_POST["c_product_category"])
        && !empty($_POST["c_product_location"]) && !empty($_POST["c_product_description"]) && !empty($_POST["c_product_stock"]) && !empty($_POST["c_product_price"]))
    {
        require("./scripts/connection.php");
        $modify_product_query = "UPDATE Products SET name=?,  ";
    }
    if (isset($_POST["delete_action"]) && !empty($_POST["d_userID"]))
    {
        if ($_SESSION["userID"] == $_POST["d_userID"])
        {
            echo ("You cannot delete current user");
        }
        else
        {
            require("./scripts/connection.php");
            $delete_query = "DELETE FROM Users WHERE userID= ?"; 
            $stmt = mysqli_prepare($link, $delete_query);
            $given_id = mysqli_real_escape_string($link, $_POST["d_userID"]);
            mysqli_stmt_bind_param($stmt, "s", $given_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            mysqli_close($link);
?>
            <div class="login_container">
                <br>
                The deletion of the user completed successfully.
                <br>
                <br>
            </div>
<?php
        }
    }
    elseif (isset($_POST["modify_action"]) && !empty($_POST["privileges"]) && !empty($_POST["c_userID"]))
    {
        if ($_SESSION["userID"] == $_POST["c_userID"])
        {
            echo ("You cannot modify current user");
        }
        else
        {
            require("./scripts/connection.php");
            $new_role = $_POST["privileges"] == "Admin User" ? 1 : 0;
            $change_role_query = "UPDATE Users SET isAdmin=? WHERE userID=?";
            $stmt = mysqli_prepare($link, $change_role_query);
            $given_id = mysqli_real_escape_string($link, $_POST["c_userID"]);
            mysqli_stmt_bind_param($stmt, "ss", $new_role, $given_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            mysqli_close($link);
?>
            <div class="login_container">
                <br>
                The modification of the user's privileges completed successfully.
                <br>
                <br>
            </div>
<?php
        }
    }
    elseif (isset($_POST["add_action"]))
    {
        require("./scripts/register_new_user.php");
    }
    elseif (isset($_POST["delete_product_action"]) && !empty($_POST["d_productID"]))
    {
        require("./scripts/connection.php");
        $delete_query = "DELETE FROM Products WHERE productID= ?"; 
        $stmt = mysqli_prepare($link, $delete_query);
        $given_id = mysqli_real_escape_string($link, $_POST["d_productID"]);
        mysqli_stmt_bind_param($stmt, "s", $given_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($link);
    }
    elseif (isset($_POST["start_modify_product_action"]) && !empty($_POST["c_productID"]))
    {
        require("./scripts/connection.php");
        $find_product_query = "SELECT * FROM Products WHERE productID = ?";
        //$result = mysqli_query($link, $find_product_query) or die ("There is a problem with the implementation of the query: \"$find_product_query\"");
        $stmt = mysqli_prepare($link, $find_product_query);
        $given_id = mysqli_real_escape_string($link, $_POST["c_productID"]);
        mysqli_stmt_bind_param($stmt, "s", $given_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_array($result, MYSQLI_NUM);
?>
    <div class="login_container">
        <form name="modify_product_form" method="POST" action="<?php echo($_SERVER["PHP_SELF"]); ?>">
            <label><strong>MODIFYING PRODUCT WITH ID: " <?php echo($_POST["c_productID"]) ?>" AND NAME: "<?php echo($row[1]) ?>"</strong></label><br><br>
            <label for="change_product_name"><b>Product name:</b></label>
            <input type="text" name="c_product_name" id="change_product_name" value="<?php echo($row[1]) ?>"><br><br>
            <label for="change_product_manufacturer"><b>Product manufacturer:</b></label>
            <input type="text" name="c_product_manufacturer" id="change_product_manufacturer" value="<?php echo($row[2]) ?>"><br><br>
            <label for="change_product_category"><b>Product category:</b></label>
            <input type="text" name="c_product_category" id="change_product_category" value="<?php echo($row[3]) ?>"><br><br>
            <label for="change_product_location"><b>Product image location:</b></label>
            <input type="text" name="c_product_location" id="change_product_location" value="<?php echo($row[4]) ?>"><br><br>
            <label for="change_product_description"><b>Product description:</b></label>
            <textarea name="c_product_description" id="change_product_description"> <?php echo($row[5]) ?> </textarea><br><br>
            <label for="change_product_stock"><b>Product stock:</b></label>
            <input type="text" name="c_product_stock" id="change_product_stock" value="<?php echo($row[6]) ?>"><br><br>
            <label for="change_product_price"><b>Product price:</b></label>
            <input type="text" name="c_product_price" id="change_product_price" value="<?php echo($row[7]) ?>"><br>
            <p><input class="submit_form_button" type="submit" name="modify_product_action" value="Submit Modification"></p>
        </form>
    </div>

<?php
        mysqli_stmt_close($stmt);
        mysqli_close($link);
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
            <div class="login_container">
                <form name="admin_form" method="POST" action="<?php echo($_SERVER["PHP_SELF"]); ?>">
                    <label><strong>Choose a table to display:</strong></label><br><br>
                    <input type="radio" name="admin_options" id="u_table" value="u_table">
                    <label for="u_table">Users Table</label>&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="admin_options" id="p_table" value="p_table">
                    <label for="p_table">Products Table</label>&nbsp;&nbsp;&nbsp;&nbsp;
                    <p><input class="submit_form_button" type="submit" name="display_table" value="Show Table"></p>
                </form>
            </div>
        <?php
            if ((isset($_POST["display_table"]) && !empty($_POST["admin_options"])) || isset($_SESSION["admin_active"]))
            {
                if (!isset($_POST["display_table"]))
                {
                    if ($_SESSION["admin_active"] == "show_u_table")
                    {
                        require("./scripts/show_u_table.php");
                    }
                    else
                    {
                        require("./scripts/show_p_table.php");
                    }
                }
                else
                {
                    if ($_POST["admin_options"] == "u_table")
                    {
                        $_SESSION["admin_active"] = "show_u_table";
                        require("./scripts/show_u_table.php");
                    }
                    elseif ($_POST["admin_options"] == "p_table")
                    {
                        $_SESSION["admin_active"] = "show_p_table";
                        require("./scripts/show_p_table.php");
                    }
                }
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