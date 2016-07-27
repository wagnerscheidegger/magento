<?php
class Netsol_SocialDiscount_Block_Adminhtml_Report_Analytic_Grid extends Mage_Adminhtml_Block_Report_Grid
{
 
    public function __construct()
    {
        parent::__construct();
        $this->setId('sd_analytic_report');
    }
 
    protected function _prepareCollection()
    {
        parent::_prepareCollection();
        $this->getCollection()->initReport('netsol_sd/analyticreport_collection');
 
    }
 
    protected function _prepareColumns() {
        $this->addColumn('product_name', array(
            'header' => Mage::helper('reports')->__('Product Name'),
            'index' => 'product_name',
            'sortable' => false,
            'totals_label'  => Mage::helper('adminhtml')->__('Total'),
        ));
		$this->addColumn('total_unique_ip', array(
			'header' => Mage::helper('reports')->__("Unique IP's"),
			'index' => 'total_unique_ip',
			'sortable' => false,
		));
		$this->addColumn('total_coupon_code', array(
			'header' => Mage::helper('reports')->__('Total Coupons'),
			'index' => 'total_coupon_code',
			'sortable' => false,
			'total' => 'sum',
		));
		$this->addColumn('total_used_coupon', array(
			'header' => Mage::helper('reports')->__('Used Coupon'),
			'index' => 'total_used_coupon',
			'sortable' => false,
			'total' => 'sum',
		));

		$this->addExportType('*/*/exportSimpleCsv', Mage::helper('reports')->__('CSV'));

		return parent::_prepareColumns();
    }
 
}
