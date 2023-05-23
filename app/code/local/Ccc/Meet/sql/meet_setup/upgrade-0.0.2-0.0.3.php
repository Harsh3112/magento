<?php 

$installer = $this;

$installer->startSetup();

$installer->getConnection()->addKey($installer->getTable('meet/meet_decimal'),
    'UNQ_MEET_DECIMAL', array('entity_id','attribute_id', 'store_id'), 'unique');

$installer->getConnection()->addKey($installer->getTable('meet/meet_datetime'),
    'UNQ_MEET_DECIMAL', array('entity_id','attribute_id', 'store_id'), 'unique');

$installer->getConnection()->addKey($installer->getTable('meet/meet_int'),
    'UNQ_MEET_DECIMAL', array('entity_id','attribute_id', 'store_id'), 'unique');

$installer->getConnection()->addKey($installer->getTable('meet/meet_text'),
    'UNQ_MEET_DECIMAL', array('entity_id','attribute_id', 'store_id'), 'unique');

$installer->endSetup();

?>