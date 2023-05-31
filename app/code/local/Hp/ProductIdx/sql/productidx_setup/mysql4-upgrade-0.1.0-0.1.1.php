<?php

$installer = $this;
/*  @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();

$installer->run("
ALTER TABLE `import_product_idx` ADD FOREIGN KEY (`brand_id`) REFERENCES `brand`(`brand_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `import_product_idx` CHANGE `brand_id` `brand_id` INT(11) NULL DEFAULT NULL;

ALTER TABLE `import_product_idx` CHANGE `collection_id` `collection_id` INT(11) NULL DEFAULT NULL;


");

$installer->endSetup();
