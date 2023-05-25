<?php

class Ccc_HarshEav_Model_Attribute extends Mage_Eav_Model_Attribute
{
    const MODULE_NAME = 'Ccc_HarshEav';
    protected $_eventObject = 'attribute';

    protected function _construct()
    {
        $this->_init('harsheav/attribute');
    }
}