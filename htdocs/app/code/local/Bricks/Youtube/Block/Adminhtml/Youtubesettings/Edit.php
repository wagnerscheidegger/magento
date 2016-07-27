<?php

class Bricks_Youtube_Block_Adminhtml_Youtubesettings_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_objectId = 'id';
        $this->_blockGroup = 'youtube';
        $this->_controller = 'adminhtml_youtubesettings';

        $this->_updateButton('save', 'label', Mage::helper('youtube')->__('Update Options'));
        // $this->_updateButton('delete', 'label', Mage::helper('youtube')->__('Delete Option'));

    }
    public function getHeaderText()
    {
        return Mage::helper('youtube')->__('Youtube Gallery Options');
    }
}