<?php
    require("./scripts/connection.php");
    $products_query = "SELECT * FROM Products";
    $result = mysqli_query($link, $products_query) or die ("There is a problem with the implementation of the query: \"$products_query\"");
    echo("\n");
    $number_of_products = mysqli_num_rows($result);
?>
    <div class="table_container">
        <table>
            <tr>
                <th>Product ID</th> <th>Name</th> <th>Manufacturer</th> <th>Category</th> <th>Image Location</th> <th>Description</th> <th>Stock</th> <th>Price</th>
            </tr>
<?php
    while ($row = mysqli_fetch_array($result))
    {
        $t_productID = htmlspecialchars($row["productID"]);
        $t_name = htmlspecialchars($row["name"]);
        $t_manufacturer = htmlspecialchars($row["manufacturer"]);
        $t_category = htmlspecialchars($row["category"]);
        $t_imageLocation = htmlspecialchars($row["imageLocation"]);
        $t_description = htmlspecialchars($row["description"]);
        $t_stock = htmlspecialchars($row["stock"]);
        $t_price = htmlspecialchars($row["price"]);
?>
<?php
        echo("\t\t<tr>\n");
            echo("\t\t\t<td>" . $t_productID . "</td> <td>" . $t_name .  "</td> <td>" . $t_manufacturer . "</td> <td>" . $t_category . "</td> <td>" . $t_imageLocation . "</td> <td>" . $t_description . "</td> <td>" . $t_stock . "</td> <td>" . $t_price . "</td>\n");
        echo("\t\t</tr>\n");
    }
        mysqli_close($link);
?>
        </table>
        <br>
        <br>
    </div>

    <div class="admin_actions_container">
        <form name="delete_product_form" method="POST" action="<?php echo($_SERVER["PHP_SELF"]); ?>">
            <label><strong>DELETE PRODUCT</strong></label><br><br>
            <label><b>Product ID:</b></label><br>
            <input type="text" name="d_productID" id="d_product"><br>
            <input class="submit_form_button" type="submit" name="delete_product_action" value="Delete Product">
        </form>
        <br><br>
        <form name="start_modify_product_action" method="POST" action="<?php echo($_SERVER["PHP_SELF"]); ?>">
            <label><strong>MODIFY PRODUCT</strong></label><br><br>
            <label for="change_productID"><b>Select product ID to be modified:</b></label><br>
            <input type="text" name="c_productID" id="change_productID"><br>
            <p><input class="submit_form_button" type="submit" name="start_modify_product_action" value="Modify Product"></p>
        </form>
        <br><br>
        <form name="add_product_form" method="POST" action="<?php echo($_SERVER["PHP_SELF"]); ?>">
            <label><strong>ADD NEW PRODUCT</strong></label><br><br>
            <label><b>Login Name:</b></label><br>
            <input type="text" class="reg" name="login_name_reg" placeholder="Enter Login Name" required><br>
            <br>
            <label><b>Password:</b></label><br>
            <input type="password" class="reg" id="js_pass" name="password_reg" placeholder="Enter Password" required><br>
            <br>
            <label><b>Repeat Password:</b></label><br>
            <input type="password" class="reg" id="js_pass_rep" name="password_repeat_reg" placeholder="Repeat Password" required><br>
            <br>
            <label><b>Email:</b></label><br>
            <input type="text" class="reg" name="email_reg" placeholder="Enter Email" required><br>
            <br>
            <label><b>Fistname:</b></label><br>
            <input type="text" class="reg" name="firstname_reg" placeholder="Enter Firstname" required><br>
            <br>
            <label><b>Lastname:</b></label><br>
            <input type="text" class="reg" name="lastname_reg" placeholder="Enter Lastname" required><br>
            <br>
            <label><b>Gender:</b></label><br>
            <input type="radio" name="gender_reg" id="male" value="MA">
            <label for="male">Male</label>&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" name="gender_reg" id="female" value="FE">
            <label for="female">Female</label>&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" name="gender_reg" id="non_binary" value="NB">
            <label>Non Binary</label><br>
            <br>
            <label><b>Date of Birth:</b></label><br>
            <input type="date" name="birthdate_reg" required><br>
            <br>
            <label><b>Address:</b></label><br>
            <input type="text" name="address_reg" placeholder="Enter Address" required><br>
            <p><input class="submit_form_button" type="submit" name="add_product_action" value="Add Product"></p>
        </form>
    </div>
