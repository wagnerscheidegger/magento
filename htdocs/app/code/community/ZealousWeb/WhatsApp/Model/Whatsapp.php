<?php
/**
 * @description ZealousWeb Model
 *
 * @category  community
 * @package   community_ZealousWeb_Whatsapp
 * @author    Zealousweb
 */
class ZealousWeb_WhatsApp_Model_Whatsapp extends Mage_Core_Model_Abstract
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
	
				array('value' => s, 'label'=>Mage::helper('adminhtml')->__('Small')),
				array('value' => m, 'label'=>Mage::helper('adminhtml')->__('Medium')),
				array('value' => l, 'label'=>Mage::helper('adminhtml')->__('Large')),
				 
		);
	}
    
}