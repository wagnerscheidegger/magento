<?php
/**
 * @description ZealousWeb Block
 *
 * @category  community
 * @package   community_ZealousWeb
 * @author    Zealousweb
 */
class ZealousWeb_WhatsApp_Block_Whatsapp extends Mage_Catalog_Block_Product_View
{
	/**
	 * @description Get button size
	 *
	 * @param  no
	 * @return  string
	 */
	public function getButtonSize(){
		return Mage::getStoreConfig('zwt_wa_section/zwt_wa_group/zwt_wa_button');
	}
	
	/**
	 * @description Get button position
	 *
	 * @param  no
	 * @return  string
	 */
	public function getButtonPos(){
		return Mage::getStoreConfig('zwt_wa_section/zwt_wa_group/zwt_wa_button_pos');
	}
	
	/**
	 * @description Get Is Enable or not
	 *
	 * @param  no
	 * @return  boolean
	 */
	public function getIsEnable()
	{
		return Mage::getStoreConfig('zwt_wa_section/zwt_wa_group/zwt_wa_enable');
		
	}
	
	/**
	 * @description Get Background color
	 *
	 * @param  no
	 * @return  boolean
	 */
	public function getBackcolor()
	{
		return Mage::getStoreConfig('zwt_wa_section/zwt_wa_group/zwt_background');
	
	}
}