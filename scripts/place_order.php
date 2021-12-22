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
                echo("start inserting order details\n");
                $get_orderid_query = "SELECT orderID FROM Orders WHERE date = \"" . $phptime . "\" and userID = ". $_SESSION["userID"];
                echo($get_orderid_query);
                echo("\n");
                echo("HHHH");
                echo("\n");
                $orderid = mysqli_query($link, $get_orderid_query) or die ("An error occurred during the execution of the query: \"$get_orderid_query\"");
                echo($orderid);
                echo("\n");
                $ndf = count($_SESSION["user_cart"]);  // number of different products
                echo($ndf);
                echo("\n");
                $records = "";

                for ($i = 0; $i < ndf; ++$i)
                    {
                        $records += "(" . $orderid . ", " . $_SESSION["user_cart"][$i][0] . ", " . $_SESSION["user_cart"][$i][1] . ")";
                        if ($i != ndf - 1)
                            {
                                $records += ",\n";
                            }
                        else
                            {
                                $records += ";";
                            }
                    }

                $place_orderdetails_query = "INSERT INTO OrderDetails
                                        (orderID, productID, quantity)
                                        VALUES ?";
                echo("\n");
                echo($records);
                echo("\n");
                $stmt = mysqli_prepare($link, $place_orderdetails_query);
                $given_records = mysqli_real_escape_string($link, $records);
                mysqli_stmt_bind_param($stmt, "s", $given_records);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                mysqli_close($link);
                $_SESSION["user_items"] = 0;
                echo("Your order completed succesfully");
            }
        else
            {
                echo("Your order is not valid. Please verify your order and try again");
            }
    }
?>
