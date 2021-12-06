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
            <label><b>Name:</b></label><br>
            <input type="text" class="reg" name="new_name" placeholder="Enter Product Name" required><br>
            <br>
            <label><b>Manufacturer:</b></label><br>
            <input type="text" class="reg" name="new_manufacturer" placeholder="Enter Manufacturer" required><br>
            <br>
            <label><b>Category:</b></label><br>
            <input type="text" class="reg" name="new_category" placeholder="Enter Category" required><br>
            <br>
            <label><b>Image Location:</b></label><br>
            <input type="text" class="reg" name="new_location" placeholder="Enter Image Location" required><br>
            <br>
            <label><b>Description:</b></label><br>
            <textarea name="new_description"></textarea>
            <br>
            <label><b>Stock:</b></label><br>
            <input type="text" class="reg" name="new_stock" placeholder="Enter Stock" required><br>
            <br>
            <label><b>Price:</b></label><br>
            <input type="text" name="new_price" required><br>
            <br>
            <p><input class="submit_form_button" type="submit" name="add_product_action" value="Add Product"></p>
        </form>
    </div>
