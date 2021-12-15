<?php
    require "connection.php";

    if (isset($_POST["submit_filter"]))
    {
        $option = $_POST["filter"];

        switch($option)
        {
            case "All":
                $query = "SELECT * FROM Products";
                break;
            
            case "cheapest":
                $query = "SELECT * FROM Products ORDER BY Price";
                break;
            
            default:
                $query = "SELECT * FROM Products WHERE Category=\"$option\"";
        }
    }

    $result = mysqli_query($link, $query) or die ("An error occurred during the execution of the query: \"$query\"");

?>