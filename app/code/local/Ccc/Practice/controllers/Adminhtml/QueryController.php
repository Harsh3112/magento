<?php

class Ccc_Practice_Adminhtml_QueryController extends Mage_Adminhtml_Controller_Action
{
    public function firstAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('practice');
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_first'));
        $this->renderLayout();
    }

    public function firstQueryAction()
    {
        // Retrieve the resource model
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');

        $tableName = $resource->getTableName('catalog/product');
    
        $attributeCodes = array(
            'name' => 'name', 
            'price' => 'price',
            'cost' => 'cost',
            'color' => 'color',
        );

        $attributeIds = array();
        foreach ($attributeCodes as $attributeCode => $columnName) {
            $attribute = Mage::getModel('eav/entity_attribute')->loadByCode('catalog_product', $attributeCode);
            if ($attribute && $attribute->getId()) {
                $attributeIds[$attributeCode] = $attribute->getId();
            }
        }


        $tableName = $resource->getTableName('catalog/product');
        $select = $readConnection->select()
            ->from(array('p' => $tableName), array(
                'sku' => 'p.sku',
            ))
            ->joinLeft(
                array('ov' => $resource->getTableName('catalog_product_entity_varchar')),
                'ov.entity_id = p.entity_id AND ov.attribute_id = ' . $attributeIds['name'],
                array('name' => 'ov.value')
            )
            ->joinLeft(
                array('a' => $resource->getTableName('catalog_product_entity_decimal')),
                'a.entity_id = p.entity_id AND a.attribute_id = ' . $attributeIds['price'],
                array('price' => 'a.value')
            )
            ->joinLeft(
                array('b' => $resource->getTableName('catalog_product_entity_decimal')),
                'b.entity_id = p.entity_id AND b.attribute_id = ' . $attributeIds['cost'],
                array('cost' => 'b.value')
            )
            ->joinLeft(
                array('c' => $resource->getTableName('catalog_product_entity_int')),
                'c.entity_id = p.entity_id AND c.attribute_id = ' . $attributeIds['color'],
                array('color' => 'c.value')
            );


        echo $select;

        // $results = $readConnection->fetchAll($select);

        // // Process the results
        // foreach ($results as $row) {
        //     $sku = $row['sku'];
        //     $productName = $row['name'];
        //     $cost = $row['cost'];
        //     $price = $row['price'];
        //     $color = $row['color'];

        //     // Print or process the retrieved data as desired
        //     echo "SKU: $sku, Name: $productName, Cost: $cost, Price: $price, Color: $color\n";
        // }
    }

    public function secondAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('practice');
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_second'));
        $this->renderLayout();
    }

    public function secondQueryAction()
    {
        $attributeOptions = [];

        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');

        $attributeOptionTable = $resource->getTableName('eav_attribute_option');
        $attributeTable = $resource->getTableName('eav_attribute');

        $select = $readConnection->select()
            ->from(
                array('ao' => $attributeOptionTable),
                array(
                    'attribute_id' => 'ao.attribute_id',
                    'option_id' => 'ao.option_id',
                    'option_name' => 'ov.value',
                )
            )
            ->joinLeft(
                array('ov' => $resource->getTableName('eav_attribute_option_value')),
                'ov.option_id = ao.option_id',
                array()
            )
            ->join(
                array('a' => $attributeTable),
                'a.attribute_id = ao.attribute_id',
                array('attribute_code' => 'a.attribute_code')
            );

        $queryResult = $readConnection->fetchAll($select);
        echo $select;die;

        // foreach ($queryResult as $row) {
        //     $attributeOptions[] = array(
        //         'attribute_id' => $row['attribute_id'],
        //         'attribute_code' => $row['attribute_code'],
        //         'option_id' => $row['option_id'],
        //         'option_name' => $row['option_name'],
        //     );
        // }

        // return $attributeOptions;
    }

    public function threeAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('practice');
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_three'));
        $this->renderLayout();
    }

    public function threeQueryAction()
    {
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');

        $attributeOptionTable = $resource->getTableName('eav_attribute_option');
        $attributeTable = $resource->getTableName('eav_attribute');

        $select = $readConnection->select()
            ->from(
                array('main_table' => $attributeTable),
                array(
                    'attribute_id' => 'main_table.attribute_id',
                    'attribute_code' => 'main_table.attribute_code',
                )
            )
            ->joinLeft(
                array('option_count_table' => $attributeOptionTable),
                'option_count_table.attribute_id = main_table.attribute_id',
                array(
                    'option_count' => 'COUNT(option_count_table.option_id)',
                )
            )
            ->group('main_table.attribute_id')
            ->having('COUNT(option_count_table.option_id) > 10', 1);

        echo '<br>'.$select;die;
    }

    public function fourAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('practice');
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_four'));
        $this->renderLayout();
    }

    public function fourQueryAction()
    {
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        echo $select = $readConnection->select()
            ->from(
                array('main_table'=> $resource->getTableName('catalog_product_entity')),
                array('entity_id','sku')
            )
            ->joinLeft(
                array('vc'=>$resource->getTableName('catalog_product_entity_varchar')),
                'vc.entity_id = main_table.entity_id AND vc.attribute_id = 87',
                array('image' => 'vc.value')
            )
            ->joinLeft(
                array('thumb'=>$resource->getTableName('catalog_product_entity_varchar')),
                'thumb.entity_id = main_table.entity_id AND thumb.attribute_id = 89',
                array('thumbnail' => 'thumb.value')
            )
            ->joinLeft(
                array('small'=>$resource->getTableName('catalog_product_entity_varchar')),
                'small.entity_id = main_table.entity_id AND small.attribute_id = 88',
                array('small' => 'small.value')
            );
    }

    public function fiveAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('practice');
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_five'));
        $this->renderLayout();
    }

    public function fiveQueryAction()
    {
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        $select = $readConnection->select()
            ->from(
                array('main_table'=> $resource->getTableName('catalog_product_entity')),
                array('entity_id','sku')
            )
            ->joinLeft(
                array('m'=>$resource->getTableName('catalog/product_attribute_media_gallery')),
                'm.entity_id = main_table.entity_id',
                array('image' => 'COUNT(m.value)')
            )
            ->group('main_table.entity_id');   

        echo $select;     
    }

    public function sixAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('practice');
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_six'));
        $this->renderLayout();
    }

    public function sixQueryAction()
    {
       $connection = Mage::getSingleton('core/resource')->getConnection('core_read');
        $customerOrderCountQuery = "SELECT c.entity_id AS customer_id, CONCAT(fname.value, ' ', lname.value) AS customer_name, c.email, COUNT(o.entity_id) AS order_count
            FROM customer_entity AS c
            LEFT JOIN customer_entity_varchar AS fname ON fname.entity_id = c.entity_id AND fname.attribute_id = (SELECT attribute_id FROM eav_attribute WHERE attribute_code = 'firstname' AND entity_type_id = 1)
            LEFT JOIN customer_entity_varchar AS lname ON lname.entity_id = c.entity_id AND lname.attribute_id = (SELECT attribute_id FROM eav_attribute WHERE attribute_code = 'lastname' AND entity_type_id = 1)
            LEFT JOIN sales_flat_order AS o ON o.customer_id = c.entity_id
            GROUP BY c.entity_id
            ORDER BY order_count DESC";

        $resultArray = array();

        echo $customerOrderCountQuery;die();

        $queryResult = $connection->fetchAll($customerOrderCountQuery);
        foreach ($queryResult as $row) {
            $customerId = $row['customer_id'];
            $customerName = $row['customer_name'];
            $customerEmail = $row['email'];
            $orderCount = $row['order_count'];

            $resultArray[] = array(
                'customer_id' => $customerId,
                'customer_name' => $customerName,
                'customer_email' => $customerEmail,
                'order_count' => $orderCount,
            );
        }

        print_r($resultArray);

    }

    public function sevenAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('practice');
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_seven'));
        $this->renderLayout();
    }

    public function sevenQueryAction()
    {
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        echo $select = $readConnection->select()
            ->from(
                array('main_table'=> $resource->getTableName('customer_entity')),
                array('entity_id','email')
            )
            ->joinLeft(
                array('e'=>$resource->getTableName('customer_entity_varchar')),
                'e.entity_id = main_table.entity_id AND e.attribute_id = 5',
                array('firstname' => 'e.value')
            )
            ->joinLeft(
                array('o' => $resource->getTableName('sales/order')),
                'o.customer_id = e.entity_id',
                array('order_count' => 'COUNT(o.entity_id)')
            )
            ->joinLeft(
                array('s' => Mage::getSingleton('core/resource')->getTableName('sales_order_status')),
                'o.status = s.status',
                array('order_status' => 's.label')
            )
            ->group('o.status')
            ->having('order_count > 0');
    }

    public function eightAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('practice');
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_eight'));
        $this->renderLayout();
    }

    public function eightQueryAction()
    {
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        $select = $readConnection->select()
            ->from(
                array('main_table'=> $resource->getTableName('catalog_product_entity')),
                array('entity_id','sku')
            )
            ->joinLeft(
                array('e'=>$resource->getTableName('sales_flat_order_item')),
                'e.product_id = main_table.entity_id',
                array('sold_quantity' => 'COALESCE(SUM(e.qty_ordered),0)')
            )
            ->group('main_table.entity_id');

        echo $select;
    }

    public function nineAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('practice');
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_nine'));
        $this->renderLayout();
    }

    public function nineQueryAction()
    {
        $connection = Mage::getSingleton('core/resource')->getConnection('core_read');
        $tablePrefix = Mage::getConfig()->getTablePrefix();

        $select = $connection->select()
            ->from(array('e' => 'catalog_product_entity'), array('entity_id AS product_id', 'sku'))
            ->join(
                array('a' => 'eav_attribute'),
                'e.entity_type_id = a.entity_type_id',
                array('attribute_id', 'attribute_code')
            )
            ->joinLeft(
                array('avc' => 'catalog_product_entity_varchar'),
                'e.entity_id = avc.entity_id AND avc.attribute_id = a.attribute_id',
                array()
            )
            ->joinLeft(
                array('avi' => 'catalog_product_entity_int'),
                'e.entity_id = avi.entity_id AND avi.attribute_id = a.attribute_id',
                array()
            )
            ->joinLeft(
                array('avd' => 'catalog_product_entity_decimal'),
                'e.entity_id = avd.entity_id AND avd.attribute_id = a.attribute_id',
                array()
            )
            ->joinLeft(
                array('avt' => 'catalog_product_entity_text'),
                'e.entity_id = avt.entity_id AND avt.attribute_id = a.attribute_id',
                array()
            )
            ->where('avc.value IS NULL AND avi.value IS NULL AND avd.value IS NULL AND avt.value IS NULL')
            ->where('a.is_user_defined = ?', 1); 

        echo $select;
    }

    public function tenAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('practice');
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_ten'));
        $this->renderLayout();
    }

    public function tenQueryAction()
    {
        $connection = Mage::getSingleton('core/resource')->getConnection('core_read');
        $tablePrefix = Mage::getConfig()->getTablePrefix();

        $select = $connection->select()
            ->from(array('e' => 'catalog_product_entity'), array('entity_id AS product_id', 'sku'))
            ->join(
                array('a' => 'eav_attribute'),
                'e.entity_type_id = a.entity_type_id',
                array('attribute_id', 'attribute_code')
            )
            ->joinLeft(
                array('avc' => 'catalog_product_entity_varchar'),
                'e.entity_id = avc.entity_id AND avc.attribute_id = a.attribute_id',
                array()
            )
            ->joinLeft(
                array('avi' => 'catalog_product_entity_int'),
                'e.entity_id = avi.entity_id AND avi.attribute_id = a.attribute_id',
                array()
            )
            ->joinLeft(
                array('avd' => 'catalog_product_entity_decimal'),
                'e.entity_id = avd.entity_id AND avd.attribute_id = a.attribute_id',
                array()
            )
            ->joinLeft(
                array('avt' => 'catalog_product_entity_text'),
                'e.entity_id = avt.entity_id AND avt.attribute_id = a.attribute_id',
                array()
            )
            ->where('avc.value is NOT NULL OR avi.value is NOT NULL OR avd.value is NOT NULL OR avt.value is NOT NULL')
            ->where('a.is_user_defined = ?', 1); 

        // echo $select;
        echo $select->columns(new Zend_Db_Expr("CONCAT_WS(' ', avi.value, avd.value, avc.value, avt.value) AS value"));
    }
}