<?php
require('include/cart-functions.php');
require('include/db-connect.php');

$catalogueNumber = $_GET['catalogue-number'];

removeFromCart($catalogueNumber);


?>