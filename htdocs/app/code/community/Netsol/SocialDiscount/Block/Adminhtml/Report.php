<?php
class Netsol_SocialDiscount_Block_Adminhtml_Report extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct() {
        $this->_blockGroup = 'netsol_sd';
        $this->_controller = 'adminhtml_report';
        $this->_headerText = Mage::helper('netsol_sd')->__('Social Discount');
 
        parent::__construct();
        $this->_removeButton('add');
    }
}
