<?php

error_reporting(E_ALL | E_STRICT);
require_once dirname(__FILE__).'/../app/Mage.php';

umask(0);
Mage::app();

$row = 1;
$conn = Mage::getSingleton('core/resource')->getConnection('core_write');
if (($handle = fopen(dirname(__FILE__)."/csv/skus to be removed from categories B.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {

        $product = Mage::getModel('catalog/product');
        $product->load($product->getIdBySku($data[0]));


        if(!$product->getId()) {
            echo $data[0].' not found'.PHP_EOL;
            continue;
        }

        $sql = "DELETE FROM catalog_category_product WHERE product_id={$product->getId()}";
        $sql_v = "update `catalog_product_entity_int` set value =2 where attribute_id = 99 AND entity_id ={$product->getId()}
";  $conn->query($sql);
        $conn->query($sql_v);
        echo $data[0].' updated'.PHP_EOL;


        continue;



        $product->setCategoryIds([]);


        $product->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_IN_CATALOG);
        $product->save();


        //Mage::getSingleton('catalog/category_api')->removeProduct('7','13409');

    }
    fclose($handle);
}