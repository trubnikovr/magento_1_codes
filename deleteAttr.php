<?php
error_reporting(E_ALL | E_STRICT);

require_once '../app/Mage.php';
umask(0);
Mage::app();

$attr = 'fanbodyfinish'; //attribute code to remove
$model = Mage::getModel('catalog/resource_eav_attribute');

//Mage::getModel('catalog/product_attribute_api')->remove(1639);

$setup = Mage::getResourceModel('catalog/setup', 'core_setup');
try {
    $setup->startSetup();
    $setup->removeAttribute('catalog_product', $attr);
    $setup->endSetup();
    echo $attr . " attribute is removed";
} catch (Mage_Core_Exception $e) {
    print_r($e->getMessage());
}