<?php

class Hp_ProductIdx_Model_Resource_ProductIdx_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('productidx/productidx');
    }
}