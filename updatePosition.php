<?php

$mageFilename = '../app/Mage.php';
require_once $mageFilename;
Mage::setIsDeveloperMode(true);
ini_set('display_errors', 1);
umask(0);
Mage::app('admin');
Mage::register('isSecureArea', 1);
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

set_time_limit(0);
ini_set('memory_limit','1024M');


$categories = Mage::getModel('catalog/category')->getCollection();
$new_order = 5;
foreach($categories as $category){

    $products = $category->getProductCollection();
    $cat_api = new Mage_Catalog_Model_Category_Api;

    foreach ($products as $product){
        $cat_api->assignProduct($category->getId(), $product->getId(), $new_order);

    }
    
}