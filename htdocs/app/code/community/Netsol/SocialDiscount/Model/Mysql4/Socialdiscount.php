<?php
class Netsol_SocialDiscount_Model_Mysql4_Socialdiscount extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct() {
        $this->_init('netsol_sd/netsol_social_discount', 'id');
    }
}
