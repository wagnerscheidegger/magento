<?php
class Magehit_Customerredirect_Model_Observer_Customer extends Varien_Event_Observer
{
    /*method for Login Customerredirect*/
    
   public function customerLogin(Varien_Event_Observer $observer)
   {    
           if (Mage::helper('customerredirect')->isEnabled() && !Mage::getSingleton("core/session")->getRedirectregister()){    
               $lasturl = Mage::getSingleton('core/session')->getLastUrl();
             if (strpos(Mage::helper('core/http')->getHttpReferer(), 'checkout') === false){
                 if (! preg_match("#customer/account/create#", $lasturl) && Mage::helper('customerredirect')->isoptionEnabled('login_customerredirect')) {
                          if($this->_CustomerGroup()) {
                           $_session = $this->_getSession();
                           $_session->setBeforeAuthUrl(Mage::helper('customerredirect')->setRedirectOnLogin());
                         }
                }
            }
         }
        Mage::getSingleton("core/session")->setRedirectregister(false);
   }
   
   /*method for SignUp Customerredirect*/
   public function customerRegistration(Varien_Event_Observer $observer)
   {
    Mage::getSingleton("core/session")->setRedirectregister(true);
       if (Mage::helper('customerredirect')->isEnabled() && Mage::helper('customerredirect')->isoptionEnabled('registration_customerredirect')) {
               $_session = $this->_getSession();
               $_session->setBeforeAuthUrl(Mage::helper('customerredirect')->setRedirectOnSignup());
       }
   }
   
   /*method for Logout Customerredirect*/
   public function customerLogout(Varien_Event_Observer $observer)
   {
       if (Mage::helper('customerredirect')->isEnabled() && Mage::helper('customerredirect')->isoptionEnabled('logout_customerredirect')) {
           if($this->_CustomerGroup()) {
               $observer->getControllerAction()
               ->setRedirectWithCookieCheck(Mage::helper('customerredirect')->setRedirectOnLogout());
           }
       }
   }
   
   /*check the customer group*/
   protected function _CustomerGroup()
   {
       $customer = $this->_getSession()->getCustomer();
       $group_id = Mage::helper('customerredirect')->getConfigValue('group');
       if($customer) {
           if($customer->getGroupId() == $group_id) {
               return TRUE;
           }
       }

       /*redirect for all General/Retailer and Wholeseller*/
    if($group_id == ''){
        return true;    
    }    
   }
   
   protected function _getSession()
   {
       return Mage::getSingleton('customer/session');
   }
   
   
   
   
}