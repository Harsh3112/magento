<?php

class HarshP_Harsh_Model_Resource_Harsh_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('harsh/harsh');
    }

}