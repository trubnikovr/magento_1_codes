<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 26.09.2018
 * Time: 19:02
 */

/*
 * andcosta anglepoise arturoalvarez axis71 bover carpyen castor contardi davidtrubridge jakedyson fanimation foscarini humanscale illuminatingexperiences jonathanadler kartell lbllighting leucos lightyears louispoulsen luceplan marset matthewsfan modernfan moooi nemo pablo pallucco prandina robertabbey santaandcole slamp sonneman techlighting terzani troylighting vib
 * ia*/
 

$skus = ['artemide'];

require_once(dirname(__FILE__).'/../app/Mage.php');
umask(0);
Mage::app('admin');

Mage::setIsDeveloperMode(true);
ini_set('display_errors', 1);
$collection_of_products = Mage::getModel('welivv_data/brand')
    ->getCollection();

$brands = $collection_of_products->addFieldToFilter('id', $array)
    ->getSelect();

foreach ($skus as $sku) {

    $collection_of_products = Mage::getModel('welivv_data/brand')
        ->getCollection();

    $collection_of_products->addFieldToFilter('id', $array)
        ->getSelect();


    $catalog = Mage::getModel('catalog/product')->getCollection();
    $products = $catalog->addAttributeToFilter('sku', array('like' => $sku.'%'));

    foreach ($products as $product) {

        echo $product->getSku().' was deleted'.PHP_EOL;
        $product->delete();
    }
}



