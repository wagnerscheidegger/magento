<?php

class Bricks_Youtube_Model_Youtubesettings extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('youtube/youtubesettings', 'id');
    }
}