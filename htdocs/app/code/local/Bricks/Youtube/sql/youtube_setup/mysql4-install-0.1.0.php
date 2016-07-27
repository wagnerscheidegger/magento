<?php
$installer = $this;
$installer->startSetup();

$installer->run("
DROP TABLE IF EXISTS `{$installer->getTable('youtubesettings')}`;
CREATE TABLE IF NOT EXISTS `{$installer->getTable('youtubesettings')}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` text NOT NULL,
  `featured_video` text NOT NULL,
  `shortcode` text NOT NULL,
  `api_key` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");
$installer->endSetup(); 