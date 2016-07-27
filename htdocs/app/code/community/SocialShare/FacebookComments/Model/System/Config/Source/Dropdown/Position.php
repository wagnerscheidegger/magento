<?php

class SocialShare_FacebookComments_Model_System_Config_Source_Dropdown_Position
{
    public function toOptionArray()
    {
        return array(
            array( 'value' => 'prod_bottom', 'label' => 'Product Page Bottom' ),
			array( 'value' => 'dark', 'label' => 'Dark' ),
			
        );
    }
}
