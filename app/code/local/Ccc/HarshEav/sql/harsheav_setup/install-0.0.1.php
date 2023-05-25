<?php 

$this->startSetup();

$this->addEntityType(Ccc_HarshEav_Model_Resource_HarshEav::ENTITY,[
	'entity_model'=>'harsheav/harsheav',
	'attribute_model'=>'harsheav/attribute',
	'table'=>'harsheav/harsheav',
	'increment_per_store'=> '0',
	'additional_attribute_table' => 'harsheav/eav_attribute',
	'entity_attribute_collection' => 'harsheav/harsheav_attribute_collection'
]);

$this->createEntityTables('harsheav');
$this->installEntities();

$default_attribute_set_id = Mage::getModel('eav/entity_setup', 'core_setup')
    						->getAttributeSetId('harsheav', 'Default');

$this->run("UPDATE `eav_entity_type` SET `default_attribute_set_id` = {$default_attribute_set_id} WHERE `entity_type_code` = 'harsheav'");

$this->endSetup();