<div class="row spacer-25" style="margin-bottom:50px;">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-12">
                        <form role="form" id="user-login" action="credentials-check.php" method="post" name="user-login">
                        <div class="row" style="background-color:#eeeeee;">
                        <h3 class="user-log-reg-title clear-padding-margin"><span class="glyphicon glyphicon-user" style="color:#E78200;"></span> Prijava</h3>
                        </div>
                        <div class="row" style="background-color:#f3f3f3;padding-bottom:15px;">
                            <div class="col-md-5 spacer-25">
                                <span class="">Korisničko ime</span>
                            </div>
                            <div class="col-md-6 col-md-offset-1 spacer-25">
                                <input type="text" id="inputLoginUsername" name="inputLoginUsername" required />
                            </div>
                            <div class="col-md-5 spacer-25">
                                <span class="">Lozinka</span>
                            </div>
                            <div class="col-md-6 col-md-offset-1 spacer-25">
                                <input type="password" id="inputLoginPassword" name="inputLoginPassword" required />
                            </div>
                            <div class="col-md-12 spacer-25">
                                <button type="submit" class="btn btn-block btn-lg btn-warning clear-padding" name="userLoginSubmit">
                                    <a href="#" class="btn-warning btn-block btn-lg btn"><span class="glyphicon glyphicon-log-in"></span> Prijavi se</a>
                                </button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-10 col-md-offset-2">
                <div class="row">
                    <div class="col-md-12">
                        <form id="user-registration" action="credentials-check.php" method="post" name="user-registration">
                            <div class="row" style="background-color:#eeeeee;">
                                <h3 class="user-log-reg-title clear-padding-margin"><span class="glyphicon glyphicon-user" style="color:#E78200;"></span> Registracija</h3>
                            </div>
                            <div class="row" style="background-color:#f3f3f3;padding-bottom:15px;">
                                <div class="col-md-5 spacer-25">
                                    <span class="">Korisničko ime</span>
                                </div>
                                <div class="col-md-6 col-md-offset-1 spacer-25">
                                    <input type="text" id="inputRegistrationUsername" name="inputRegistrationUsername" />
                                </div>
                                <div class="col-md-5 spacer-25">
                                    <span class="">Lozinka</span>
                                </div>
                                <div class="col-md-6 col-md-offset-1 spacer-25">
                                    <input type="password" id="inputRegistrationPassword" name="inputRegistrationPassword" />
                                </div>
                                <div class="col-md-5 spacer-25">
                                    <span class="">Ponovite lozinku</span>
                                </div>
                                <div class="col-md-6 col-md-offset-1 spacer-25">
                                    <input type="password" id="inputRegistrationRepeatPassword" name="inputRegistrationRepeatPassword" />
                                </div>
                                <div class="col-md-5 spacer-25">
                                    <span class="">Ime</span>
                                </div>
                                <div class="col-md-6 col-md-offset-1 spacer-25">
                                    <input type="text" id="inputRegistrationFirstName" name="inputRegistrationFirstName" />
                                </div>
                                <div class="col-md-5 spacer-25">
                                    <span class="">Prezime</span>
                                </div>
                                <div class="col-md-6 col-md-offset-1 spacer-25">
                                    <input type="text" id="inputRegistrationLastName" name="inputRegistrationLastName" />
                                </div>
                                <div class="col-md-5 spacer-25">
                                    <span class="">E-mail</span>
                                </div>
                                <div class="col-md-6 col-md-offset-1 spacer-25">
                                    <input type="email" id="inputRegistrationEmail" name="inputRegistrationEmail" />
                                </div>
                                <div class="col-md-5 spacer-25">
                                    <span class="">Adresa</span>
                                </div>
                                <div class="col-md-6 col-md-offset-1 spacer-25">
                                    <input type="text" id="inputRegistrationAddress" name="inputRegistrationAddress" />
                                </div>
                                <div class="col-md-5 spacer-25">
                                    <span class="">Grad</span>
                                </div>
                                <div class="col-md-6 col-md-offset-1 spacer-25">
                                    <input type="text" id="inputRegistrationCity" name="inputRegistrationCity" />
                                </div>
                                <div class="col-md-5 spacer-25">
                                    <span class="">Poštanski broj</span>
                                </div>
                                <div class="col-md-6 col-md-offset-1 spacer-25">
                                    <input type="text" id="inputRegistrationPostalCode" name="inputRegistrationPostalCode" />
                                </div>
                                <div class="col-md-5 spacer-25">
                                    <span class="">Kontakt telefon</span>
                                </div>
                                <div class="col-md-6 col-md-offset-1 spacer-25">
                                    <input type="text" id="inputRegistrationTelephone" name="inputRegistrationTelephone" placeholder="" />
                                </div>
                                <div class="col-md-12 spacer-25">
                                    <button type="submit" class="btn btn-block btn-lg btn-warning clear-padding" name="userRegisterSubmit">
                                        <a href="#" class="btn-warning btn btn-block btn-lg"><span class="glyphicon glyphicon-ok"></span> Registruj se</a>
                                    </button>
                                </div>
                                <div class="col-md-12 spacer-top">
                                    <button type="reset" class="btn btn-block btn-warning clear-padding">
                                        <a href="#" class="btn btn-block btn-warning"><span class="glyphicon glyphicon-remove"></span> Poništi</a>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    if(isset($_SESSION['error'])){
        ?>
    <div class="row clear-padding-margin">
        <div class="col-md-12 text-center table-bordered spacer-25">
            <?php
                $errormsg=$_SESSION['error'];
                echo '<span class="errormsg">'.$errormsg.'</span>';
            }
            ?>
        </div>
    </div>
</div>