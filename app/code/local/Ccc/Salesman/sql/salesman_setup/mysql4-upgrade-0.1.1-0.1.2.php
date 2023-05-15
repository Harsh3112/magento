<?php


$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();

$installer->run("
--
CREATE TABLE {$installer->getTable('salesman_price')} (
  `entity_id` int(11) NOT NULL,
  `salesman_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `salesman_price` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


ALTER TABLE {$installer->getTable('salesman_price')}
  ADD PRIMARY KEY (`entity_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `salesman_id` (`salesman_id`);

  ALTER TABLE {$installer->getTable('salesman_price')}
  MODIFY `entity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE {$installer->getTable('salesman_price')}
  ADD CONSTRAINT `salesman_price_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `salesman_price_ibfk_2` FOREIGN KEY (`salesman_id`) REFERENCES `salesman` (`salesman_id`) ON DELETE CASCADE ON UPDATE CASCADE;
");

$installer->endSetup();
