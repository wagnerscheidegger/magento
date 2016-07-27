<?php

class Bricks_Youtube_Block_Adminhtml_Youtubesettings_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    public function _construct()
    {
        parent::_construct();
    }
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
                'id' => 'edit_form',
                'action' => $this->getUrl('*/*/update', array('id' => $this->getRequest()->getParam('id'))),
                'method' => 'post'
            )
        );

        $form->setUseContainer(true);
        $this->setForm($form);
        $model_setings = Mage::getModel('youtube/youtubesettings');
        $fieldset = $form->addFieldset('font_settings', array('legend' => 'Settings'));
        
        $model = Mage::getModel('youtube/youtubesettings')->load(1);
        $user_name = '';
        $featured_video_id = '';
        $shortcode='';
        $api_key='';
        if($model)
        {
            // print_r($model->getData());exit;
            $user_name = $model->getUserName();
            $featured_video_id = $model->getFeaturedVideo();
            $shortcode = $model->getShortcode();
            $api_key = $model->getApiKey();
        }
        $fieldset->addField('user_name', 'text', array(
            'label' => 'Youtube Username',
            'name' => 'user_name',
            'required' => true,
            'value' =>$user_name
        ));


        $fieldset->addField('featured_video', 'text', array(
            'label' => 'Featured Video',
            'name' => 'featured_video',
            // 'required' => true,
            'value' =>$featured_video_id
        ));

        $fieldset->addField('shortcode', 'label', array(
            'label' => 'Shortcode to use in CMS page',
            'name' => 'shortcode',
            'value' =>'{{block type="core/template" template="youtube/index.phtml" block_id="gallery"}}'
            // 'required' => true,
        ));

        $fieldset->addField('api_key', 'text', array(
            'label' => 'API Key',
            'name' => 'api_key',
            'required' => true,
            'value' =>$api_key
        ));
        return parent::_prepareForm();
    }
}