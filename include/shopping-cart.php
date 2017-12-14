<div class="row spacer-25 min-height-500">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
<?php
if(isset($_SESSION['shopping-cart']) AND !empty($_SESSION['shopping-cart'])){
    echo '<table class="table">';
            echo '<thead>';
            echo '<tr>';
                echo '<th class="text-center">Slika</th>';
    echo '<th class="text-left">Proizvođač i naziv</th>';
                echo '<th class="text-right">Količina</th>';
                echo '<th class="text-right">Jedinična cena</th>';
                echo '<th class="text-right">Ukupna cena</th>';
                echo '<th class="text-right">Brisanje</th>';
            echo '</tr>';
            echo '</head>';
            echo '<tbody>';
    $totalWithTax=0;
    foreach($_SESSION['shopping-cart'] as $itemCatalogueNumber=>$itemAmount){
        $getItems=getProducts();
        $getPictures=getPictures();


        $getSingleItem=getSingleItem($itemCatalogueNumber, $getItems);
        $getPicturesForId=getPicturesForId($getSingleItem['id_item'], $getPictures);
        $getThumbnailPicture=getThumbnailForId($getPicturesForId);

        $itemManufacturerName=$getSingleItem['manufacturer_name'];
        $itemName=$getSingleItem['name'];
        $itemDiscounted=$getSingleItem['discount'];
        $itemDiscountPercentage=$getSingleItem['discount_percentage'];
        if($itemDiscounted==1){
            $itemPrice=$getSingleItem['price'];
        }else{
            $itemDiscountPercentageConv=(100-$itemDiscountPercentage)/100;
            $itemPrice=$itemDiscountPercentageConv*$getSingleItem['price'];
        }
        echo '<tr>';
        echo '<td class="text-center"><img class="little-thumbnail-picture" src="pictures/'.$itemCatalogueNumber.'/'.$getThumbnailPicture.'"</td><td class="text-left">'.$itemManufacturerName.' '.$itemName.'</td><td class="text-right">'.$itemAmount.'</td><td class="text-right">'.number_format($itemPrice,2,',','.').'</td><td class="text-right">'.number_format($itemPrice*$itemAmount,2,',','.').'</td><td class="text-right"><a href="delete-from-cart.php?catalogue-number='.$itemCatalogueNumber.'"><img class="little-thumbnail-picture" src="important-images/deleteicon.png" /></a></td>';
        echo '</tr>';
        $totalWithTax+=$itemAmount*$itemPrice;
        $totalWithoutTax=$totalWithTax/1.2;
        $tax=$totalWithTax-$totalWithoutTax;
    }
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
    echo '</div>';
    echo '<div class="row">';
    echo '<div class="col-md-4 col-md-offset-8">';
    echo '<table class="table">';
    echo '<tbody>';
    echo '<tr><td>Osnovica:</td><td class="text-right">'.number_format($totalWithoutTax,2, ',','.').' RSD</td></tr>';
    echo '<tr><td>PDV 20%:</td><td class="text-right">'.number_format($tax,2, ',','.').' RSD</td></tr>';
    echo '<tr><td>Ukupno:</td><td class="text-right">'.number_format($totalWithTax,2, ',','.').' RSD</td></tr>';
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
    echo '</div>';
    echo '<div class="row">';
    echo '<div class="col-md-12 text-right">';
    echo '<a href="check-out-details.php" class="btn btn-primary btn-danger"><span class="glyphicon glyphicon-shopping-cart"></span> Sledeći korak</a>';
    echo '</div>';
    echo '</div>';

}else{
    emptyCartMessage();
}
?>
        </table>
    </div>
</div>
    </div>
</div>