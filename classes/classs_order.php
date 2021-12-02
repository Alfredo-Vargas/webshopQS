<?php
    include("./classes/class_user.php");
    include("./classes/class_product.php");
    class Order
    {
        public $userID;
        public $product_array = array();
        public $quantity_array = array();
    }
?>