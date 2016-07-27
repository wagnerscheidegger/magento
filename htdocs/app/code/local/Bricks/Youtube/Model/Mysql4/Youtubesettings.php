<?php

class Bricks_Youtube_Model_Mysql4_Youtubesettings extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        $this->_init('youtube/youtubesettings', 'id');
    }
    
}