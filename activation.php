<?php
include('include/user-functions.php');
include('include/db-connect.php');

checkActivationMail();

$email=checkActivationMail();

accountActivation($email);

?>