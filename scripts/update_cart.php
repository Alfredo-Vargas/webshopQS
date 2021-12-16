<?php
    session_start();
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
?>