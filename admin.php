<?php
    include("./scripts/php_header.php");
    if (!isset($_SESSION["user_login_name"]) || $_SESSION["user_isAdmin"] != "1")
    {
		header("Location: login.php");
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
            $given_id = $_POST["d_userID"];
            mysqli_stmt_bind_param($stmt, "s", $given_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            mysqli_close($link);
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
            $given_id = $_POST["c_userID"];
            mysqli_stmt_bind_param($stmt, "ss", $new_role, $given_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            mysqli_close($link);
        }
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
            if (isset($_POST["display_table"]) && !empty($_POST["admin_options"]))
            {
                if ($_POST["admin_options"] == "u_table")
                {
                    require("./scripts/show_u_table.php");
                }
                elseif ($_POST["admin_options"] == "p_table")
                {
                    require("./scripts/show_p_table.php");
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