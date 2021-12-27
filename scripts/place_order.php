<?php
if (isset($_POST["place_order_action"]))
    {
        if (!empty($_SESSION["userID"]) && !empty($_SESSION["user_cart"]) && $_SESSION["user_total"] != 0 )
            {
                // We insert the Order into the table Orders
                require("./scripts/connection.php");
                $place_order_query = "INSERT INTO Orders
                                        (date, deliveryAddress, isPayed, isDelivered, userID)
                                        VALUES (?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($link, $place_order_query);
                $given_uid = mysqli_real_escape_string($link, $_SESSION["userID"]);
                $given_uaddress = mysqli_real_escape_string($link, $_SESSION["user_address"]);
                $given_ispayed = mysqli_real_escape_string($link, 0);
                $given_isdelivered = mysqli_real_escape_string($link, 0);
                $phptime = date('Y-m-d H:i:s');
                $given_date = mysqli_real_escape_string($link, $phptime);
                mysqli_stmt_bind_param($stmt, "sssss", $given_date, $given_uaddress, $given_ispayed, $given_isdelivered, $given_uid);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                mysqli_close($link);

                // We insert the Order Details into the table OrderDetails
                require("./scripts/connection.php");
                $get_orderid_query = "SELECT orderID FROM Orders WHERE date = \"" . $phptime . "\" and userID = ". $_SESSION["userID"];
                $uc_keys = array_keys($_SESSION["user_cart"]);
                $result_query_orderid = mysqli_query($link, $get_orderid_query) or die ("An error occurred during the execution of the query: \"$get_orderid_query\"");
                $orderid = mysqli_fetch_array($result_query_orderid);
                mysqli_close($link);
                $ndf = count($_SESSION["user_cart"]);  // number of different products
                for ($i = 0; $i < $ndf; $i++)
                {
                    require("./scripts/connection.php");
                    $order_details_query = "INSERT INTO OrderDetails
                                            (orderID, productID, quantity)
                                            VALUES (?, ?, ?);";
                    $stmt = mysqli_prepare($link, $order_details_query);
                    $given_orderid = mysqli_real_escape_string($link, $orderid[0]);
                    $given_productid = mysqli_real_escape_string($link, $uc_keys[$i]);
                    $given_quantity = mysqli_real_escape_string($link, $_POST[$uc_keys[$i]]);
                    //$given_quantity = mysqli_real_escape_string($link, $_SESSION["user_cart"][$uc_keys[$i]]);
                    mysqli_stmt_bind_param($stmt, "sss", $given_orderid, $given_productid, $given_quantity);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
                    mysqli_close($link);
                    
                    require("./scripts/connection.php");
                    // we get the old stock
                    $get_old_stock_query = "SELECT stock FROM Products WHERE productID=". $uc_keys[$i];
                    $result_old_stock = mysqli_query($link, $get_old_stock_query) or die ("An error occurred during the execution of the query: \"$get_old_stock_query\"");
                    $old_stock = mysqli_fetch_array($result_old_stock);
                    $new_stock = (int)$old_stock[0] - $_POST[$uc_keys[$i]];
                    // we update stock
                    $update_stock_query = "UPDATE Products SET stock=? WHERE productID=?";
                    $stmt1 = mysqli_prepare($link, $update_stock_query);
                    $given_stock = mysqli_real_escape_string($link, $new_stock);
                    $given_productid2 = mysqli_real_escape_string($link, $uc_keys[$i]);
                    mysqli_stmt_bind_param($stmt1, "ss", $given_stock, $given_productid2);
                    mysqli_stmt_execute($stmt1);
                    mysqli_stmt_close($stmt1);
                    mysqli_close($link);
                }
                $_SESSION["user_items"] = 0;
                $_SESSION["user_cart"] = array();
                $_SESSION["user_just_ordered"] = true;
            }
        else
            {
                ?>
        <div class="login_container">
                <br>
                Your order is not valid. Please verify your order and try again.
                <br>
                <br>
        </div>
                <?php
            }
    }
?>
