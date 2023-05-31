<?php

class Hp_ProductIdx_Model_ProductIdx extends Mage_Core_Model_Abstract
{
    function __construct()
    {
        $this->_init('productidx/productidx');
    }

    public function updateBrandTable($dataArray)
    {
        $brandCollection = Mage::getModel('brand/brand')->getCollection();
        $brandNames = $brandCollection->getConnection()
            ->fetchPairs($brandCollection->getSelect()->columns(['brand_id','name']));

        $newBrands = array_diff($dataArray, $brandNames);

        foreach ($newBrands as $name) {
            $data[] = ['name'=>$name,'created_time'=>now()];
        }

        if($data){
            $resource = Mage::getSingleton('core/resource');
            $tableName = $resource->getTableName('brand');
            $writeConnection = $resource->getConnection('core_write');
            $writeConnection->insertMultiple($tableName, $data);
        }

        $newBrandNames = $brandCollection->getConnection()
            ->fetchPairs($brandCollection->getSelect()->columns(['brand_id','name']));
        return $newBrandNames;    
    }
}
