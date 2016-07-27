<?php
class Netsol_SocialDiscount_Model_Observer
{
	public function checkSocialCoupon(Varien_Event_Observer $observer) {
		$orderIds = $observer->getOrderIds();
		if($orderIds) {
			foreach($orderIds as $orderId) {
				$order = Mage::getModel('sales/order')->load($orderId);
				//get coupon code from order
				$couponCode = $order->getCouponCode();
				if($couponCode != '') {
					//check if social coupon is used
					$socialCoupon = Mage::getModel('netsol_sd/socialdiscount')
										->getCollection()
										->addFieldToFilter('coupon_code', array('eq' => trim($couponCode)));
					if($socialCoupon->count()) {
						try {
							//update social coupon data
							$socialCoupon = $socialCoupon->getFirstItem();
							$socialCoupon->setData('coupon_used', '1');
							$socialCoupon->setData('coupon_used_date', date('Y-m-d H:i:s'));
							$socialCoupon->setData('magento_order_id', $order->getIncrementId());
							$socialCoupon->save();
							
							//delete coupon, if enabled
							if(Mage::helper('netsol_sd')->isDeleteCoupon()) {
								$coupon = Mage::getModel('salesrule/coupon')->load($couponCode, 'code');
								$rule = Mage::getModel('salesrule/rule')->load($coupon->getRuleId());
								$rule->delete();
							}
						} catch(Exception $e) {
							Mage::getSingleton('core/session')->addError(Mage::helper('netsol_sd')->__('Coupon data not updated: '.$e->getMessage()));
						}
					}
				}
			}
		}
	}
}
