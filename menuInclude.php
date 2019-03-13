<?php 
require_once($ConstantsArray['dbServerUrl'] ."Enums/UserType.php");
$isDashBoard="";
$isCustomers="";
$isProducts="";
$isProductBrands="";
$isProductFlavours="";
$isProductCategories="";
$isOrders="";
$isChangePassword="";
$isSettings = "";
$isUser = "";
$parts = Explode('/', $_SERVER["PHP_SELF"]);
$file =  $parts[count($parts) - 1];


//echo  $file;
if($file == "dashboard.php"){
	$isDashBoard = "active";
}elseif($file == "showCustomers.php" || $file == "createCustomer.php"){
	$isCustomers = "active";
}elseif($file == "showProducts.php" || $file == "createProduct.php"){
	$isProducts = "active";
}elseif($file == "showProductBrands.php" || $file == "createProductBrand.php"){
	$isProductBrands = "active";
}elseif($file == "showProductFlavours.php" || $file == "createProductFlavour.php"){
	$isProductFlavours = "active";
}elseif($file == "showProductCategories.php" || $file == "createProductCategory.php"){
	$isProductCategories = "active";
}elseif($file == "showOrders.php" || $file == "createOrder.php"){
	$isOrders = "active";
}elseif($file == "adminChangePassword.php"){
	$isChangePassword = "active";
}elseif($file == "adminSettings.php"){
	$isSettings = "active";
}elseif($file == "createUser.php"){
	$isUser = "active";
}
$sessionUtil = SessionUtil::getInstance();
$userType = $sessionUtil->getUserLoggedInUserType();

?>

<nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> 
                    	<a data-toggle="dropdown" class="dropdown-toggle" href="#"> 
	                    	<span class="clear"> 
	                    		<span class="block m-t-xs"> 
	                    			<strong class="font-bold">Batra Marketing Orders</strong>
	                    		</span>
							</span>
						</a>
                    </div>
					
                </li>
                <li class="<?php echo $isDashBoard;?>">
                    <a href="dashboard.php"><i class="fa fa-list-alt"></i> 
                    	<span class="nav-label ">Dashboard</span>  
                    </a>
                </li>
                <li class="<?php echo $isCustomers;?>">
                    <a href="showCustomers.php"><i class="fa fa-coffee"></i> 
                    	<span class="nav-label">Customers</span>  
                    </a>
                </li>
                <?php if($userType != UserType::getName(UserType::representative)){?>
	                <li class="<?php echo $isProducts;?>">
	                    <a href="showProducts.php"><i class="fa fa-clock-o"></i> 
	                    	<span class="nav-label">Products</span>  
	                    </a>
	                </li>
	                <li class="<?php echo $isProductCategories;?>">
	                    <a href="showProductCategories.php"><i class="fa fa-gift"></i> 
	                    	<span class="nav-label">Product Categories</span>  
	                    </a>
	                </li>
	                <li class="<?php echo $isProductFlavours;?>">
	                    <a href="showProductFlavours.php"><i class="fa fa-key"></i> 
	                    	<span class="nav-label">Product Flavours</span>  
	                    </a>
	                </li>
	                <li class="<?php echo $isProductBrands;?>">
	                    <a href="showProductBrands.php"><i class="fa fa-angellist"></i> 
	                    	<span class="nav-label">Product Brands</span>  
	                    </a>
	                </li>
                <?php }?>
                 <li class="<?php echo $isOrders;?>">
                    <a href="showOrders.php"><i class="fa fa-calendar"></i> 
                    	<span class="nav-label">Orders</span>  
                    </a>
                </li>
                 <?php if($userType != UserType::getName(UserType::representative)){?>
	                <li class="<?php echo $isSettings;?>">
	                    <a href="showCashBook.php"><i class="fa fa-cog"></i> 
	                    	<span class="nav-label">Cash Book</span>  
	                    </a>
	                </li>
               
	                <li class="<?php echo $isUser;?>">
	                    <a href="showUsers.php"><i class="fa fa-cog"></i> 
	                    	<span class="nav-label">Users</span>  
	                    </a>
	                </li>
                <?php }?>
                <li>
                    <a href="logout.php"><i class="fa fa-sign-out"></i> 
                    	<span class="nav-label">Logout</span>  
                    </a>
                </li>
            </ul>
            <ul class="dropdown-menu animated fadeInRight m-t-xs">
				
			</ul>

        </div>
    </nav>
