<?php

class Ccc_Vendor_Model_Resource_Address_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Define resource model
     *
     */
    protected function _construct()
    {
        $this->_init('vendor/address');
    }

}