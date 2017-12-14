<div class="row">
<ul class="nav nav-pills navbar-static-top">
    <li class="dropdown">
        <a href="#" data-toggle="dropdown" class="dropdown-toggle">PROIZVODI  <span class="glyphicon glyphicon-th-list"></span></a>
        <ul class="dropdown-menu">
            <?php
            $machineCategory=getMachineCategories();
            $handtoolCategory=getHandtoolCategories();
            $accessoryCategory=getAcessoryCategories();
            $ptcCategory=getProtectiveClothingCategories();
            displayProductMenu($machineCategory,$handtoolCategory,$accessoryCategory,$ptcCategory);
            ?>
        </ul>
    </li>
    <li class="pull-right">
        <a href="#" data-toggle="dropdown" class="dropdown-toggle">KONTAKT</a>
    </li>
    <li class="pull-right">
        <a href="#" data-toggle="dropdown" class="dropdown-toggle">O NAMA</a>
    </li>
    <li class="pull-right">
        <a href="#" data-toggle="dropdown" class="dropdown-toggle">AKCIJE</a>
    </li>
</ul>
    </div>