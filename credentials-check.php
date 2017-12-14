<?php

include('include/db-connect.php');
include('include/user-functions.php');

if(isset($_POST['userLoginSubmit'])){
    if(checkBlankLoginInput()==true){
        $username=$_POST['inputLoginUsername'];
        $password=$_POST['inputLoginPassword'];

        $userData=verifyUsername($username);
        if($userData==false){
            echo 'No user.';
        }else{
            foreach($userData as $uData){
                $userID=$uData['id_user'];
                $userPassword=$uData['password'];
            }
            comparePasswords($userPassword, $password, $userID, $username);
        }
    }
}elseif(isset($_POST['userRegisterSubmit'])){
    if(checkBlankRegisterInput()==true){
        $username=$_POST['inputRegistrationUsername'];
        $password=$_POST['inputRegistrationPassword'];
        $repeatPassword=$_POST['inputRegistrationRepeatPassword'];
        $email=$_POST['inputRegistrationEmail'];
        $address=$_POST['inputRegistrationAddress'];
        $city=$_POST['inputRegistrationCity'];
        $postalCode=$_POST['inputRegistrationPostalCode'];
        $telephone=$_POST['inputRegistrationTelephone'];
        $firstName=$_POST['inputRegistrationFirstName'];
        $lastName=$_POST['inputRegistrationLastName'];
        if(checkUserEmail($email)==true){
            echo 'Email Legit!';
            if(checkIfEmailExists($email)==false){
                echo 'Email OK!';
                if(checkIfUsernameExists($username)==false){
                    echo 'Username OK!';
                    if(checkIfPasswordMatch($password,$repeatPassword)==true){
                        echo 'Password OK!';
                        $hashedPassword=hashPassword($password);
                        registerUser($username, $hashedPassword, $email, $address, $city, $postalCode, $telephone, $firstName, $lastName);
                    }else{
                        $_SESSION['error'].= 'POLJA LOZINKA I PONOVITE LOZINKU SE NE POKLAPAJU.';
                        header('Location:user-login.php');
                        exit();
                    }
                }else{
                    $_SESSION['error'].='KORISNIČKO IME VEĆ POSTOJI.';
                    header('Location:user-login.php');
                    exit();
                    // username exists error
                }
            }else{
                $_SESSION['error'].= 'EMAIL JE VEĆ U UPOTREBI.';
                header('Location:user-login.php');
                exit();
                //email exists error
            }
        }else{
            $_SESSION['error'].='EMAIL ADRESA NIJE VALIDNA';
            header('Location:user-login.php');
            exit();
            // email not valid error
        }
    }else{
        echo 'ERROR';
    }
}

?>