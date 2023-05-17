<?php

$installer = $this;
$installer->startSetup();
 
/*
 * Create all entity tables
 */
$installer->createEntityTables(
    $this->getTable('sample/sample_entity')
);
 
/*
 * Add Entity type
 */
$installer->addEntityType('sample_sample',Array(
    'entity_model'          =>'sample/sample',
    'attribute_model'       =>'',
    'table'                 =>'sample/sample_entity',
    'increment_model'       =>'',
    'increment_per_store'   =>'0'
));
 
$installer->installEntities();
 
$installer->endSetup();



