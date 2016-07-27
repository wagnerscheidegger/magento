<?php
/**
 * PagSeguro Transparente Magento
 * Notification Controller responsible for receive order update notifications from PagSeguro
 * See how to setup notification url on module's official website
 *
 * @category    RicardoMartins
 * @package     RicardoMartins_PagSeguro
 * @author      Ricardo Martins
 * @copyright   Copyright (c) 2015 Ricardo Martins (http://r-martins.github.io/PagSeguro-Magento-Transparente/)
 * @license     https://opensource.org/licenses/MIT MIT License
 */
class RicardoMartins_PagSeguro_NotificationController extends Mage_Core_Controller_Front_Action
{
    /**
     * Receive and process pagseguro notifications.
     * Don' forget to setup your notification url as http://yourstore.com/index.php/pagseguro/notification
     */
    public function indexAction()
    {
        $helper = Mage::helper('ricardomartins_pagseguro');
        if ($helper->isSandbox()) {
            $this->getResponse()->setHeader('access-control-allow-origin', 'https://sandbox.pagseguro.uol.com.br');
        }
        /** @var RicardoMartins_PagSeguro_Model_Abstract $model */
        Mage::helper('ricardomartins_pagseguro')
            ->writeLog(
                'Notificação recebida do pagseguro com os parâmetros:'
                . var_export($this->getRequest()->getParams(), true)
            );
        $model =  Mage::getModel('ricardomartins_pagseguro/abstract');
        $response = $model->getNotificationStatus($this->getRequest()->getPost('notificationCode'));
        if (false === $response) {
            Mage::throwException('Falha ao processar retorno XML do PagSeguro.');
        }
        $model->proccessNotificatonResult($response);


    }
}