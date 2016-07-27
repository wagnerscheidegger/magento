<?php
class Netsol_SocialDiscount_Adminhtml_SocialdiscountController extends Mage_Adminhtml_Controller_Action
{
	protected function _initAction() {
		$this->loadLayout()
			 ->_addBreadcrumb(Mage::helper('adminhtml')->__('Social Discount'), Mage::helper('adminhtml')->__('Netsol'));
		
		return $this;
	}
	
	/*
	 *@ Description: Show social discount coupons listing
	 */
	public function listAction() {
		$this->_initAction();
		$this->_title($this->__('Social Discount'));
		$this->_setActiveMenu('netsol_sd/social_discount');
		$this->_addContent($this->getLayout()->createBlock('netsol_sd/adminhtml_report'));
		$this->renderLayout();
	}
	
	
	/*
	 *@ Description: Mass block ip address
	 *@ Param: social_discount_id's
	 */
	public function massBlockIPsAction() {
		$sdIds = $this->getRequest()->getParam('sd_id');
		$sdCollection = Mage::getModel('netsol_sd/socialdiscount')
							->getCollection()
							->addFieldToFilter('id', array('in' => $sdIds));
		
		$this->updateIpAddresses($sdCollection, true);
	}
	
	/*
	 *@ Description: Mass un-block ip address
	 *@ Param: social_discount_id's
	 */
	public function massUnblockIPsAction() {
		$sdIds = $this->getRequest()->getParam('sd_id');
		$sdCollection = Mage::getModel('netsol_sd/socialdiscount')
							->getCollection()
							->addFieldToFilter('id', array('in' => $sdIds));
		
		$this->updateIpAddresses($sdCollection, false);
	}
	
	/*
	 *@ Description: Process multiple ip address to block or un-block
	 *@ Param: social discount collection
	 *@ Param2: block or un-block (bolean)
	 */
	public function updateIpAddresses($collection, $block = true) {
		if($collection->count() > 0) {
			$blockedIps = Mage::getStoreConfig('netsol_sd/sd_coupons/sd_block_ip');
			$blockedIps = explode(',', $blockedIps);
			
			if($block) {
				foreach($collection as $sd)
					$blockedIps[] = $sd->getIpAddress();
			} else {
				foreach($collection as $sd)
					unset($blockedIps[array_search($sd->getIpAddress(), $blockedIps)]);
			}
			
			$blockedIps = array_unique(array_filter($blockedIps));
			try {
				$configModel = Mage::getModel('core/config')->saveConfig('netsol_sd/sd_coupons/sd_block_ip', implode(',', $blockedIps));
				Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Ip addresses have been updated successfully.'));
			} catch(Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
		}
		
		$this->_redirect('*/*/list');
	}
	
	public function reportAction() {
        $this->_initAction()
			 ->_title($this->__('Social Discount'))
			 ->_setActiveMenu('netsol_sd/sd_analytic_report')
			 ->_addContent($this->getLayout()->createBlock('netsol_sd/adminhtml_analyticreport'));
			 
		$this->renderLayout();
    }
}
