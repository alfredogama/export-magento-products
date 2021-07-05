<?php
use Magento\Framework\App\Bootstrap;
require realpath(__DIR__) . '/../app/bootstrap.php';

$bootstrap = Bootstrap::create(BP, $_SERVER);
$objectManager = $bootstrap->getObjectManager();
$state = $objectManager->get('Magento\Framework\App\State');
$state->setAreaCode('frontend');
$store_id = 2; //("Your Store ID")


$fp = fopen("export-simple.csv","w+");
$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
$productCollection = $objectManager->create('Magento\Catalog\Model\ResourceModel\Product\Collection');
$collection = $productCollection->addAttributeToSelect('*')->addFieldTofilter('type_id','simple');

foreach ($collection as $product)
{
    $data = array();
    $prodObj = $product->load($product->getId()); 
    $stockItem = $prodObj->getExtensionAttributes()->getStockItem();
    $stockQty = $stockItem->getQty(); 

    $data[] = $product->getName();
    $data[] = $product->getSku();
    $data[] = $stockQty;
    $data[] = $product->getPrice();
    $data[] = $product->getFinalPrice();

    fputcsv($fp, $data); 

} 
fclose($fp);

?>