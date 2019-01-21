<?php

/**
 * MAGENTO_ROOT_DIR/unused.php
 * php -f unused.php
 */

$mageFilename = '../app/Mage.php';
if (!file_exists($mageFilename)) {
    echo $mageFilename." was not found";
    exit;
}
require_once $mageFilename;

// Bootstrap Magento
Mage::app('admin');

set_time_limit(0);
ini_set('display_errors', 1);

$product            = Mage::getModel('catalog/product');
$attributesByTable  = $product->getResource()->loadAllAttributes($product)->getAttributesByTable();
$adapter            = Mage::getResourceSingleton('core/resource')->getReadConnection();

foreach ($attributesByTable as $table => $attributes) {

    foreach ($attributes as $attribute) {


        if(
            strlen($attribute->getBackendModel() ) > 0
            ||
            $attribute->getSourceModel() != 'eav/entity_attribute_source_table'
            ||
            (
                $attribute->getFrontendInput() != 'select'
              //  $attribute->getFrontendInput() != 'multiselect'
             //  $attribute->getFrontendInput() != 'text'
           //     $attribute->getFrontendInput() != 'textarea'
            )
        ) {

            continue;
        }
        $sql = "SELECT `value`, COUNT(*) AS `count` FROM `$table` WHERE `attribute_id` = " . $attribute->getAttributeId() . " GROUP BY `value`";
        $rows = $adapter->fetchAll($sql);

        // <= 5
        if (count($rows)== 0) {
            /* $sql = "DELETE FROM catalog_product_super_attribute
WHERE attribute_id = ".$attribute->getId();
         $rows = $adapter->query($sql);*/
            echo $attribute->getAttributeCode().' - '.$attribute->getId().'<br/>';
           // $attribute->getId();
           try {
             //  $attribute->delete();
           } catch (Exception $e) {

           }

        }
    }
}