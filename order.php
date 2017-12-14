<?php
require('include/db-connect.php');
require('include/product-functions.php');
require('class.phpmailer.php');
require('include/constants.php');
require('include/user-functions.php');
require('include/cart-functions.php');

$message='Idiot';
$id_cart_order='1';
$sum=20000;
$firstname = 'Norbert';
$lastname = 'Mahalik';
$address = 'Majšanski put 128';
$postal_code = '24000';
$city = 'Subotica';
$telephone = '024577566';
$email = 'norbert@zimcommerce.com';
$delivery_type = 'Adresa kupca';
$payment_type = 'Pouzećem';
$year = date("Y");
$date = date("d.M.Y.");
$time = date("H:i:s");
$pdv = 12340;
$mail = new PHPMailer();
$mail->isHTML(true);
$mail->CharSet = "UTF-8";
//$mail->IsSMTP();  // telling the class to use SMTP
//$mail->Host = "smtp.example.com"; // SMTP server
$mail->From = "admin@mojalat.rs";
$mail->AddBCC("$email");
$mail->AddBCC("narudzbenice@mojalat.rs");
$mail->addEmbeddedImage("style/logo2.png", "logo2.png", "http://localhost/mojalatrsrevamp/style/logo2.png");
$mail->Subject = "Narudžba sa sajta Mojalat.rs";

$mail->Body = '<table width="600px">';
    $mail->Body .= '<tr>';
        $mail->Body .= '<td>';
            $mail->Body .= '<table width="100%" style="font-size:12px;font-family:Calibri, sans-serif;">';
                $mail->Body .= '<tr><td colspan="2"><img alt="" src="cid:logo2.png"></td></tr>';
                $mail->Body .= '<tr class="dontprint"><td colspan="2"><img alt="" src="style/logo2.png" /></td></tr>';
                $mail->Body .= '<tr><td>Naziv firme: Zim Commerce DOO</td><td>Trgovina na veliko i malo</td></tr><tr><td>PIB: 100843285</td><td>MAT. BR: 08323291</td></tr><tr><td>Tel: 024/577-566, 024/577-664</td><td>Mob: 060/0577-566</td></tr><tr><td>Tekući račun:</td><td>265-2410310003511-38</td></tr>';
                $mail->Body .= '<tr><td colspan="2"><hr style="border: 0; border-bottom: 1px dashed #a2a2a2;" /></td></tr>';
                $mail->Body .= '<tr><td>Porudžbina broj: </td><td>' . $id_cart_order . '/' . $year . '</td></tr>';
                $mail->Body .= '<tr><td>Datum i vreme:</td><td>' . $date . ' ' . $time . '</td></tr>';
                $mail->Body .= '<tr><td>Poručilac:</td><td>' . $firstname . ' ' . $lastname . '</td></tr>';
                $mail->Body .= '<tr><td>Adresa:</td><td>' . $address . ', ' . $postal_code . ' ' . $city . '</td></tr>';
                $mail->Body .= '<tr><td>Telefon:</td><td>' . $telephone . '</td></tr>';
                $mail->Body .= '<tr><td>Način plaćanja:</td><td>' . $payment_type . '</td></tr>';
                $mail->Body .= '<tr><td>Mesto preuzimanja:</td><td>' . $delivery_type . '</td></tr>';
                $mail->Body .= '<tr><td colspan="2"><hr style="border: 0; border-bottom:1px dashed #a2a2a2;" /></td></tr>';
                $mail->Body .= '</table>';
            $mail->Body .= '</td>';
        $mail->Body .= '</tr>';
    $mail->Body .= '<tr>';
        $mail->Body .= '<td>';
            $mail->Body .= '<table style="font-family:Calibri, sans-serif;font-size:12px;color:#333333;margin-top:10px;width:100%;text-align:center;border:2px solid #d2d2d2;border-collapse: collapse;border-spacing: 0;height:100%;padding:0;">';
                $mail->Body .= $message;
                $mail->Body .= '</table>';
            $mail->Body .= '</td>';
        $mail->Body .= '</tr>';
    $mail->Body .= '<tr>';
        $mail->Body .= '<td>';
            $mail->Body .= '<table style="width:100%;font-family:Calibri,sans-serif;font-size:12px;">';
                $mail->Body .= '<tr></tr>';
                $mail->Body .= '<tr><td></td><td></td><td></td><td></td><td></td><td style="text-align:right;">Cena bez PDV-a:</td><td style="text-align:right;border:2px solid #d2d2d2;width:25%;">' . number_format($sum / 1.2, 2, ',', '.') . ' din</td></tr>';
                $mail->Body .= '<tr><td></td><td></td><td></td><td></td><td></td><td style="text-align:right;">PDV:</td><td style="text-align:right;border:2px solid #d2d2d2;width:25%;">' . number_format($pdv, 2, ',', '.') . ' din</td></tr>';
                $mail->Body .= '<tr><td></td><td></td><td></td><td></td><td></td><td style="text-align:right;">Cena sa PDV:</td><td style="text-align:right;border:2px solid #d2d2d2;width:25%;">' . number_format($sum, 2, ',', '.') . ' din</td></tr>';
                $mail->Body .= '</table>';
            $mail->Body .= '</td>';
        $mail->Body .= '</tr>';
    $mail->Body .= '<tr>';
        $mail->Body .= '<td>';
            $mail->Body .= '<table style="font-family:Calibri,sans-serif;margin-top:20px;font-size:12px;">';
                $mail->Body .= '<tr><td>Uspešno ste izvršili poružbinu putem onlajn prodavnice Mojalat.rs.</td></tr>';
                $mail->Body .= '<tr><td>Uskoro će vas neko kontaktirati zbog potvrđivanja Vaše porudžbine i dogovora oko načina plaćanja i slanja.</td></tr>';
                $mail->Body .= '<tr><td>Hvala vam na ukazanom poverenju, tim Mojalat.rs.</td></tr>';
                $mail->Body .= '</table>';
            $mail->Body .= '</td>';
        $mail->Body .= '</tr>';
    $mail->Body .= '</table>';


    print_r($mail);
    ?>