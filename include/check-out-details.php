<?php
if(checkUserLoggedIn()==false){
    echo 'Error';
}else {
    $methodOfPayment=getMethodOfPayment();
    $methodOfTransport=getMethodOfTransport();
    echo '<form name="check-out-details" method="GET" action="check-out.php">';
    echo '<div class="row spacer-25 min-height-500">';
    echo '<div class="col-md-12">';
    echo '<div class="row">';
    echo '<div class="col-md-6 col-md-offset-3 text-center center-notification-text cart-details-title">';
    echo 'Još samo par koraka....';
    echo '</div>';
    echo '</div>';
    echo '<div class="row spacer-25">';
    echo '<div class="col-md-6 col-md-offset-3 text-center">Platićete...</div>';
    echo '<div class="col-md-6 col-md-offset-3 table-bordered text-center">';
    foreach($methodOfPayment as $mop){
        echo '<label class="radio-inline"><input type="radio" name="method-of-payment" value="'.$mop['id_method'].'">'.$mop['method_of_payment_name'].'</label>';
    }
    echo '</div>';
    echo '</div>';
    echo '<div class="row spacer-25">';
    echo '<div class="col-md-6 col-md-offset-3 text-center">Kakvu isporuku želite?</div>';
    echo '<div class="col-md-6 col-md-offset-3 table-bordered text-center">';
    foreach($methodOfTransport as $mot){
        echo '<label class="radio-inline"><input type="radio" name="method-of-transport" value="'.$mot['id_transport'].'">'.$mot['method_of_transport_name'].'</label>';
    }
    echo '</div>';
    echo '</div>';
    if(checkIfCompanyExists($_SESSION['user_id'])==true) {
        echo '<div class="row spacer-25">';
        echo '<div class="col-md-6 col-md-offset-3 text-center">Kupujete kao...</div>';
        echo '<div class="col-md-6 col-md-offset-3 table-bordered text-center">';
        echo '<label class="radio-inline"><input type="radio" name="type-of-consumer" value="1" checked>Fizičko lice - privatno za kućne potrebe</label><label class="radio-inline"><input type="radio" name="type-of-consumer" value="2">Pravno lice - za potrebe firme</label>';
        echo '</div>';
        echo '</div>';
    }
    echo '<div class="row spacer-25">';
    echo '<div class="col-md-6 col-md-offset-3 text-center"><input type="submit" value="Završi kupovinu" class="btn btn-primary btn-danger" /></div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</form>';
}

?>