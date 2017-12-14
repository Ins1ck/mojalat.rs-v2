<?php
// Inialize session
require('include/db-connect.php');
require('include/product-functions.php');
require('class.phpmailer.php');
require('include/constants.php');
require('include/user-functions.php');

// Delete certain session
unset($_SESSION['id_user']);
unset($_SESSION['username']);
// Delete all session variables
// session_destroy();

// Jump to login page
header('Location: početna');
exit();

?>