<?php

function getFeaturedProducts(){
    global $db;
    $getMachines = $db->prepare("SELECT catalogue_number, id_bigcategory, id_subcategory, id_category, p.id_manufacturer, name, description, price, fixed_price, regular_price, discount_percentage, discount, manufacturer_name, url_slug FROM machines as p
                    INNER JOIN machine_manufacturers as manuf ON p.id_manufacturer=manuf.id_manufacturer ORDER BY RAND()");
    $getMachines->execute();
    $productArray=array();
    $returnProducts=$getMachines->fetchALL(PDO::FETCH_ASSOC);
        foreach($returnProducts as $product) {
            $productArray[] = $product;
        }
    return $productArray;
}

function filterFeaturedItemsMachines($productArray){
    $array=$productArray;
    $filteredProducts=array();
    foreach($array as $product){
        if($product['id_bigcategory']==20 AND $product['discount']==1 AND $product['id_category']!=10) {
            $filteredProducts[] = $product;
        }else{
            continue;
        }
    }
    $slicedarray=array_slice($filteredProducts, 0, 8, true);
    return $slicedarray;

}

function getMachineCategories(){
    global $db;
    $machineCategories=array();
    $getMachineCategories=$db->prepare('SELECT category_name, id_category, url_slug FROM machine_category WHERE category_name!=:category_name');
    $getMachineCategories->execute(array(':category_name'=>'default_category'));
    $returnMachineCategories=$getMachineCategories->fetchALL(PDO::FETCH_ASSOC);
    foreach($returnMachineCategories as $machineCategory){
        $machineCategories[]=$machineCategory;
    }
    return $machineCategories;
}

function getMachineSubCategories($id_category){
    global $db;
    $machineSubCategories=array();
    $getMachineSubCategory=$db->prepare('SELECT subcategory_name, id_subcategory, url_slug FROM machine_subcategory WHERE subcategory_name!=:subcategory_name AND id_category=:id_category');
    $getMachineSubCategory->execute(array(':subcategory_name'=>'default_subcategory',':id_category'=>$id_category));
    $returnMachineSubCategory=$getMachineSubCategory->fetchALL(PDO::FETCH_ASSOC);
    foreach($returnMachineSubCategory as $machineSubCategory){
        $machineSubCategories[]=$machineSubCategory;
    }
    return $machineSubCategories;
}

function getHandtoolCategories(){
    global $db;
    $handtoolCategories=array();
    $getHandtoolCategories=$db->prepare('SELECT category_name, id_category, url_slug FROM handtool_category WHERE category_name!=:category_name');
    $getHandtoolCategories->execute(array(':category_name'=>'default_category'));
    $returnHandtoolCategories=$getHandtoolCategories->fetchALL(PDO::FETCH_ASSOC);
    foreach($returnHandtoolCategories as $handtoolCategory){
        $handtoolCategories[]=$handtoolCategory;
    }

    return $handtoolCategories;
}

function getHandtoolSubCategories($id_category){
    global $db;
    $handtoolSubCategories=array();
    $getHandtoolSubCategory=$db->prepare('SELECT subcategory_name, id_subcategory, url_slug FROM handtool_subcategory WHERE subcategory_name!=:subcategory_name AND id_category=:id_category');
    $getHandtoolSubCategory->execute(array(':subcategory_name'=>'default_subcategory',':id_category'=>$id_category));
    $returnHandtoolSubCategory=$getHandtoolSubCategory->fetchALL(PDO::FETCH_ASSOC);
    foreach($returnHandtoolSubCategory as $handtoolSubCategory){
        $handtoolSubCategories[]=$handtoolSubCategory;
    }
    return $handtoolSubCategories;
}

function getAcessoryCategories(){
    global $db;
    $accessoryCategories=array();
    $getAccessoryCategories=$db->prepare('SELECT category_name, id_category, url_slug FROM accessory_category WHERE category_name!=:category_name');
    $getAccessoryCategories->execute(array(':category_name'=>'default_category'));
    $returnAccessoryCategories=$getAccessoryCategories->fetchALL(PDO::FETCH_ASSOC);
    foreach($returnAccessoryCategories as $accessoryCategory){
        $accessoryCategories[]=$accessoryCategory;
    }

    return $accessoryCategories;
}

function getAccessorySubCategories($id_category){
    global $db;
    $accessorySubCategories=array();
    $getAccessorySubCategory=$db->prepare('SELECT subcategory_name, id_subcategory, url_slug FROM accessory_subcategory WHERE subcategory_name!=:subcategory_name AND id_category=:id_category');
    $getAccessorySubCategory->execute(array(':subcategory_name'=>'default_subcategory',':id_category'=>$id_category));
    $returnAccessorySubCategory=$getAccessorySubCategory->fetchALL(PDO::FETCH_ASSOC);
    foreach($returnAccessorySubCategory as $accessorySubCategory){
        $accessorySubCategories[]=$accessorySubCategory;
    }
    return $accessorySubCategories;
}

function getProtectiveClothingCategories(){
    global $db;
    $ptcCategories=array();
    $getPtcCategories=$db->prepare('SELECT category_name, id_category, url_slug FROM protective_clothing_category WHERE category_name!=:category_name');
    $getPtcCategories->execute(array(':category_name'=>'default_category'));
    $returnPtcCategories=$getPtcCategories->fetchALL(PDO::FETCH_ASSOC);
    foreach($returnPtcCategories as $ptcCategory){
        $ptcCategories[]=$ptcCategory;
    }

    return $ptcCategories;
}

function getProtectiveClothingSubCategories($id_category){
    global $db;
    $ptcSubCategories=array();
    $getPtcSubCategory=$db->prepare('SELECT subcategory_name, id_subcategory, url_slug FROM protective_clothing_subcategory WHERE subcategory_name!=:subcategory_name AND id_category=:id_category');
    $getPtcSubCategory->execute(array(':subcategory_name'=>'default_subcategory',':id_category'=>$id_category));
    $returnPtcSubCategory=$getPtcSubCategory->fetchALL(PDO::FETCH_ASSOC);
    foreach($returnPtcSubCategory as $ptcSubCategory){
        $ptcSubCategories[]=$ptcSubCategory;
    }
    return $ptcSubCategories;
}

function displayProductMenu($machineCategory, $handtoolCategory, $accessoryCategory, $ptcCategory){

    foreach($machineCategory as $mCategory){
        $mSubcategory=getMachineSubCategories($mCategory['id_category']);
        echo '<li class="menu-item dropdown dropdown-submenu"><a class="dropdown-toggle" data-toggle="dropdown" href="#">'.$mCategory['category_name'].'</a>';
        echo '<ul class="dropdown-menu">';
        foreach($mSubcategory as $mSub){
            //echo "<li class=\"last\"><a href='item-list.php?type=machine&cat=$mCategory[id_category]&subcat=$mSub[id_subcategory]&brand=all'>" . $mSub['subcategory_name'] . "</a></li>\n";
            echo '<li class="menu-item"><a href="mašine/'.$mCategory['url_slug'].'/'.$mSub['url_slug'].'-'.$mSub['id_subcategory'].'/all">'.$mSub['subcategory_name'].'</a>';
        }
        echo '</ul>';
        echo '</li>';
    }

    foreach($handtoolCategory as $hCategory){
        $hSubcategory=getHandtoolSubCategories($hCategory['id_category']);
        echo '<li class="menu-item dropdown dropdown-submenu"><a class="dropdown-toggle" data-toggle="dropdown" href="#">'.$hCategory['category_name'].'</a>';
        echo '<ul class="dropdown-menu">';
        foreach($hSubcategory as $hSub){
            echo '<li class="menu-item"><a href="ručni-alati/'.$hCategory['url_slug'].'/'.$hSub['url_slug'].'-'.$hSub['id_subcategory'].'/all">'.$hSub['subcategory_name'].'</a>';
        }
        echo '</ul>';
        echo '</li>';
    }

    foreach($accessoryCategory as $aCategory){
        $aSubcategory=getAccessorySubCategories($aCategory['id_category']);
        echo '<li class="menu-item dropdown dropdown-submenu"><a class="dropdown-toggle" data-toggle="dropdown" href="#">'.$aCategory['category_name'].'</a>';
        echo '<ul class="dropdown-menu">';
        foreach($aSubcategory as $aSub){
            echo '<li class="menu-item"><a href="pribor-za-mašine/'.$aCategory['url_slug'].'/'.$aSub['url_slug'].'-'.$aSub['id_subcategory'].'/all">'.$aSub['subcategory_name'].'</a>';
        }
        echo '</ul>';
        echo '</li>';
    }

    foreach($ptcCategory as $pCategory){
        $pSubcategory=getProtectiveClothingSubCategories($pCategory['id_category']);
        echo '<li class="menu-item dropdown dropdown-submenu"><a class="dropdown-toggle" data-toggle="dropdown" href="#">'.$pCategory['category_name'].'</a>';
        echo '<ul class="dropdown-menu">';
        foreach($pSubcategory as $pSub){
            echo '<li class="menu-item"><a href="htz-oprema/'.$pCategory['url_slug'].'/'.$pSub['url_slug'].'-'.$pSub['id_subcategory'].'/all">'.$pSub['subcategory_name'].'</a>';
        }
        echo '</ul>';
        echo '</li>';
    }
}

function getProducts(){
    global $db;
    $getMachines=$db->prepare('SELECT catalogue_number, id_bigcategory, item.id_subcategory, item.id_category, item.id_manufacturer, name, description, price, fixed_price, regular_price, discount_percentage, discount, manufacturer_name, id_item, item.count, category_name, subcategory_name FROM machines as item
                              INNER JOIN machine_manufacturers as manuf ON item.id_manufacturer=manuf.id_manufacturer
                              INNER JOIN machine_category as cat ON item.id_category=cat.id_category
                              INNER JOIN machine_subcategory as subcat ON item.id_subcategory=subcat.id_subcategory
                              ORDER BY price ASC');
    $getMachines->execute();
    $returnMachines=$getMachines->fetchALL(PDO::FETCH_ASSOC);
    foreach($returnMachines as $machine){
        $productArray[]=$machine;
    }

    $getHandtools=$db->prepare('SELECT catalogue_number, id_bigcategory, item.id_subcategory, item.id_category, item.id_manufacturer, name, description, price, fixed_price, regular_price, discount_percentage, discount, manufacturer_name, id_item, item.count, category_name, subcategory_name FROM handtools as item
                                INNER JOIN handtool_category as cat ON item.id_category=cat.id_category
                                INNER JOIN handtool_subcategory as subcat ON item.id_subcategory=subcat.id_subcategory
                                INNER JOIN handtool_manufacturers as manuf ON item.id_manufacturer=manuf.id_manufacturer ORDER BY price ASC');
    $getHandtools->execute();
    $returnHandtools=$getHandtools->fetchALL(PDO::FETCH_ASSOC);
    foreach($returnHandtools as $handtool){
        $productArray[]=$handtool;
    }

    $getAccessories=$db->prepare('SELECT catalogue_number, id_bigcategory, item.id_subcategory, item.id_category, item.id_manufacturer, name, description, price, fixed_price, regular_price, discount_percentage, discount, manufacturer_name, id_item, item.count, category_name, subcategory_name FROM accessories as item
                                  INNER JOIN accessory_category as cat ON item.id_category=cat.id_category
                                  INNER JOIN accessory_subcategory as subcat ON item.id_subcategory=subcat.id_subcategory
                                  INNER JOIN accessory_manufacturers as manuf ON item.id_manufacturer=manuf.id_manufacturer ORDER BY price ASC');
    $getAccessories->execute();
    $returnAccessories=$getAccessories->fetchALL(PDO::FETCH_ASSOC);
    foreach($returnAccessories as $accessory){
        $productArray[]=$accessory;
    }

    $getProtectiveClothing=$db->prepare('SELECT catalogue_number, id_bigcategory, item.id_subcategory, item.id_category, item.id_manufacturer, name, description, price, fixed_price, regular_price, discount_percentage, discount, manufacturer_name, id_item, item.count, category_name, subcategory_name FROM protective_clothing as item
                                        INNER JOIN protective_clothing_category as cat ON item.id_category=cat.id_category
                                        INNER JOIN protective_clothing_subcategory as subcat ON item.id_subcategory=subcat.id_subcategory
                                        INNER JOIN protective_clothing_manufacturers as manuf ON item.id_manufacturer=manuf.id_manufacturer ORDER BY price ASC');
    $getProtectiveClothing->execute();
    $returnProtectiveClothing=$getProtectiveClothing->fetchALL(PDO::FETCH_ASSOC);
    foreach($returnProtectiveClothing as $protectiveClothing){
        $productArray[]=$protectiveClothing;
    }

    return $productArray;
}

function filterProductsBySubcategory($type, $subCategory, $productArray){
        $array = $productArray;
        $filteredProducts = array();
        switch ($type) {
            case 'machine': {
                foreach ($array as $product) {
                    if ($product['id_bigcategory'] == 20 AND $product['id_subcategory'] == $subCategory) {
                        $filteredProducts[] = $product;
                        $_SESSION['item-list'] = $filteredProducts;
                    } else {
                        continue;
                    }
                }
                break;
            }
            case 'handtool': {
                foreach ($array as $product) {
                    if ($product['id_bigcategory'] == 10 AND $product['id_subcategory'] == $subCategory) {
                        $filteredProducts[] = $product;
                        $_SESSION['item-list'] = $filteredProducts;
                    } else {
                        continue;
                    }
                }
                break;
            }
            case 'accessories': {
                foreach ($array as $product) {
                    if ($product['id_bigcategory'] == 70 AND $product['id_subcategory'] == $subCategory) {
                        $filteredProducts[] = $product;
                        $_SESSION['item-list'] = $filteredProducts;
                    } else {
                        continue;
                    }
                }
                break;
            }
            case 'ptc': {
                foreach ($array as $product) {
                    if ($product['id_bigcategory'] == 95 AND $product['id_subcategory'] == $subCategory) {
                        $filteredProducts[] = $product;
                        $_SESSION['item-list'] = $filteredProducts;
                    } else {
                        continue;
                    }
                }
            }

        }
    return true;
}

function getPictures(){
    global $db;
    $returnPictures=array();

    $getMachinePics=$db->prepare('SELECT id_image, id_item, name, thumbnail FROM machine_images');
    $getMachinePics->execute();
    $resultGetMachinePics=$getMachinePics->fetchALL(PDO::FETCH_ASSOC);
    foreach($resultGetMachinePics as $resMachinePics){
        $returnPictures[]=$resMachinePics;
    }

    $getHandtoolPics=$db->prepare('SELECT id_image, id_item, name, thumbnail FROM handtool_images');
    $getHandtoolPics->execute();
    $resultGetHandtoolPics=$getHandtoolPics->fetchALL(PDO::FETCH_ASSOC);
    foreach($resultGetHandtoolPics as $resHandtoolPics){
        $returnPictures[]=$resHandtoolPics;
    }

    $getAccessoryPics=$db->prepare('SELECT id_image, id_item, name, thumbnail FROM accessory_images');
    $getAccessoryPics->execute();
    $resultGetAccessoryPics=$getAccessoryPics->fetchALL(PDO::FETCH_ASSOC);
    foreach($resultGetAccessoryPics as $resAccessoryPics){
        $returnPictures[]=$resAccessoryPics;
    }

    $getProtectiveClothingPics=$db->prepare('SELECT id_image, id_item, name, thumbnail FROM protective_clothing_images');
    $getProtectiveClothingPics->execute();
    $resultGetProtectiveClothingPics=$getProtectiveClothingPics->fetchALL(PDO::FETCH_ASSOC);
    foreach($resultGetProtectiveClothingPics as $resProtectiveClothingPics){
        $returnPictures[]=$resProtectiveClothingPics;
    }

    return $returnPictures;
}

function getPicturesForId($itemId, $pictureArray){
    foreach($pictureArray as $picArray){
        if($picArray['id_item']==$itemId){
            $pictureForId[]=$picArray;
        }else{
            continue;
        }
    }
    return $pictureForId;
}

function getThumbnailForId($pictureForId){
    foreach($pictureForId as $picForId){
        if($picForId['thumbnail']==1){
            $thumbnailPic=$picForId['name'];
        }else{
            continue;
        }
    }
    return $thumbnailPic;
}

function paginationDisplay($category, $subCategory, $itemType, $itemBrand, $totalPages, $page){
    switch($itemType){
        case 'machine':{
            $link='mašine/'.$category.'/'.$subCategory.'/'.$itemBrand.'/%d';
            break;
        }
        case 'handtool':{
            $link='ručni-alat/'.$category.'/'.$subCategory.'/'.$itemBrand.'/%d';
            break;
        }
        case 'accessories':{
            $link='pribor-za-mašine/'.$category.'/'.$subCategory.'/'.$itemBrand.'/%d';
            break;
        }
        case 'ptc':{
            $link='htz-oprema/'.$category.'/'.$subCategory.'/'.$itemBrand.'/%d';
            break;
        }
        default:{
            $link='početna/';
            break;
        }
    }
    $pagerContainer = '<div id="paginationdiv">';
    if ($totalPages != 0) {
        if ($page == 1) {
            $pagerContainer .= '';
        } else {
            $pagerContainer .= sprintf('<a href="' . $link . '" class="nextbtn"> &#171; Nazad</a>', $page - 1);
        }
        $pagerContainer .= ' <span class="pagination"> Strana ' . $page . ' od ' . $totalPages . '</span>';
        if ($page == $totalPages) {
            $pagerContainer .= '';
        } else {
            $pagerContainer .= sprintf('<a href="' . $link . '" class="nextbtn">&nbsp;Napred &#187; </a>', $page + 1);
        }
    }
    $pagerContainer .= '</div>';

    echo $pagerContainer;
}

function itemLinkGenerator($itemType){
    switch($itemType){
        case 'machine':{
            $link='mašine';
            break;
        }
        case 'handtool':{
            $link='ručni-alat';
            break;
        }
        case 'accessories':{
            $link='pribor-za-mašine';
            break;
        }
        case 'ptc':{
            $link='htz-oprema';
            break;
        }
    }
    return $link;
}

function getSingleItem($catalogueNumber, $itemArray){
    $singleItem=array();
    foreach($itemArray as $item){
        if($catalogueNumber==$item['catalogue_number']){
            $singleItem=$item;
        }else{
            continue;
        }
    }
    return $singleItem;
}

function checkIfAvailable($itemCount, $amountEntered, $itemCatalogueNumber){
    if($itemCount == 0 OR $itemCount<$amountEntered OR $_SESSION['shopping-cart'][$itemCatalogueNumber]+$amountEntered<=$itemCount) {
        if ($_SESSION['shopping-cart'][$itemCatalogueNumber] + $amountEntered > $itemCount) {
            $_SESSION['cart-error'] = 'Nije dostupna tražena količina. Kontaktirajte nas.';
            return false;
        } else {
            return true;
        }
    }else{
        $_SESSION['cart-error'] = 'Nije dostupna tražena količina. Kontaktirajte nas.';
        return false;
    }
}

function returnItemType($itemTypeID){
    if($itemTypeID=='10'){
        $itemType='handtool';
    }elseif($itemTypeID=='20'){
        $itemType='machine';
    }elseif($itemTypeID=='70'){
        $itemType='accessories';
    }elseif($itemTypeID=='95'){
        $itemType='ptc';
    }else{
        return false;
    }

    return $itemType;
}

function noProductErrorDisplay(){
    echo '<div class="row spacer-25">';
    echo '<div class="col-md-12">';
    echo '<div class="row">';
    echo '<div class="col-md-6 col-md-offset-3 table-bordered text-center center-notification-text">';
    echo 'Došlo je do greške prilikom obrade Vašeg zahteva.';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}

?>