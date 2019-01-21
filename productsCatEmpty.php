<?php
error_reporting(E_ALL | E_STRICT);
require_once dirname(__FILE__).'/../app/Mage.php';
function generateCsv($data, $delimiter = ',', $enclosure = '"') {
    $handle = fopen('php://temp', 'r+');
    foreach ($data as $line) {
        fputcsv($handle, $line, $delimiter, $enclosure);
    }
    rewind($handle);
    while (!feof($handle)) {
        $contents .= fread($handle, 8192);
    }
    fclose($handle);
    return $contents;
}


umask(0);
Mage::app();

$i=0;
$sql = "select
    type_id,sku
 from catalog_product_entity a
 left join catalog_category_product cp on cp.`product_id` = a.entity_id
 left join catalog_product_relation cpr on cpr.child_id = a.entity_id
 where
       cp.product_id is null
   and cpr.parent_id is null";
$connection = Mage::getSingleton('core/resource')->getConnection('core_read');

$data = [['sku']];
foreach($connection->fetchAll($sql) as $arr_row) {

    $sku = $arr_row['sku'];
    $product = Mage::getModel('catalog/product');
    $product->load($product->getIdBySku($sku));
    $data[] = [
        'sku' => $product->getSku()
    ];

}


file_put_contents(dirname(__FILE__).'/export/productsemptycats.csv', generateCsv($data));


