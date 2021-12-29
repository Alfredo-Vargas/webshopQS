<?php
    include("./scripts/php_header.php");
    try
    {
        //if (!isset($_SESSION["user_login_name"]) || $_SESSION["user_isAdmin"] != "1")
        if ($_SESSION["user_isAdmin"] != "1")
        {
            throw new MyException("Attemption of path traversal to admin page!");
        }
    }
    catch (MyException $e)
    {
        $e->HandleException();
    }
    /*
    if (!isset($_SESSION["user_login_name"]) || $_SESSION["user_isAdmin"] != "1")
    {
		header("Location: login.php");
    }
    */
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
<?php
    if (isset($_POST["modify_product_action"]) && !empty($_POST["c_product_name"]) && !empty($_POST["c_product_manufacturer"]) && !empty($_POST["c_product_category"])
        && !empty($_FILES["c_product_image"]) && !empty($_POST["c_product_description"]) && !empty($_POST["c_product_stock"]) && !empty($_POST["c_product_price"]) && ! empty($_POST["c_productID"]))
    {
        /* DO NOT FORGET TO MODIFY THE PRIVILEGES OF THE WebUser TO DEAL WITH FILES !!! */
        require("./scripts/connection.php");
        $target_dir = "./product_images/";
        $temp_file_location = $_FILES["c_product_image"]["tmp_name"];
        // The following function basename is used to obtain the base name in case the full path of the file is also given. THIS CAN PREVEN PATH TRAVERSAL ATTACKS!!
        $basename_file = basename($_FILES["c_product_image"]["name"]);
        $target_file = $target_dir . $basename_file;
        $image_extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));  # To get only the extension of the file
        // The getimagesize retrieves: size, dimensions, file type, text string describing height/width
        $check_image = getimagesize($_FILES["c_product_image"]["tmp_name"]);  # tmp_name is the location name given by the multiarray $_FILES["c_product_image"] of the uploaded file
        $image_is_ok = $check_image !== false ? true : false;
        $image_uploaded = false;
        if ($image_extension != "jpg" && $image_extension != "png")
        {
            echo("You cannot upload file of this type");
            $image_is_ok = false;
        }
        $modify_product_query = "UPDATE Products SET name=?, manufacturer=?, category=?, imageLocation=?, description=?, stock=?, price=?
                                WHERE productID=?  ";
        $stmt = mysqli_prepare($link, $modify_product_query);
        $given_name = mysqli_real_escape_string($link, $_POST["c_product_name"]);
        $given_manufacturer = mysqli_real_escape_string($link, $_POST["c_product_manufacturer"]);
        $given_category = mysqli_real_escape_string($link, $_POST["c_product_category"]);
        $given_imageLocation = mysqli_real_escape_string($link, $target_file);
        $given_description = mysqli_real_escape_string($link, $_POST["c_product_description"]);
        $given_stock = mysqli_real_escape_string($link, $_POST["c_product_stock"]);
        $given_price = mysqli_real_escape_string($link, $_POST["c_product_price"]);
        $given_id = mysqli_real_escape_string($link, $_POST["c_productID"]);
        mysqli_stmt_bind_param($stmt, "ssssssss", $given_name, $given_manufacturer, $given_category, $given_imageLocation, $given_description, $given_stock, $given_price, $given_id);
        if ($image_is_ok)
        {
            mysqli_stmt_execute($stmt);
            if (move_uploaded_file($temp_file_location, $target_file))
            {
                $image_uploaded = true;
            }
            else
            {

                $image_uploaded = false;
                $image_is_ok = false;
            }
        }
        else
        {
            echo("File is not an image\n");
        }
        mysqli_stmt_close($stmt);
        mysqli_close($link);
        if ($image_is_ok && $image_uploaded)
        {
?>
            <div class="login_container">
                <br>
                The modification of the product completed successfully.
                <br>
                <br>
            </div>
<?php
        }
        elseif($image_is_ok && !$image_uploaded)
        {
?>
            <div class="login_container">
                <br>
                Something went wrong when uploading the image of the product. The other attributes of the article were succesfully updated.
                <br>
                <br>
            </div>
<?php
        }
    }
?>
<?php
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
                The modification of the user&apos;s privileges completed successfully.
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
?>
        <div class="login_container">
            <br>
            The deletion of the product completed successfully.
            <br>
            <br>
        </div>
<?php
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
        // In the next form "modify_product_form" the enctype="multipart/form-data" is required when uploading an image
?>
    <div class="login_container">
        <form name="modify_product_form" method="POST" action="<?php echo($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <br><br>
            <label><strong>MODIFYING PRODUCT WITH ID: " <?php echo($_POST["c_productID"]) ?>" AND NAME: "<?php echo($row[1]) ?>"</strong></label><br><br>
            <input type="hidden" id="pID" name="c_productID" value="<?php echo($_POST["c_productID"]) ?>">
            <label for="change_product_name"><b>Product name:</b></label>
            <input type="text" name="c_product_name" id="change_product_name" value="<?php echo($row[1]) ?>"><br><br>
            <label for="change_product_manufacturer"><b>Product manufacturer:</b></label>
            <input type="text" name="c_product_manufacturer" id="change_product_manufacturer" value="<?php echo($row[2]) ?>"><br><br>
            <label for="change_product_category"><b>Product category:</b></label>
            <input type="text" name="c_product_category" id="change_product_category" value="<?php echo($row[3]) ?>"><br><br>
            <label for="upload_product_image"><b>Product image (jpg, png):</b></label>
            <input type="file" name="c_product_image" id="upload_product_image" value="<?php echo($row[4]) ?>"><br><br>
            <label for="change_product_description"><b>Product description:</b></label>
            <textarea name="c_product_description" id="change_product_description"><?php echo($row[5]) ?></textarea><br><br>
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
    elseif (isset($_POST["add_product_action"]) && !empty($_POST["new_name"]) && !empty($_POST["new_manufacturer"]) && !empty($_POST["new_category"])
    && !empty($_POST["new_location"]) && !empty($_POST["new_description"]) && !empty($_POST["new_stock"]) && !empty($_POST["new_price"]))
    {
        require("./scripts/connection.php");
        $p_name = mysqli_real_escape_string($link, $_POST["new_name"]);
        $p_manufacturer = mysqli_real_escape_string($link, $_POST["new_manufacturer"]);
        $p_category = mysqli_real_escape_string($link, $_POST["new_category"]);
        $p_location = mysqli_real_escape_string($link, $_POST["new_location"]);
        $p_description = mysqli_real_escape_string($link, $_POST["new_description"]);
        $p_stock = mysqli_real_escape_string($link, $_POST["new_stock"]);
        $p_price = mysqli_real_escape_string($link, $_POST["new_price"]);
        $add_product_query = "INSERT INTO Products
                              (name, manufacturer, category, imageLocation, description, stock, price)
                              VALUES
                              (" . "\"" . $p_name . "\", \"" . $p_manufacturer . "\", \"" . $p_category . "\", \"" . $p_location . "\", \"" .
                               $p_description . "\", " . $p_stock . ", " . $p_price . ")";
        $result_add = mysqli_query($link, $add_product_query) or die ("An error occurred during the execution of the query: \"$add_product_query\"");
        mysqli_close($link);
?>
        <div class="login_container">
            <br>
            The addition of the product completed successfully.
            <br>
            <br>
        </div>
<?php
    }
?>
            <div class="login_container">
                <form name="admin_form" method="POST" action="<?php echo($_SERVER["PHP_SELF"]); ?>">
                    <br><br>
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
