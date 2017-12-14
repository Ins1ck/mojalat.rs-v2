<?php
require('include/db-connect.php');
require('include/product-functions.php');
require('include/user-functions.php');
require('include/general-functions.php');
require('include/cart-functions.php');

if(checkUserLoggedIn()==false){
    echo 'Error';
}else{
    $userDetails=getUserDetails($_SESSION['user_id']);

    $username = $userDetails['username'];
    $email=$userDetails['email'];
    $userID=$userDetails['id_user'];

    if($_GET['method-of-payment']==1){
        $methodOfPayment='Pouzećem';
    }else{
        $methodOfPayment='Avansno';
    }

    if($_GET['method-of-transport']==1){
        $methodOfTransport='Kurirskom službom';
    }else{
        $methodOfTransport='Preuzimanje u radnji';
    }

    $typeOfConsumer=$_GET['type-of-consumer'];


    if($userDetails['set_company']==0 OR $typeOfConsumer==1) {
        $name = $userDetails['firstname'].' '.$userDetails['lastname'];
        $address = $userDetails['address'];
        $city = $userDetails['city'];
        $postalCode = $userDetails['postal_code'];
        $telephone = $userDetails['telephone'];
    }else{
        $name=$userDetails['company_name'].' - PIB: '.$userDetails['pib'];
        $address=$userDetails['company_address'];
        $city=$userDetails['company_city'];
        $postalCode=$userDetails['company_postal_code'];
        $telephone=$userDetails['company_telephone_number'];
    }

    if (isset($_SESSION['shopping-cart']) AND !empty($_SESSION['shopping-cart'])) {
        $message = "";
        $ordinalNumber = 1;
        $itemPriceSum = 0;
        foreach ($_SESSION['shopping-cart'] as $itemCatalogueNumber => $itemAmount) {

            $getItems = getProducts();

            $getSingleItem = getSingleItem($itemCatalogueNumber, $getItems);
            $orderDate = date("Y-m-d H:i:s");
            $itemManufacturer = $getSingleItem['manufacturer_name'];
            $itemName = $getSingleItem['name'];
            $itemCatalogueNumber = $getSingleItem['catalogue_number'];
            $itemDiscounted = $getSingleItem['discount'];
            $itemDiscountPercentage = $getSingleItem['discount_percentage'];
            if ($itemDiscounted == 1) {
                $itemPrice = $getSingleItem['price'];
            } else {
                $itemDiscountPercentageConv = (100 - $itemDiscountPercentage) / 100;
                $itemPrice = $itemDiscountPercentageConv * $getSingleItem['price'];
            }
            $itemTotal = $itemPrice * $itemAmount;
            $itemPriceSum += $itemPrice * $itemAmount;

            if ($ordinalNumber == 1) {
                $message .= '<tr><td>' . $ordinalNumber . '.</td><td>' . $itemCatalogueNumber . '</td><td>' . $itemManufacturer . ' ' . $itemName . '</td><td style="text-align:right;">' . number_format($itemPrice, '2', ',', '.') . '</td><td style="text-align:right;">' . $itemAmount . '</td><td style="text-align:right;">' . number_format($itemTotal, 2, ',', '.') . '</td></tr>';
            } else {
                $message .= '<tr><td style="border-top:1px solid #d8d8d8;">' . $ordinalNumber . '.</td><td style="border-top:1px solid #d8d8d8;">' . $itemCatalogueNumber . '</td><td style="border-top:1px solid #d8d8d8;">' . $itemManufacturer . ' ' . $itemName . '</td><td style="text-align:right; border-top:1px solid #d8d8d8;">' . number_format($itemPrice, '2', ',', '.') . '</td><td style="text-align:right; border-top:1px solid #d8d8d8;">' . $itemAmount . '</td><td style="text-align:right; border-top:1px solid #d8d8d8;">' . number_format($itemTotal, 2, ',', '.') . '</td></tr>';
            }
            $ordinalNumber++;
        }

        $priceWithoutTax = $itemPriceSum / 1.2;
        $priceTax = $itemPriceSum - $priceWithoutTax;

        $invoice=createInvoiceSkeleton($orderDate, $methodOfPayment, $methodOfTransport, $name, $username, $email, $address, $postalCode, $city, $telephone, $itemPriceSum, $priceWithoutTax, $priceTax, $message);
        
        echo $invoice;

        /** 
        
        if(addCartToDatabase($userID, $orderDate, $methodOfTransport, $methodOfPayment, $invoice, $itemPriceSum)==false){
            echo 'Error';
        }else{
            echo 'Good.';
        }
        
        **/



    } else {
        echo 'error';
    }
}

?>