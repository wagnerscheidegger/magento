<?php
class Netsol_SocialDiscount_Model_Socialdiscount extends Mage_Core_Model_Abstract
{
    protected function _construct() {
		parent::_construct();
        $this->_init('netsol_sd/socialdiscount');
    }
}
