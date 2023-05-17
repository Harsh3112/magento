// Check all methods available in our adapter class and find out how it works in Magento ?

<?php
/**
 * 
 */
class Ccc_Practice_Class_SevenController extends Mage_Core_Controller_Front_Action
{

	public function indexAction()
	{
        $adapter = Mage::getSingleton('core/resource')->getConnection('core_read');
        echo "<pre>";
        // print_r($adapter);die;
        print_r(get_class_methods($adapter));

        // prepare a SELECT query
        $sql = "SELECT * FROM `product`";
        $bind = array('complete');
        $products = $adapter->fetchAll($sql, $bind);
        print_r($products);

        // prepare an INSERT query
        // $table = "my_custom_table";
        // $data = array('field1' => 'value1', 'field2' => 'value2');
        // $adapter->insert($table, $data);
	}
}
