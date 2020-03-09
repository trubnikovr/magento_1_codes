<?php
include 'app/Mage.php';
Mage::app();

$model = Mage::getSingleton('customer/customer');

$result = $model->getCollection()
    ->addAttributeToSelect('*')
    ->addAttributeToFilter('lastname', array('like' => "%ссылке%"));


Mage::register('isSecureArea', true);

foreach($result as $r)
{

  $customer = Mage::getModel('customer/customer')->load($r->getId());
  $customer->delete();
}
