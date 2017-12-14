<?php
require('include/db-connect.php');
require('include/product-functions.php');
require('include/user-functions.php');
require('include/general-functions.php');
require('include/cart-functions.php');
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <base href="http://localhost/mojalat.rs-v2/>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="dist/css/lightbox.min.css">
    <link rel="stylesheet" type="text/css" href="dist/css/lightbox.css">
    <?php include('include/css-files.php'); ?>
    <script>
        $(function() {

            $('.list-group-item').on('click', function() {
                $('.glyphicon', this)
                    .toggleClass('glyphicon-chevron-right')
                    .toggleClass('glyphicon-chevron-down');
            });

        });
    </script>
    <title>Mojalat.rs</title>
</head>
<body>

<div class="container-fluid">
    <?php include('include/login-panel.php'); ?>
</div>

<div class="container">
    <?php include('include/site-header.php'); ?>
</div>

<div class="container">
    <?php include('include/horizontal-navigation.php'); ?>
</div>

<div class="container spacer-top">
    <?php include('include/item-details.php'); ?>
</div>
<div class="container-wrapper spacer-25">
    <div class="container">
        <?php include('include/footer.php') ?>
    </div>
</div>

<script src="js/jquery-1.11.3.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="dist/js/lightbox-plus-jquery.min.js"></script>
</body>