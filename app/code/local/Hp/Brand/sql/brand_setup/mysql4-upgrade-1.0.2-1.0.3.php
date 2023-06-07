<?php
$installer = new Mage_Eav_Model_Entity_Setup('core_setup');
$installer->startSetup();
$installer->run("
--
ALTER TABLE `{$this->getTable('brand')}` ADD `sort_order` int(11) NOT NULL AFTER `banner_image`;
ALTER TABLE `{$this->getTable('brand')}` ADD `status` tinyint(4) NOT NULL AFTER `sort_order`;
");
$installer->endSetup();

