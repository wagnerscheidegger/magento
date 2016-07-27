<?php
class Magehit_Customerredirect_Helper_Data extends Mage_Core_Helper_Abstract
{
	const XML_CONFIG_PATH = 'customerredirect/settings/';
	
	public function getConfigValue($key, $value = '')
	{
		return Mage::getStoreConfig(self::XML_CONFIG_PATH . $key, $value);
	}
	
	/*method for login customerredirect */
	public function setRedirectOnLogin(){
		$_path = (string) $this->_getConfigValue('path_redirect');
		return Mage::getUrl($_path);
	}
	
	/*method for Signup customerredirect */
	public function setRedirectOnSignup(){
		$_path = (string) $this->_getConfigValue('signup_path_redirect');
		return Mage::getUrl($_path);
	}
	
	/*method for Logpout customerredirect */
	public function setRedirectOnLogout(){
		$_path = (string) $this->_getConfigValue('logout_path_redirect');
		return $_path;
	}
	
	public function isEnabled()
	{
		return (bool) $this->_getConfigValue('enabled');
	}
	
	public function isoptionEnabled($value)
	{
		return (bool) $this->_getConfigValue($value);
	}
	
	protected function _getConfigValue($key)
	{
		return Mage::getStoreConfig(self::XML_CONFIG_PATH . $key);
	}
}
