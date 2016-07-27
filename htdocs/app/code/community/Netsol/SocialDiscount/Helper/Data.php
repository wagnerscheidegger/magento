<?php
class Netsol_SocialDiscount_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function isFacebookEnabled() {
		return Mage::getStoreConfig('netsol_sd/sd_facebook/facebook_share');
	}
	
	public function isTwitterEnabled() {
		return false;
		//return Mage::getStoreConfig('netsol_sd/sd_twitter/twitter_share');
	}
	
	public function getFacebookAppId() {
		return Mage::getStoreConfig('netsol_sd/sd_facebook/facebook_app_id');
	}
	
	public function isDeleteCoupon() {
		return Mage::getStoreConfig('netsol_sd/sd_coupons/coupon_delete');
	}
	
	public function isValidIP() {
		$customerIp = $_SERVER['REMOTE_ADDR'];
		$blockedIps = Mage::getStoreConfig('netsol_sd/sd_coupons/sd_block_ip');
		$blockedIps = array_map('trim', explode(',', $blockedIps));
		
		return (!in_array($customerIp, $blockedIps)) ? true : false;
	}
	
	public function addCoupon($sku = null) {
		$couponCode = Mage::helper('core')->getRandomString(Mage::getStoreConfig('netsol_sd/sd_coupons/coupon_length'));
		$customerGroupIds = Mage::getModel('customer/group')->getCollection()->getAllIds();
		
		//set data for coupon
		$rule = Mage::getModel('salesrule/rule');
		$rule->setName(Mage::getStoreConfig('netsol_sd/sd_coupons/coupon_name'))                                             
			->setDescription(Mage::getStoreConfig('netsol_sd/sd_coupons/coupon_description'))
			->setFromDate('')
			->setCouponType(Mage_SalesRule_Model_Rule::COUPON_TYPE_SPECIFIC)
			->setCouponCode($couponCode)
			->setUsesPerCustomer(1)
			->setUsesPerCoupon(1)
			->setCustomerGroupIds($customerGroupIds)
			->setIsActive(1)
			->setConditionsSerialized('')
			->setActionsSerialized('')
			->setStopRulesProcessing(0)
			->setIsAdvanced(1)
			->setProductIds('')
			->setSortOrder(0)
			->setSimpleAction(Mage::getStoreConfig('netsol_sd/sd_coupons/coupon_discount_type'))
			->setDiscountAmount(Mage::getStoreConfig('netsol_sd/sd_coupons/coupon_amount'))
			->setDiscountQty(0)
			->setDiscountStep(0)
			->setSimpleFreeShipping('0')
			->setApplyToShipping('0')
			->setIsRss(0)
			->setWebsiteIds(array(1))
			->setStoreLabels(array(Mage::getStoreConfig('netsol_sd/sd_coupons/coupon_name')));
				
		 
		//product found condition type
		$productFoundCondition = Mage::getModel('salesrule/rule_condition_product_found')
			->setType('salesrule/rule_condition_product_found')
			->setValue(1) //0 == not found, 1 == found
			->setAggregator('all'); // match all conditions
		
		$rule->getConditions()->addCondition($productFoundCondition);
		 
		//set coupon condition
		$useOfCoupon = Mage::getStoreConfig('netsol_sd/sd_coupons/use_of_coupon');
		if($useOfCoupon == 'same_product') {
			$attributeSetCondition = Mage::getModel('salesrule/rule_condition_product')
				->setType('salesrule/rule_condition_product')
				->setAttribute('sku')
				->setOperator('==')
				->setValue($sku);
		} else if($useOfCoupon == 'product_category') {
			$product = Mage::getModel('catalog/product')->loadByAttribute('sku', $sku);
			$categoryIds = $product->getCategoryIds();
			if(!empty($categoryIds)) {
				$attributeSetCondition = Mage::getModel('salesrule/rule_condition_product')
					->setType('salesrule/rule_condition_product')
					->setAttribute('category_ids')
					->setOperator('()')
					->setValue(implode(',', $categoryIds));
			}
		}
		
		//apply the rule discount to this specific product
		if(isset($attributeSetCondition)) {
			$productFoundCondition->addCondition($attributeSetCondition);
			$rule->getActions()->addCondition($attributeSetCondition);
		}
		
		try {
			$rule->save();
			return $rule;
		} catch(Exception $e) {
			return false;
		}
	}
}
