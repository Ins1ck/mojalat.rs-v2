<div class="row featured-items-row min-height-500">
    <div class="col-md-12 clear-padding-margin">
<?php

if (isset($_GET['type']) AND isset($_GET['brand'])) {
$itemBrand = $_GET['brand'];
$itemType = $_GET['type'];
if (isset($_GET['cat']) AND isset($_GET['subcat'])) {
$cat = $_GET['cat'];
$subCat = $_GET['subcat'];
$subCatExplode = explode('-', $subCat);
$id_subcat = end($subCatExplode);
if (isset($_SESSION['item-list'])) {
    unset($_SESSION['item-list']);
}
$getItems = getProducts();

if ($filterProducts = filterProductsBySubcategory($itemType, $id_subcat, $getItems) == true) {
    if (isset($_SESSION['item-list'])) {
    $yourDataArray = $_SESSION['item-list'];
    $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
    $total = count($yourDataArray); //total items in array
    $limit = 12;//per page
    $totalPages = ceil($total / $limit); //calculate total pages
    $page = max($page, 1); //get 1 page when $_GET['page'] <= 0
    $page = min($page, $totalPages); //get last page when $_GET['page'] > $totalPages
    $offset = ($page - 1) * $limit;
    if ($offset < 0) $offset = 0;

    $yourDataArray = array_slice($yourDataArray, $offset, $limit);

    if (!empty($yourDataArray)) {
        foreach ($yourDataArray as $products) {
            $itemGroupLink=itemLinkGenerator($itemType);
            $getPictures = getPictures();
            $getPicturesForId = getPicturesForId($products['id_item'], $getPictures);
            $getThumbnailPicture = getThumbnailForId($getPicturesForId);
            /*foreach ($getThumbnailPicture as $getThumbnail) {
                $thumbnailPicture = $getThumbnail['name'];
            }
            */
            echo '<div class="col-md-3 col-sm-6 col-xs-6 border spacer-25">';
            echo '<div class="row">';
            echo '<div class="col-md-12 text-center featured-items-col"><a href="'.$itemGroupLink.'/detalji/'.$products['catalogue_number'].'"><img src="pictures/' . $products['catalogue_number'] . '/' . $getThumbnailPicture . '" class="img-responsive featured-pic" /></a></div>';
            echo '</div>';
            echo '<div class="row spacer-25">';
            echo '<div class="col-md-12" style="height:60px;"><h4 class="h4-resized">' . $products['manufacturer_name'] . ' - ' . $products['name'] . '</h4></div>';
            echo '</div>';
            echo '<div class="row">';
            echo '<div class="col-md-12"><p style="font-size:11px;color=#929292;">Akumulatorski zavrtač Bosch GSR 14.4-2-Li sa 2 akumulatora, snaga</p></div>';
            echo '</div>';
            echo '<div class="row">';
            if($products['count']>0 AND $products['discount']==1) {
                echo '<div class="col-md-12 price-display spacer-top">RSD ' . number_format($products['price'], 2, ',', '.') . '</div>';
            }elseif($products['count']>0 AND $products['discount']==0){
                $discountPercentage=(100-$products['discount_percentage'])/100;
                $discountPrice=$discountPercentage*$products['price'];
                echo '<div class="col-md-12 price-display spacer-top">RSD '.number_format($discountPrice,2,',','.').'</div>';
            } else{
                echo '<div class="col-md-12 price-display spacer-top">Cena na upit.</div>';
            }
            echo '</div>';
            echo '<div class="row spacer-25" style="border-top:thin solid #E3e3e3;">';
            echo '<div class="col-md-6 col-featured-buttons"><a href="#" class="btn btn-block btn-sm btn-add-to-cart"><span class="glyphicon glyphicon-shopping-cart"></span> DODAJ U KORPU</a></div>';
            echo '<div class="col-md-6 clear-padding-margin"><a href="'.$itemGroupLink.'/detalji/'.$products['catalogue_number'].'" class="btn btn-block btn-sm btn-add-to-cart"><span class="glyphicon glyphicon-random"></span> DETALJI</a></div>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo 'Nema.';
    }

    ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?php
        paginationDisplay($cat, $subCat, $itemType, $itemBrand, $totalPages, $page);
        ?>
    </div>
</div>
<?php
} else {
    noProductErrorDisplay();
}
} else {
    // nema kategorije, potkategorije
}
} else {
    // nema brenda, tipa proizvoda
}
}
echo '</div>';
echo '</div>';
?>


