<div class="row spacer-25 min-height-500">
    <div class="col-md-12"></div>
    <?php
    if(isset($_GET['type']) AND isset($_GET['catalogue_number'])) {
        $type = $_GET['type'];
        $catalogue_number = $_GET['catalogue_number'];

        $getItems=getProducts();

        $getSingleItem=getSingleItem($catalogue_number, $getItems);

        if(empty($getSingleItem)){
            noProductErrorDisplay();
        }else{
            $itemManufacturerName=$getSingleItem['manufacturer_name'];
            $itemCatalogueNumber=$getSingleItem['catalogue_number'];
            $itemName=$getSingleItem['name'];
            $itemDiscounted=$getSingleItem['discount'];
            $itemDiscountPercentage=$getSingleItem['discount_percentage'];
            $itemDescription=$getSingleItem['description'];
            $itemCategory=$getSingleItem['category_name'];
            $itemSubCategory=$getSingleItem['subcategory_name'];
            $itemCataloguePrice=$getSingleItem['regular_price'];
            $itemCount=$getSingleItem['count'];

            if($itemDiscounted==1){
                $itemPrice=$getSingleItem['price'];
            }else{
                $itemDiscountPercentageConv=(100-$itemDiscountPercentage)/100;
                $itemPrice=$itemDiscountPercentageConv*$getSingleItem['price'];
            }
            $getPictures=getPictures();
            $getPicturesForId=getPicturesForId($getSingleItem['id_item'],$getPictures);

            $thumbnailPicture=getThumbnailForId($getPicturesForId);

            echo '<div class="row">';
            echo '<div class="col-md-8">';
                echo '<div class="row">';
                    echo '<div class="col-md-12 text-center">';
                        echo '<a href="pictures/'.$itemCatalogueNumber.'/'.$thumbnailPicture.'" data-lightbox="item-image-gallery"><img class="img-responsive item-detail-thumbnail" src="pictures/'.$itemCatalogueNumber.'/'.$thumbnailPicture.'" alt="'.$itemManufacturerName.' '.$itemName.'" /></a>';
                    echo '</div>';
                    echo '<div class="col-md-12 spacer-bottom-25 spacer-25">';
                        echo '<div class="row">';
                        foreach($getPicturesForId as $picGallery){
                            echo '<div class="col-xs-2 table-bordered col-md-offset-1">';
                            echo '<a href="pictures/'.$itemCatalogueNumber.'/'.$picGallery['name'].'" data-lightbox="item-image-gallery"><img class="item-detail-gallery-pic img-responsive" src="pictures/'.$itemCatalogueNumber.'/'.$picGallery['name'].'" alt="Gallery pic" style="height:100px;" /></a>';
                            echo '</div>';
                        }
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
            echo '<div class="col-md-4">';
                echo '<div class="row">';
                    echo '<div class="col-md-12">';
                        echo '<h5 class="item-detail-cat-subcat">'.$itemCategory.' / '.$itemSubCategory.'</h5>';
                    echo '</div>';
                    echo '<div class="col-md-12 spacer-bottom-25">';
                        echo '<h3 class="item-detail-name">'.$itemManufacturerName.' '.$itemName.'</h3>';
                    echo '</div>';
                if($itemDiscounted==1 AND $itemCount>0) {
                    if($getSingleItem['regular_price']!=0) {
                        echo '<div class="col-md-12">';
                        echo '<p class="item-detail-cat-subcat">Stara cena</p>';
                        echo '</div>';
                        echo '<div class="col-md-12">';
                        echo '<p class="strikethrough-line old-item-price">' . number_format($itemCataloguePrice, 2, ',', '.') . ' RSD</p>';
                        echo '</div>';
                    }
                    echo '<div class="col-md-12">';
                    echo '<p class="item-detail-cat-subcat">Akcijska cena</p>';
                    echo '</div>';
                    echo '<div class="col-md-12">';
                    echo '<p class="item-detail-current-price">' . number_format($itemPrice, 2, ',', '.') . ' RSD</p>';
                    echo '</div>';
                }elseif($itemDiscounted==0 AND $itemCount >0){
                    echo '<div class="col-md-12">';
                    echo '<p class="item-detail-cat-subcat">Cena sa popustom od '.$itemDiscountPercentage.'%</p>';
                    echo '</div>';
                    echo '<div class="col-md-12">';
                    echo '<p class="item-detail-current-price">'.number_format($itemPrice,2,',','.').' RSD</p>';
                    echo '</div>';
                }else{
                    echo '<div class="col-md-12">';
                    echo '<p class="">Cena na upit.</p>';
                    echo '</div>';
                }
                echo '</div>';
            echo '<form action="add-to-cart.php" method="post" name="addToCartForm">';
            echo '<div class="row spacer-25">';
            echo '<div class="col-md-12"><input type="text" class="full-width-input invisible-border-input" name="addToCartAmount" placeholder="Unesite količinu" required /><input name="addToCartCatalogueNumber" type="hidden" value="'.$itemCatalogueNumber.'" /><input name="addToCartItemType" type="hidden" value="'.$type.'" /></div>';
            echo '</div>';
            echo '<div class="row">';
            echo '<div class="col-md-12"><input type="submit" class="btn btn-block btn-danger" name="addToCartSubmit" value="Dodaj u korpu" /></div>';
            echo '</div>';
            echo '</form>';
            if(isset($_SESSION['cart-error'])){
                $errormsg=$_SESSION['cart-error'];
                echo '<div class="row spacer-top text-center">';
                echo '<div class="col-md-12">';
                echo '<p>'.$errormsg.'</p>';
                echo '</div>';
                echo '</div>';
                unset($_SESSION['cart-error']);
            }
            echo '</div>';
            echo '</div>';
            echo '<div class="row spacer-25">';
            echo '<div class="col-md-2 text-center item-detail-specs-title-border"><h4 class="item-detail-specs-title">Specifikacije</h4></div>';
            echo '</div>';
            echo '<div class="row item-detail-specs-border">';
            echo '<div class="col-md-12 clear-padding">';
            echo '<p>'.$itemDescription.'</p>';
            echo '</div>';
            echo '</div>';
        }
    }else{
        echo 'Error';
    }
        ?>
</div>