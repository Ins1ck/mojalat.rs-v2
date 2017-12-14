<?php

function checkBlankRegisterInput(){
    if($_POST['inputRegistrationUsername']!='' AND $_POST['inputRegistrationPassword']!='' AND $_POST['inputRegistrationRepeatPassword']!='' AND $_POST['inputRegistrationEmail']!='' AND $_POST['inputRegistrationAddress']!='' AND $_POST['inputRegistrationCity']!='' AND $_POST['inputRegistrationPostalCode']!='' AND $_POST['inputRegistrationTelephone']!='' AND $_POST['inputRegistrationFirstName']!='' AND $_POST['inputRegistrationLastName']){
        return true;
    }else{
        return false;
    }
}

function checkUserEmail($email){
    if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email)){
        return true;
    }else{
        return false;
    }
}

function checkIfEmailExists($email){
    global $db;
    $verifyEmail = $db->prepare("SELECT email FROM users WHERE email=:email LIMIT 1");
    $verifyEmail->execute(array(':email' => $email));
    if ($verifyEmail->rowCount() > 0) {
        return true;
    }else{
        return false;
    }
}

function checkIfUsernameExists($username){
    global $db;
    $verifyUsername = $db->prepare("SELECT username FROM users WHERE username=:username LIMIT 1");
    $verifyUsername->execute(array(':username' => $username));
    if ($verifyUsername->rowCount() > 0) {
        return true;
    }else{
        return false;
    }
}

function checkIfPasswordMatch($password1,$password2){
    if($password1==$password2){
        return true;
    }else{
        return false;
    }
}

function hashPassword($password){
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT, array('cost' => 12));
    return $hashedPassword;
}

function registerUser($username, $hashedPassword, $email, $address, $city, $postalCode, $telephone, $firstName, $lastName){
    global $db;
    $activation = md5(uniqid(rand(), true));
    $insertUser=$db->prepare('INSERT INTO users (username, password, firstname, lastname, email, address, city, postal_code, telephone, active) VALUE (:username, :password, :firstname, :lastname, :email, :address, :city, :postal_code, :telephone, :active)');
    $insertUser->execute(array(':username'=>$username, ':password'=>$hashedPassword, ':firstname'=>$firstName, ':lastname'=>$lastName, ':email'=>$email, ':address'=>$address, ':city'=>$city, ':postal_code'=>$postalCode, ':telephone'=>$telephone, ':active'=>$activation));
    if ($insertUser->rowCount() > 0) {
        $mail = new PHPMailer();
        $mail->isHTML(true);
        $mail->CharSet = "UTF-8";
        //$mail->IsSMTP();  // telling the class to use SMTP
        //$mail->Host = "smtp.example.com"; // SMTP server
        $mail->From = "noreply@mojalat.rs";
        $mail->AddAddress("$email");
        $mail->addEmbeddedImage("mojalat.rs/style/logo2.png", "logo2.png", "http://mojalat.rs/style/logo2.png");
        $mail->Subject = "Aktivacija naloga na sajtu MojAlat.rs";
        $mail->Body = '<table width="800px">';
        $mail->Body .= '<tr>';
        $mail->Body .= '<td>';
        $mail->Body .= '<table>';
        $mail->Body .= '<tr><td colspan="2"><img alt="" src="cid:logo2.png"></td></tr>';
        $mail->Body .= '<tr><td>Pozdrav ' . $username . '. Ova poruka je poslata sa <a target="_blank" href="http://www.mojalat.rs">http://www.mojalat.rs</a></td></tr>';
        $mail->Body .= '<tr><td>Ovu poruku ste dobili jer je ova email adresa korištena kod registracije na našoj internet prodavnici Mojalat.rs.<br /> Ukoliko se niste registrovali na našem sajtu, molimo vas zanemarite ovu poruku.</td></tr>';
        $mail->Body .= '<tr><td><hr style="width:45%;border: 0; border-bottom: 1px dashed #ccc; background: #999;margin:25px 0 0 0;" /></td></tr>';
        $mail->Body .= '<tr><td>Uputstva za aktivaciju</td></tr>';
        $mail->Body .= '<tr><td><hr style="width:45%;border: 0; border-bottom: 1px dashed #ccc; background: #999;margin:0 0 10px 0;" /></td></tr>';
        $mail->Body .= '<tr><td>Klikom na dugme ispod ćete izvršiti aktivaciju svog naloga na sajtu MojAlat.rs</td></tr>';
        $mail->Body .= '<tr><td><span style="color:red;">NAPOMENA:</span> U nekim email klijentima morate ručno kopirati i staviti link u adresnu liniju vašeg pretraživača.</td></tr>';
        $mail->Body .= '<tr><td height="10px"></td></tr>';
        $mail->Body .= '<tr><td><a style="margin:5px 0 5px 0;border-radius: 9px;font-family: Arial;color: #ffffff;font-size: 14px;background: #eb771e;padding: 6px 15px 6px 15px;text-decoration: none;" href="localhost/mojalat.rs-v2/activation.php?email=' . urlencode($email) . '&key=' . $activation . '">Aktivacija naloga</a></td></tr>';
        $mail->Body .= '<tr><td>activation.php?email=' . urlencode($email) . '&key=' . $activation . '</tr></td>';
        $mail->Body .= '<tr><td height="10px"></td></tr>';
        $mail->Body .= '<tr><td>Ukoliko imate nekih problema oko aktivacije naloga, molimo vas da nas kontaktirate na admin@mojalat.rs</td></tr>';
        $mail->Body .= '<tr><td>Hvala vam na ukazanom poverenju, Tim MojAlat.rs</td></tr>';
        $mail->Body .= '</table>';
        $mail->Body .= '</td>';
        $mail->Body .= '</tr>';
        $mail->Body .= '</table>';
        if (!$mail->Send()) {
            echo 'Message was not sent.';
            echo 'Mailer error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent.';
            header('Location:'.BASE_PATH.'/index.php');
            exit();
        }

    }else{

    }
}

function checkActivationMail(){
    if (isset($_GET['email']) && preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/', $_GET['email'])) {
        $email = $_GET['email'];
        return $email;
    }else{
        header("Location:registration_unsuccess.php?error=1");
        exit();
    }
}

function accountActivation($email){
    global $db;
    if (isset($_GET['key']) && (strlen($_GET['key']) == 32))
    {
        $key = $_GET['key'];
    }
    if (isset($email) && isset($key)) {
        $query_activate_account = $db->prepare("UPDATE users SET active=NULL WHERE(email =:email AND active=:key)LIMIT 1");
        $query_activate_account->execute(array(':email'=>$email,':key'=>$key));
        if ($query_activate_account->rowCount() == 1)
        {
            header("Location:registration_success.php?action=2");
            exit();
        } else {
            header("Location:registration_unsuccess.php?error=1");
            exit();
        }
    }else {
        echo '<div>Error Occured. Please try again.</div>';
    }
}

function checkBlankLoginInput(){
    if($_POST['inputLoginUsername']!='' AND $_POST['inputLoginPassword']!=''){
        return true;
    }else{
        return false;
    }
}

function verifyUsername($username){
    global $db;
    $queryVerifyUsername = $db->prepare("SELECT id_user, username, password, is_admin FROM users WHERE username=:username LIMIT 1");
    $queryVerifyUsername->execute(array(':username' => $username));
    if ($queryVerifyUsername->rowCount() == 0) {
        return false;
    }else{
        $arrayUserData=array();
        $resultQueryVerifyUsername=$queryVerifyUsername->fetchALL(PDO::FETCH_ASSOC);
        foreach($resultQueryVerifyUsername as $resultUser){
            $arrayUserData[]=$resultUser;
        }
        return $arrayUserData;
    }
}

function comparePasswords($password, $inputLoginPassword, $userID, $username)
{
    if (password_verify($inputLoginPassword, $password) == true) {
        $_SESSION['info']='SESSION WORKING.';
        $_SESSION['user_id']= $userID;
        $_SESSION['username']= $username;
        header('Location: početna');

        exit();
    }else{
        echo 'Wrong password';
    }
}


function checkUserLoggedIn(){
    if(isset($_SESSION['user_id']) AND isset($_SESSION['username']) AND !empty($_SESSION['user_id']) AND !empty($_SESSION['username'])){
        return true;
    }else{
        return false;
    }
}

function getUserDetails($userID){
    global $db;
    $getDetails=$db->prepare('SELECT id_user, username, firstname, lastname, email, telephone, address, postal_code, city, set_company, company_name, pib, company_telephone_number, company_address, company_postal_code, company_city FROM users WHERE id_user=:userID');
    $getDetails->execute(array(':userID'=>$userID));
    $userDetails=$getDetails->fetch(PDO::FETCH_ASSOC);
    if(empty($userDetails)){
        return false;
    }else{
        return $userDetails;
    }
}


function checkIfCompanyExists($userID){
    global $db;
    $checkCompany=$db->prepare('SELECT set_company FROM users WHERE id_user=:userID');
    $checkCompany->execute(array(':userID'=>$userID));
    $resultCheckCompany=$checkCompany->fetch();

    if($resultCheckCompany['set_company']==1){
        return true;
    }else{
        return false;
    }
}


?>