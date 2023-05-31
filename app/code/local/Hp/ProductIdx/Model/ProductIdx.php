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

    public function updateCollection($data)
    {
        try {
            echo "<pre>";
            $attributeCode = 'collection';
            $attribute = Mage::getModel('catalog/resource_eav_attribute')->loadByCode('catalog_product', $attributeCode);

            $options = $attribute->getSource()->getAllOptions();
            $existOption = array_filter(array_column($options,'label'));

            $newOptions = array_diff($data, $existOption);
            if($newOptions){
                $option['attribute_id'] = $attribute->getId();
                foreach ($newOptions as $key => $value) {
                    $option['value'] = array(0 => array($value));
                    $option['lable'] = $value;
                    $setup = new Mage_Eav_Model_Entity_Setup('core_setup');
                    $setup->addAttributeOption($option);
                }
            }
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError('Error:'.$e);
        }
    }

}
