<?php
/*
 * @desc: Default enable social discount for all products on installation
*/

$products = Mage::getModel('catalog/product')->getCollection()->addAttributeToSelect('enable_social_discount');
if($products->count()) {
	Mage::getSingleton('core/resource_iterator')->walk($products->getSelect(), array('socialDiscountCallback'));
}

function socialDiscountCallback($args) {
	$product = Mage::getModel('catalog/product');
	$product->setData($args['row']); //map data to product model
    $product->setEnableSocialDiscount(1);
    $product->getResource()->saveAttribute($product, 'enable_social_discount');
}
