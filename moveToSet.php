<?php
error_reporting(E_ALL | E_STRICT);

require_once '../app/Mage.php';
umask(0);
Mage::app();

$setupModel = Mage::getResourceModel('catalog/setup', 'catalog_setup');
$attributeGroupId = $setupModel->getAttributeGroup('catalog_product', 4, 'Welivv Options');

$setupModel->addAttributeToSet('catalog_product', 4, 21, 2042);

