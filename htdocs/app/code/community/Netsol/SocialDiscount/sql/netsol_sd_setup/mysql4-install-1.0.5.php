<?php
$installer = $this;
$installer->startSetup();
$installer->run(
	"DROP TABLE IF EXISTS {$this->getTable('netsol_social_discount')};
	
	CREATE TABLE IF NOT EXISTS {$this->getTable('netsol_social_discount')} (
		`id` int(11) NOT NULL,
		`product_id` int(11) NOT NULL,
		`media` varchar(30) NOT NULL,
		`ip_address` varchar(50) NOT NULL,
		`coupon_code` varchar(30) NOT NULL,
		`coupon_used` enum('1','0') NOT NULL DEFAULT '0',
		`creation_date` datetime NOT NULL,
		`coupon_used_date` datetime NOT NULL,
		`magento_order_id` varchar(50) NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=latin1;
	
	ALTER TABLE {$this->getTable('netsol_social_discount')} ADD PRIMARY KEY (`id`);
	
	ALTER TABLE {$this->getTable('netsol_social_discount')} MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
	
	UPDATE `catalog_eav_attribute` SET `is_used_for_promo_rules` = 1 WHERE `attribute_id` = (SELECT `attribute_id` FROM `eav_attribute` WHERE `attribute_code` = 'sku' AND entity_type_id = (SELECT `entity_type_id` FROM `eav_entity_type` WHERE `entity_type_code` = 'catalog_product') LIMIT 1);"
);
$installer->endSetup();

$catalogSetup = new Mage_Eav_Model_Entity_Setup('core_setup');
$catalogSetup->startSetup();
$catalogSetup->addAttribute('catalog_product', 'enable_social_discount', array(
	'type' => 'int',
	'backend' => '',
	'frontend' => '',
	'label' => 'Enable Social Discount',
	'input' => 'boolean',
	'class' => '',
	'source' => 'adminhtml/system_config_source_yesno',
	'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
	'visible' => true,
	'required' => false,
	'user_defined' => true,
	'default' => 1,
	'searchable' => true,
	'filterable' => false,
	'comparable' => false,
	'visible_on_front' => false,
	'unique' => false,
	'group' => 'General',
	'attribute_set' => 'Default'
));
$catalogSetup->endSetup();

