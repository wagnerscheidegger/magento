<?php
class Netsol_SocialDiscount_Model_System_Config_Source_Couponpermission
{
	/**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 'same_product', 'label'=>Mage::helper('adminhtml')->__('Only on same product')),
            array('value' => 'product_category', 'label'=>Mage::helper('adminhtml')->__('All products from same category')),
            array('value' => 'all_products', 'label'=>Mage::helper('adminhtml')->__('All products')),
        );
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return array(
            'same_product' => Mage::helper('adminhtml')->__('Only on same product'),
            'product_category' => Mage::helper('adminhtml')->__('All products from same category'),
            'all_products' => Mage::helper('adminhtml')->__('All products'),
        );
    }
}
