<?php
require('include/db-connect.php');
require('include/product-functions.php');
require('include/user-functions.php');
require('include/general-functions.php');
require('include/cart-functions.php');


if(isset($_POST['addToCartItemType']) AND isset($_POST['addToCartCatalogueNumber']) AND isset($_POST['addToCartAmount'])) {
    $itemType = $_POST['addToCartItemType'];
    $itemCatalogueNumber = $_POST['addToCartCatalogueNumber'];
    $itemAmount = $_POST['addToCartAmount'];

    $getItems = getProducts();

    $getSingleItem = getSingleItem($itemCatalogueNumber, $getItems);

    if (!empty($getSingleItem)) {
        if (checkIfAvailable($getSingleItem['count'], $itemAmount, $itemCatalogueNumber) == true) {
            if(checkIfNumeric($itemAmount)==true) {
                if(checkIfPositive($itemAmount)==true) {
                    addToCart($itemCatalogueNumber, $itemAmount);
                    header('Location: korpa');
                    exit();
                }else{
                    $_SESSION['cart-error']='Pogrešan unos količine.';
                    header("Location: " . $_SERVER["HTTP_REFERER"]);
                    exit();
                }
            }else{
                $_SESSION['cart-error']='Količina mora biti numerička vrednost.';
                header("Location: " . $_SERVER["HTTP_REFERER"]);
                exit();
            }
        } else {
            $_SESSION['cart-error']='Nije dostupna tražena količina. Pozovite za informacije.';
            header("Location: " . $_SERVER["HTTP_REFERER"]);
            exit();
        }
    } else {
        echo 'Došlo je do greške.';
        exit();
    }
}else{
    header('Location: '.BASE_LINK.'/oops');
    exit();
}

?>