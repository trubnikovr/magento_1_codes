<?php
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);
require_once(dirname(__FILE__).'/../app/Mage.php');
umask(0);
Mage::app('admin');

Mage::setIsDeveloperMode(true);
$attributeCode = 'image_link';
$productCollection = Mage::getModel('catalog/product')->getCollection()
    ->addAttributeToFilter($attributeCode, array('null' => true), 'left');
;

foreach($productCollection as $_product)
{
    $product = Mage::getModel('catalog/product')
                   ->load($_product->getEntityId());
    $ar = json_decode($product->getImages(),1);


    if(!count($ar)) {
        continue;
    }

    if(strlen($product->getImageLink())) {
        continue;
    }
    echo "\n".'updating '.$_product->getSku()."...\n";
    try {
        $product->setData($attributeCode, array_shift($ar))
            ->getResource()
            ->saveAttribute($product, $attributeCode);
    } catch (Exception $e) {

        print_r($e->getMessage());
    }

}