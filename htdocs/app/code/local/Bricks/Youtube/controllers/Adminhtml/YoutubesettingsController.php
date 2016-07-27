<?php
class Bricks_Youtube_Adminhtml_YoutubesettingsController extends Mage_Adminhtml_Controller_Action
{
	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('youtube/items')
			->_addBreadcrumb(Mage::helper('adminhtml')
			->__('Items Manager'), Mage::helper('adminhtml')
			->__('Item Manager'));
		
		return $this;
	}
	public function indexAction() {
        $this->_initAction()->renderLayout();
	}

	public function editAction() {
		$this->loadLayout();
	 	$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

		$this->_addContent($this->getLayout()->createBlock('youtube/adminhtml_youtubesettings_edit'));

		$this->renderLayout();
	}
	public function newAction() {
        $this->_forward('edit');
	}
	public function updateAction() {
		$post = $this->getRequest()->getPost();
		// echo "<pre>";
		// print_r($post);
		// exit;
		unset($post['form_key']);
		$model = Mage::getModel('youtube/youtubesettings')->load(1);
		if($model)
		{
			$id = $model->getId();
			$model->setData($post);
			$model->setId($id);
			$model->save();
		}else
		{
			$model->setData($post);
        	$model->save();
        }
		Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Successfully updated'));
		$this->_redirect('*/*/new');
	}
}
