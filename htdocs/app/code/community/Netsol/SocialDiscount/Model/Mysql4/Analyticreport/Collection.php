<?php
class Netsol_SocialDiscount_Model_Mysql4_Analyticreport_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
 
    protected function _construct() {
        $this->_init('netsol_sd/socialdiscount');
    }
 
    protected function _joinFields($from = '', $to = '') {
		//$productNameAttrId = Mage::getModel('eav/entity_attribute')->loadByCode('4', 'name')->getAttributeId();
		$productNameAttrId = Mage::getResourceModel('eav/entity_attribute')->getIdByCode('catalog_product', 'name');
		
        $this->addFieldToFilter('creation_date' , array("from" => $from, "to" => $to, "datetime" => true));
        $this->getSelect()
			 ->group('product_id')
			 ->columns(array('total_coupon_code' => 'COUNT(coupon_code)'))
			 ->columns(array('total_unique_ip' => 'COUNT(DISTINCT(ip_address))'))
			 ->columns(array('total_used_coupon' => 'SUM(IF(coupon_used = "1", 1, 0))'))
			 ->joinLeft(
				array('cpev' => 'catalog_product_entity_varchar'), 
				'cpev.entity_id = main_table.product_id AND cpev.attribute_id = '.$productNameAttrId, 
				array('product_name' => 'value')
			 );
 
        return $this;
    }
 
    public function setDateRange($from, $to) {
        $this->_reset()->_joinFields($from, $to);
        return $this;
    }
 
    public function load($printQuery = false, $logQuery = false) {
        if ($this->isLoaded()) {
            return $this;
        }
        
        parent::load($printQuery, $logQuery);
        return $this;
    }
 
    public function setStoreIds($storeIds) {
        return $this;
    }
}
