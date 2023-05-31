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

    // public function updateMainProduct($idxSkus)
    // {
    //     echo "<pre>";
    //     print_r($idxSkus);die;
    //     $productCollection = Mage::getModel('catalog/product')->getCollection();
    //     $productSku = array_column($productCollection->getData(), 'sku');
    //     $newProducts = array_diff($idxSkus, $productSku);
    //     $entityTypeId = Mage::getModel('catalog/product')->getResource()->getTypeId();

    //     if($newProducts){
    //         foreach ($newProducts as $sku) {
    //             $data[] = [
    //                 'sku'=>$sku,
    //                 'entity_type_id'=>$entityTypeId,
    //                 'attribute_set_id'=>4,
    //                 // 'visibility'=>4,
    //                 'created_at'=>now(),
    //             ];
    //         }

    //         if($data){
    //             $resource = Mage::getSingleton('core/resource');
    //             $tableName = $resource->getTableName('catalog_product_entity');
    //             $writeConnection = $resource->getConnection('core_write');
    //             $writeConnection->insertMultiple($tableName, $data);
    //         }
    //     }        

    //     return true;    
    // }


    public function updateMainProduct($idxProductData)
    {
        $product = Mage::getModel('catalog/product')->getCollection();

        $skuArray = $product->getData();
        $productSkus = array_column($skuArray, 'sku');

        $idxSkuData = array_column($idxProductData, 'sku');

        $newProducts = array_diff($idxSkuData, $productSkus);
        $entityTypeId = Mage::getModel('catalog/product')->getResource()->getTypeId();
        foreach ($idxProductData as $item) {
        $product = Mage::getModel('catalog/product');
            if(in_array($item['sku'], $newProducts))
            {
               $data = [
                'entity_type_id' => $entityTypeId,
                'attribute_set_id' => 4,
                'type_id' => 'simple',
                'sku' => $item['sku'],
                'has_options' => 0,
                'required_options' => 0,
                'name' => $item['name'],
                'price' => $item['price'],
                'status' => Mage_Catalog_Model_Product_Status::STATUS_ENABLED,
                'visibility' => '4',
                'tax_class_id' => '2',
                'weight' => '0.5',
                ];
                $product->setData($data);
                $product->setStockData(array(
                        'is_in_stock' => 1,
                        'qty' => $item['quantity'])
                    );
                $product->save();
            }
        }
    }

    public function checkBrands()
    {
        $datas = $this->getCollection()->getItems();

        foreach ($datas as $data) 
        {
            if ($data->brand_id != Null) {
                return true;
            }
            return false;
        }
    }

    public function checkCollection()
    {
        $datas = $this->getCollection()->getItems();

        foreach ($datas as $data) 
        {
            if ($data->collection_id != Null) {
                return true;
            }
            return false;
        }
    }

}
