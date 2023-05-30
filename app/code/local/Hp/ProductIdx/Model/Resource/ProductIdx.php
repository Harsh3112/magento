<?php

class Hp_ProductIdx_Model_Resource_ProductIdx extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {  
        $this->_init('productidx/productidx', 'idx_id');
    }  
}