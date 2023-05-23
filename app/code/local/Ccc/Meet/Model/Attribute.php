<?php

class Ccc_Meet_Model_Attribute extends Mage_Eav_Model_Attribute
{
    const MODULE_NAME = 'Ccc_Meet';
    protected $_eventObject = 'attribute';

    protected function _construct()
    {
        $this->_init('meet/attribute');
    }
}