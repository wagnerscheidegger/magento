<?php
class Netsol_SocialDiscount_Block_Adminhtml_Report_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct() {
        parent::__construct();
        $this->setId('social_discount_grid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        //$this->setUseAjax(true);
    }
 
    protected function _prepareCollection() {
		//$productNameAttrId = Mage::getModel('eav/entity_attribute')->loadByCode('4', 'name')->getAttributeId();
		$productNameAttrId = Mage::getResourceModel('eav/entity_attribute')->getIdByCode('catalog_product', 'name');
		
        $collection = Mage::getModel('netsol_sd/socialdiscount')->getCollection();
        $collection->getSelect()
				   ->joinLeft(
						array('cpev' => 'catalog_product_entity_varchar'), 
						'cpev.entity_id = main_table.product_id AND cpev.attribute_id = '.$productNameAttrId, 
						array('product_name' => 'value')
				   );

        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }
 
    protected function _prepareColumns() {
        $helper = Mage::helper('netsol_sd');
 
		$this->addColumn('id', array(
            'header' => $helper->__('ID'),
            'index'  => 'id',
            'width'  => '100'
        ));
		$this->addColumn('product_name', array(
            'header' => $helper->__('Product'),
            'index'  => 'product_name',
            'filter_condition_callback' => array($this, 'filterByProductCallback')
        ));
		/* $this->addColumn('media', array(
            'header' => $helper->__('Social Media'),
            'index'  => 'media',
            'type'   => 'options',
            'options'=> array(
				'Facebook' => 'Facebook',
				//'Twitter' => 'Twitter'
            )
        )); */
		$this->addColumn('ip_address', array(
            'header' => $helper->__('User IP'),
            'index'  => 'ip_address'
        ));
		$this->addColumn('ip_status', array(
            'header' => $helper->__('IP Status'),
            'index'  => 'ip_status',
            'filter' => false,
            'sortable' => false,
            'frame_callback' => array($this, 'ipStatusFrameCallback')
        ));
		$this->addColumn('coupon_code', array(
            'header' => $helper->__('Coupon Code'),
            'index'  => 'coupon_code'
        ));
		$this->addColumn('creation_date', array(
            'header' => $helper->__('Created On'),
            'index'  => 'creation_date',
            'type'   => 'datetime'
        ));
		$this->addColumn('coupon_used', array(
            'header' => $helper->__('Coupon Used'),
            'index'  => 'coupon_used',
            'type'   => 'options',
            'options'=> array(
				'1' => 'Yes',
				'0' => 'No'
            )
        ));
		$this->addColumn('coupon_used_date', array(
            'header' => $helper->__('Coupon Used On'),
            'index'  => 'coupon_used_date',
            'type'   => 'datetime'
        ));
        
        $this->addExportType('*/*/exportInchooCsv', $helper->__('CSV'));
        $this->addExportType('*/*/exportInchooExcel', $helper->__('Excel XML'));
 
        return parent::_prepareColumns();
    }
    
    protected function _prepareMassaction() {
		$this->setMassactionIdField('id');
		$this->getMassactionBlock()->setFormFieldName('sd_id');
		 
		$this->getMassactionBlock()->addItem('sd_block_ip', array(
			'label' => Mage::helper('tax')->__("Block IP's"),
			'url' => $this->getUrl('*/*/massBlockIPs', array('' => '')),
			'confirm' => Mage::helper('netsol_sd')->__('Are you sure?')
		));
		$this->getMassactionBlock()->addItem('sd_unblock_ip', array(
			'label' => Mage::helper('tax')->__("Unblock IP's"),
			'url' => $this->getUrl('*/*/massUnblockIPs', array('' => '')),
			'confirm' => Mage::helper('netsol_sd')->__('Are you sure?')
		));
		 
		return $this;
	}
 
    public function getGridUrl() {
        return false;
    }
    
    public function ipStatusFrameCallback($value, $row, $column, $isExport) {
		$blockedIps = Mage::getStoreConfig('netsol_sd/sd_coupons/sd_block_ip');
		$blockedIps = explode(',', $blockedIps);
		$html = 'Open';
		
		if(in_array($row->getIpAddress(), $blockedIps))
			$html = 'Blocked';
			
		return $html;
	}
	
	public function filterByProductCallback($collection, $column) {
		$value = $column->getFilter()->getValue();
		if($value == null)
			return;
			
		$productCollection = Mage::getModel('catalog/product')
								->getCollection()
								->addAttributeToFilter('name', array('like' => '%'.$value.'%'));
		$productCollection->getSelect()->reset(Zend_Db_Select::COLUMNS);
        $productCollection->getSelect()->columns('entity_id');
        $productCollection->getSelect()->distinct(true);
        
        $productIds = $productCollection->getColumnValues('entity_id');
        $collection->addFieldToFilter('product_id', array('in' => $productIds));
	}
}
