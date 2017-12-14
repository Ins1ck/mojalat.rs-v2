<?php
$countCartItems=countCartItems();
?>
<div class="row">
    <div class="col-md-12 clear-padding-margin">
        <div class="row">
            <div class="col-md-4 text-center">
                <a href="index.php"><img class="img-responsive" src="style/images/logo.png" /></a>
            </div>
            <div class="col-md-5 text-center vertical-center">
                <input type="text" class="searchbar" placeholder="Pretraga" /><input type="submit" value="Pretraga" class="searchbtn" />
            </div>
            <div class="col-md-3 text-center vertical-center">
                <a href="korpa" class="cartbtn">Vaša korpa (<?php echo $countCartItems ?>)</a>
            </div>
        </div>
    </div>
</div>