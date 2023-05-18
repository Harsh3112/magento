<?php

$installer = $this;

$installer->startSetup();


$installer->run("
  
    DROP TABLE IF EXISTS {$this->getTable('harsh')}; 
    CREATE TABLE {$this->getTable('harsh')}  (
  `entity_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `age` varchar(255) NOT NULL,
  `created_time` datetime NOT NULL,
  `update_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

     ALTER TABLE {$this->getTable('harsh')}
  ADD PRIMARY KEY (`entity_id`);

  ALTER TABLE {$this->getTable('harsh')}
  MODIFY `entity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;
    ");

$table = $installer->getConnection()
    ->newTable($installer->getTable('harsh_entity'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Entity ID')
    ->addColumn('entity_type_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Entity Type ID')
    ->addColumn('attribute_set_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Attribute Set ID')
    ->addColumn('type_id', Varien_Db_Ddl_Table::TYPE_TEXT, 32, array(
        'nullable'  => false,
        'default'   => Mage_Catalog_Model_Product_Type::DEFAULT_TYPE,
        ), 'Type ID')
    ->addColumn('sku', Varien_Db_Ddl_Table::TYPE_TEXT, 64, array(
        ), 'SKU')
    ->addColumn('has_options', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'default'   => '0',
        ), 'Has Options')
    ->addColumn('required_options', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Required Options')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        ), 'Creation Time')
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        ), 'Update Time')
    ->addIndex($installer->getIdxName('nikunj_entity', array('entity_type_id')),
        array('entity_type_id'))
    ->addIndex($installer->getIdxName('nikunj_entity', array('attribute_set_id')),
        array('attribute_set_id'))
    ->addIndex($installer->getIdxName('nikunj_entity', array('sku')),
        array('sku'))
    ->addForeignKey(
        $installer->getFkName(
            'harsh_entity',
            'attribute_set_id',
            'eav/attribute_set',
            'attribute_set_id'
        ),
        'attribute_set_id', $installer->getTable('eav/attribute_set'), 'attribute_set_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($installer->getFkName('harsh_entity', 'entity_type_id', 'eav/entity_type', 'entity_type_id'),
        'entity_type_id', $installer->getTable('eav/entity_type'), 'entity_type_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Sample Table');
$installer->getConnection()->createTable($table);
$installer->endSetup();




