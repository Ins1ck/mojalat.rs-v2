<div class="row spacer-25">
    <div class="col-md-12 spacer-25 clear-padding-margin">
        <h3 class="h3-resized"><u class="h3-underline">Izdvojeni artikli iz naše ponude</h3>
    </div>
</div>
<div class="row featured-items-row">
    <div class="col-md-12 clear-padding-margin">
        <?php
        $productArray=getFeaturedProducts();
        $filteredProductArray=filterFeaturedItemsMachines($productArray);
        foreach($filteredProductArray as $arrayValue){
            $categoryUrlSlug=$arrayValue['url_slug'];
            $subcategoryUrlSlug=$arrayValue['url_slug'];
            $counter=mt_rand(0,1);
            echo '<div class="col-md-3 col-sm-6 col-xs-12 border spacer-25">';
            echo '<div class="row">';
            if($counter==1){
                echo '<div class="col-md-12 text-center featured-items-col"><img src="important-images/placeholder-tool1.jpg" class="img-responsive featured-pic" /></div>';
            }else {
                echo '<div class="col-md-12 text-center featured-items-col"><img src="important-images/placeholder-tool.jpg" class="img-responsive featured-pic" /></div>';
            }
            echo '</div>';
            echo '<div class="row spacer-25">';
            echo '<div class="col-md-12" style="height:60px;"><h4 class="h4-resized">'.$arrayValue['manufacturer_name'].' - '.$arrayValue['name'].'</h4></div>';
            echo '</div>';
            echo '<div class="row">';
            echo '<div class="col-md-12"><p style="font-size:11px;color=#929292;">Akumulatorski zavrtač Bosch GSR 14.4-2-Li sa 2 akumulatora, snaga</p></div>';
            echo '</div>';
            echo '<div class="row">';
            echo '<div class="col-md-12 price-display spacer-top">RSD '.number_format($arrayValue['price'], 2,',','.').'</div>';
            echo '</div>';
            echo '<div class="row spacer-25" style="border-top:thin solid #E3e3e3;">';
            echo '<div class="col-md-12 clear-padding-margin"><a href="mašine/'.$categoryUrlSlug.'/'.$subcategoryUrlSlug.'/detalji/'.$arrayValue['catalogue_number'].'" class="btn btn-block btn-sm btn-add-to-cart"><span class="glyphicon glyphicon-random"></span> DETALJI</a></div>';
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>
</div>