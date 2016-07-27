<?php
class Bricks_Youtube_Block_Adminhtml_Youtubesettings extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_youtubesettings';
        $this->_blockGroup = 'youtube';
        $this->_headerText = Mage::helper('youtube')->__('Youtube Videos Gallery Options');
        parent::__construct();
    }
}