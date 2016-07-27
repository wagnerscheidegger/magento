<?php
class Netsol_SocialDiscount_Model_System_Config_Source_Coupontype
{
	/**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 'by_percent', 'label'=>Mage::helper('adminhtml')->__('Percent of product price discount')),
            array('value' => 'by_fixed', 'label'=>Mage::helper('adminhtml')->__('Fixed amount discount')),
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
            'by_percent' => Mage::helper('adminhtml')->__('Percent of product price discount'),
            'by_fixed' => Mage::helper('adminhtml')->__('Fixed amount discount'),
        );
    }
}
