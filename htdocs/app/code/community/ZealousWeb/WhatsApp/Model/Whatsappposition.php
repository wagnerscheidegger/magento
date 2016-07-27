<?php
/**
 * @description ZealousWeb Model
 *
 * @category  community
 * @package   community_ZealousWeb_Whatsapp
 * @author    Zealousweb
 */
class ZealousWeb_WhatsApp_Model_Whatsappposition extends Mage_Core_Model_Abstract
{
	
	/**
	 * @description Options array for backend setting
	 *
	 * @param  no
	 * @return  array
	 */
	public function toOptionArray()
	{
		return array(
	
				array('value' => 1, 'label'=>Mage::helper('adminhtml')->__('Product Page view area')),
				array('value' => 2, 'label'=>Mage::helper('adminhtml')->__('Product Page footer area')),
				array('value' => 3, 'label'=>Mage::helper('adminhtml')->__('Both area(view area and footer area)')),
				
		);
	}
    
}