<?php
class Netsol_SocialDiscount_CouponController extends Mage_Core_Controller_Front_Action
{
	const XML_PATH_COUPON_EMAIL_TEMPLATE = 'netsol_sd/sd_coupons/coupon_email';
	const XML_PATH_COUPON_EMAIL_IDENTITY = 'netsol_sd/sd_coupons/coupon_email_sender';
	
	public function processAction() {
		$feedId = $this->getRequest()->getPost('feedId');
		$sku = $this->getRequest()->getPost('sku');
		$media = $this->getRequest()->getPost('media');
		$response = array('success' => false);
		
		if($feedId && $sku) {
			$coupon = Mage::helper('netsol_sd')->addCoupon($sku);
			if($coupon) {
				//save coupon record
				$product = Mage::getModel('catalog/product')->loadByAttribute('sku', $sku);
				$data = array(
					'product_id' => $product->getId(),
					'media' => $media,
					'ip_address' => $_SERVER['REMOTE_ADDR'],
					'coupon_code' => $coupon->getCouponCode(),
					'creation_date' => date('Y-m-d H:i:s')
				);
				$socialDiscount = Mage::getModel('netsol_sd/socialdiscount');
				$socialDiscount->setData($data);
				try {
					$socialDiscount->save();
				} catch(Exception $e) {
					die($e->getMessage());
				}
				
				$response = array('success' => true, 'coupon' => $coupon->getCouponCode());
			}
		}
		
		$this->getResponse()->clearHeaders()->setHeader('Content-type','application/json',true);
        $this->getResponse()->setBody(json_encode($response));
	}
	
	public function sendCouponEmailAction() {
		$data = $this->getRequest()->getPost();
		$response = array('success' => false);
		
		if($data['coupon_code'] != '') {
			$emailVars = array('customer_name' => strtok($data['customer_email'], '@'), 'coupon_code' => $data['coupon_code']);
			$translate = Mage::getSingleton('core/translate');
			$translate->setTranslateInline(false);
			$storeId = Mage::app()->getStore()->getId();
			
			$mailTemplate = Mage::getModel('core/email_template');
			try {
				$mailTemplate->setDesignConfig(array('area'=>'frontend'))
							 ->sendTransactional(
								  Mage::getStoreConfig(self::XML_PATH_COUPON_EMAIL_TEMPLATE),
								  Mage::getStoreConfig(self::XML_PATH_COUPON_EMAIL_IDENTITY),
								  $data['customer_email'],
								  strtok($data['customer_email'], '@'),
								  $emailVars,
								  $storeId
							 );
				$translate->setTranslateInline(true);
			} catch(Exception $e) {
				echo $e->getMessage(); die;
			}
			
			$response['success'] = true;
		}
		
		$this->getResponse()->clearHeaders()->setHeader('Content-type','application/json',true);
        $this->getResponse()->setBody(json_encode($response));
	}
}
