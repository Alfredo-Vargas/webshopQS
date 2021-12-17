<?php
    session_start();

    if (isset($_REQUEST["n_items"]))
    {
        $_SESSION["user_items"] = $_REQUEST["n_items"];
        $key = $_REQUEST["id_article"];
        if (isset($_SESSION["user_cart"][$key]))
        {
            $_SESSION["user_cart"][$key]++;
        }
        else
        {
            $_SESSION["user_cart"][$key] = 1;
        }
    }
    elseif ($_SESSION["new_total"])
    {
        $_SESSION["user_total"] = $_REQUEST["new_total"];
    }
?>