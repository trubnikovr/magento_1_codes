<?php
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);
require_once(dirname(__FILE__).'/../app/Mage.php');
umask(0);
Mage::app('admin');

Mage::setIsDeveloperMode(true);

$setupModel = Mage::getResourceModel('catalog/setup', 'catalog_setup');
$attributeGroupId = $setupModel->getAttributeGroup('catalog_product', 4, 'Welivv Options');

$groups = Mage::getModel('eav/entity_attribute_group')
    ->getResourceCollection()
    ->setAttributeSetFilter(4) // Attribute set Id

    ->setSortOrder()
    ->load();

$attributeCodes = array();
print_r($attributeGroupId['attribute_group_id']); die;
foreach ($groups as $group) {

    if($group->getId() != 7) {
        continue;
    }

    $groupName = $group->getAttributeGroupName();
    $groupId   = $group->getAttributeGroupId();

    $attributes = Mage::getResourceModel('catalog/product_attribute_collection')
        ->setAttributeGroupFilter($group->getId())
        ->addVisibleFilter()
     //   ->addAttributeToFilter('status', Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
        ->addFieldToFilter('frontend_input','select')
        ->addFieldToFilter('is_user_defined', 1)
        ->checkConfigurableProducts()
        ->load();

        if ($attributes->getSize() > 0) {

            foreach ($attributes->getItems() as $attribute) {
                /* @var $child Mage_Eav_Model_Entity_Attribute */
                $attributeCodes[] = $attribute->getAttributeCode();

                $setupModel->addAttributeToSet('catalog_product', 4, $attributeGroupId['attribute_group_id'],  $attribute->getId());
                echo $attribute->getName().PHP_EOL;

            }
        }

    }