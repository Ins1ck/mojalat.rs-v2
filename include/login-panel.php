<div class="row help-panel">
    <div class="col-md-12 text-right">
        <?php
        if(checkUserLoggedIn()==true){
            echo '<a href="#">'.ucfirst($_SESSION['username']).'</a>';
            echo '<a href="odjava">Odjavite se</a>';
            echo '<a href="#">Vaša korpa</a>';
        }else{
        ?>
        <a href="prijava">Registracija</a>
        <a href="prijava">Prijava</a>
        <a href="#">Najčešća pitanja</a>
        <a href="#">Uputstvo za korisnike</a>
        <?php } ?>
    </div>
</div>