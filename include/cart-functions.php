<?php

function addToCart($itemCatalogueNumber, $itemAmount){
    if(isset($_SESSION['shopping-cart'][$itemCatalogueNumber])){
        $_SESSION['shopping-cart'][$itemCatalogueNumber]=$itemAmount+$_SESSION['shopping-cart'][$itemCatalogueNumber];
    }else{
        $_SESSION['shopping-cart'][$itemCatalogueNumber]=$itemAmount;
    }
}

function removeFromCart($catalogueNumber){
    $_SESSION['shopping-cart'][$catalogueNumber]--;
    if($_SESSION['shopping-cart'][$catalogueNumber]<=0){
        unset($_SESSION['shopping-cart'][$catalogueNumber]);
    }
    header('Location: korpa');
    exit();
}

function checkIfNumeric($itemAmount){
    if(is_numeric($itemAmount)){
        return true;
    }else{
        return false;
    }
}

function checkIfPositive($itemAmount){
    if($itemAmount>0){
        return true;
    }else{
        return false;
    }
}

function countCartItems(){
    if(isset($_SESSION['shopping-cart'])) {
        $numberOfItems=count($_SESSION['shopping-cart']);
    }else{
        $numberOfItems=0;
    }
    return $numberOfItems;
}

function emptyCartMessage(){
    echo '<div class="row spacer-25">';
    echo '<div class="col-md-12">';
    echo '<div class="row">';
    echo '<div class="col-md-6 col-md-offset-3 table-bordered text-center center-notification-text">';
    echo 'Vaša korpa je prazna.';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}

function getTotalShoppingCart(){

}

function getMethodOfPayment(){
    global $db;
    $getMop=$db->prepare('SELECT id_method, method_of_payment_name, description FROM method_of_payment');
    $getMop->execute();
    $arrayMop=$getMop->fetchALL(PDO::FETCH_ASSOC);
    return $arrayMop;
}

function getMethodOfTransport(){
    global $db;
    $getMot=$db->prepare('SELECT id_transport, method_of_transport_name, description FROM method_of_transport');
    $getMot->execute();
    $arrayMot=$getMot->fetchALL(PDO::FETCH_ASSOC);
    return $arrayMot;
}

function addCartToDatabase($userID, $dateTime, $methodOfTransport, $methodOfPayment, $invoice, $itemPriceSum){
    global $db;
    $insertCartIntoDB=$db->prepare('INSERT INTO cart_orders (id_user, datetime, order_text, total, method_of_payment, method_of_transport ) VALUES (:id_user, :datetime, :order_text, :total, :methodOfPayment, :methodOfTransport)');
    $insertCartIntoDB->execute(array(':id_user'=>$userID, ':datetime'=>$dateTime, ':order_text'=>$invoice, ':total'=>$itemPriceSum, ':methodOfPayment'=>$methodOfPayment, ':methodOfTransport'=>$methodOfTransport));
    if($insertCartIntoDB->rowCount()>0){
        $lastInsertCartID=$db->lastInsertid();
        return $lastInsertCartID;
    }else{
        return false;
    }
}

function createInvoiceSkeleton($orderDate, $methodOfPayment, $methodOfTransport, $name, $username, $email, $address, $postalCode, $city, $telephone, $itemPriceSum, $priceWithoutTax, $priceTax, $message){
    $invoice = '<table width="800px" style="font-family:Open-sans, sans-serif; color:#555555; font-size:14px;">';
    $invoice .= '<tr>';
    $invoice .= '<td style="width:300px;"><img style="max-width:100%;" src="style/images/logo.png" alt="Mojalat.rs" /></td>';
    $invoice .= '<td style="text-align:center; width:300px;">';
    $invoice .= '<ul style="list-style-type:none; background-color:#f3f3f3; border:1px solid #d8d8d8; margin-left:20px;">';
    $invoice .= '<li style="margin:5px 0 3px 0;">Zim Commerce DOO</li>';
    $invoice .= '<li style="margin:3px 0 3px 0;">Majšanski put 128</li>';
    $invoice .= '<li style="margin:3px 0 3px 0;">24000 Subotica</li>';
    $invoice .= '<li style="margin:3px 0 3px 0;">PIB 100843285</li>';
    $invoice .= '<li style="margin:3px 0 5px 0;">MB 08323291</li>';
    $invoice .= '</ul>';
    $invoice .= '</td>';
    $invoice .= '</tr>';
    $invoice .= '</table>';
    $invoice .= '<table width="800px" style="font-family:Open-sans, sans-serif; color:#555555; font-size:14px; margin-top:20px; height:150px;">';
    $invoice .= '<tr>';
    $invoice .= '<td>';
    $invoice .= '<table style="font-family:Open-sans, sans-serif; color:#555555; font-size:14px; text-align:left; width:400px;">';
    $invoice .= '<tr>';
    $invoice .= '<td colspan="2">';
    $invoice .= '<h2 style="font-size:17px; text-decoration:underline; margin-left:10px;">Predračun: INT-Broj/2017</h2>';
    $invoice .= '</td>';
    $invoice .= '</tr>';
    $invoice .= '<tr><td style="text-align:right; border-bottom:1px dashed #d8d8d8;">Datum:</td><td style="border-bottom:1px dashed #d8d8d8;">'.$orderDate.'</td></tr>';
    $invoice .= '<tr><td style="text-align:right; border-bottom:1px dashed #d8d8d8;">Način plaćanja:</td><td style="border-bottom:1px dashed #d8d8d8;">'.$methodOfPayment.'</td></tr>';
    $invoice .= '<tr><td style="text-align:right; border-bottom:1px dashed #d8d8d8;">Mesto preuzimanja:</td><td style="border-bottom:1px dashed #d8d8d8;">Adresa kupca</td></tr>';
    $invoice .= '<tr><td style="text-align:right; border-bottom:1px dashed #d8d8d8;">Tekući račun:</td><td style="border-bottom:1px dashed #d8d8d8;">265-2410310003511-38</td></tr>';
    $invoice .= '</table>';
    $invoice .= '</td>';
    $invoice .= '<td>';
    $invoice .= '<table style="font-family:Open-sans, sans-serif; color:#555555; font-size:14px; text-align:center; width:400px;">';
    $invoice .= '<tr>';
    $invoice .= '<td>';
    $invoice .= '<h2 style="font-size:17px; text-decoration:underline; margin-left:10px;">'.$name.'</h2>';
    $invoice .= '</td>';
    $invoice .= '</tr>';
    $invoice .= '<tr><td style="border-bottom:1px dashed #d8d8d8;">Korisnik: '.$username.'</td></tr>';
    $invoice .= '<tr><td style="border-bottom:1px dashed #d8d8d8;">'.$address .' '.$postalCode.', '.$city.'</td></tr>';
    $invoice .= '<tr><td style="border-bottom:1px dashed #d8d8d8;">'.$telephone.'</td></tr>';
    $invoice .= '<tr><td style="border-bottom:1px dashed #d8d8d8;">'.$email.'</td></tr>';
    $invoice .= '</table>';
    $invoice .= '</td>';
    $invoice .= '</tr>';
    $invoice .= '</table>';
    $invoice .= '<table width="800px" style="font-family:Open-sans, sans-serif; color:#555555; font-size:14px; margin-top:20px; border:1px solid #d8d8d8; border-collapse: collapse;border-spacing: 0;padding:0;">';
    $invoice .= '<thead style="border-bottom:1px solid #d8d8d8;">';
    $invoice .= '<tr>';
    $invoice .= '<th style="text-align:left;">Rb.</th><th style="text-align:left;">Šifra</th><th style="text-align:left;">Naziv</th><th style="text-align:right;">Cena</th><th style="text-align:right;">Količina</th><th style="text-align:right;">Ukupno</th>';
    $invoice .= '</tr>';
    $invoice .= '</thead>';
    $invoice .= '<tbody>';
    $invoice .=  $message;
    $invoice .= '</tbody>';
    $invoice .= '</table>';

    $invoice .= '<table width="800px;" style="font-family:Open-sans, sans-serif; color:#555555; font-size:14px; margin-left:4px;">';
    $invoice .= '<tr>';
    $invoice .= '<td style="width:500px;"></td>';
    $invoice .= '<td style="width:300px;">';
    $invoice .= '<table style="width:100%;font-family:Open-sans, sans-serif; color:#555555; font-size:14px; margin-top:20px; border:1px solid #d8d8d8; border-collapse: collapse;border-spacing: 0;padding:0;">';
    $invoice .= '<tr>';
    $invoice .= '<td style="text-align:left; border-bottom:1px solid #d8d8d8; padding:5px 0 5px 1px;">Osnovica</td>';
    $invoice .= '<td style="text-align:right; border-bottom:1px solid #d8d8d8; padding:5px 1px 5px 0;">' . number_format($priceWithoutTax, '2', ',', '.') . ' RSD</td>';
    $invoice .= '</tr>';
    $invoice .= '<tr>';
    $invoice .= '<td style="text-align:left; border-bottom:1px solid #d8d8d8; padding:5px 0 5px 1px;">PDV</td>';
    $invoice .= '<td style="text-align:right; border-bottom:1px solid #d8d8d8; padding:5px 1px 5px 0;">' . number_format($priceTax, '2', ',', '.') . ' RSD</td>';
    $invoice .= '</tr>';
    $invoice .= '<tr>';
    $invoice .= '<td style="text-align:left; border-bottom:1px solid #d8d8d8; padding:5px 0 5px 1px;">Ukupno</td>';
    $invoice .= '<td style="text-align:right; border-bottom:1px solid #d8d8d8; padding:5px 1px 5px 0;">' . number_format($itemPriceSum, '2', ',', '.') . ' RSD</td>';
    $invoice .= '</tr>';
    $invoice .= '</table>';
    $invoice .= '</td>';
    $invoice .= '</tr>';
    $invoice .= '</table>';

    $invoice .= '<table width="800px;" style="font-family:Open-sans, sans-serif; color:#555555; font-size:11px; margin-top:20px;">';
    $invoice .= '<tr>';
    $invoice .= '<td>Uspešno ste napravili narudžbu na internet prodavnici MojAlat.rs. Uskoro ćete biti kontaktirani od strane našeg osoblja radi potvrđivanja Vaše narudžbe i dogovora oko načina slanja i plaćanja. Hvala Vam na ukazanom poverenju. MojAlat.rs.</td>';
    $invoice .= '</tr>';
    $invoice .= '</table>';

    return $invoice;
}

function createInvoice(){

}

?>