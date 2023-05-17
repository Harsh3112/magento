// How to insert a single row into a table using a query string ?

<?php
/**
 * 
 */
class Ccc_Practice_Class_SecondController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{
        echo "<pre>";

        $resource = Mage::getSingleton('core/resource');
        $writeConnection = $resource->getConnection('core_write');
        $tableName = $resource->getTableName('product');

        $query = "INSERT INTO {$tableName} (`name`, `sku`, `cost`, `price`, `description`, `status`) VALUES ('iphone 14', 'i75', '99500', '120000', 'this is iphnoe description', '1')";
        
        if($writeConnection->query($query))
        {
            echo "inserted successfully";
        }
	}
}
