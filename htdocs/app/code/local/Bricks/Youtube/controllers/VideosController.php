<?php
class Bricks_Youtube_VideosController extends Mage_Core_Controller_Front_Action
{
   public function indexAction()
	{
        $this->loadLayout();
        $block = $this->getLayout()->createBlock('youtube/videos') ->setTemplate('youtube/index.phtml');
		$this->getResponse()->setBody($block->toHtml());
        $this->renderLayout();
	}
	public function loadDataAction()
	{
        $this->loadLayout();
        $block = $this->getLayout()->createBlock('youtube/videos') ->setTemplate('youtube/response.phtml');
		$this->getResponse()->setBody($block->toHtml());
        $this->renderLayout();
	}
}