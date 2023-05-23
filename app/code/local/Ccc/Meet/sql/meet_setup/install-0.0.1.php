<?php 

$this->startSetup();

$this->addEntityType(Ccc_Meet_Model_Resource_Meet::ENTITY,[
	'entity_model'=>'meet/meet',
	'attribute_model'=>'meet/attribute',
	'table'=>'meet/meet',
	'increment_per_store'=> '0',
	'additional_attribute_table' => 'meet/eav_attribute',
	'entity_attribute_collection' => 'meet/meet_attribute_collection'
]);

$this->createEntityTables('meet');
$this->installEntities();

$default_attribute_set_id = Mage::getModel('eav/entity_setup', 'core_setup')
    						->getAttributeSetId('meet', 'Default');

$this->run("UPDATE `eav_entity_type` SET `default_attribute_set_id` = {$default_attribute_set_id} WHERE `entity_type_code` = 'meet'");

$this->endSetup();