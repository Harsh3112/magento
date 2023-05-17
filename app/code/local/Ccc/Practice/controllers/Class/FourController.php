// How to insert multiple rows at a time when required to insert multiple rows into a table ? Check the function.

<?php
/**
 * 
 */
class Ccc_Practice_Class_FourController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{

        $connection = Mage::getSingleton('core/resource')->getConnection('core_write');
        $tableName = $connection->getTableName('product');

        $rows = array(
            array(
                'name' => 'test2',
                'sku' => 'e45',
                'cost' => '80',
                'price' => '100',
                'description' => 'this is test 2'
            ),
            array(
                'name' => 'test3',
                'sku' => 'e46',
                'cost' => '900',
                'price' => '1000',
                'description' => 'this is test 3'
            ),
        );

        if($connection->insertArray($tableName, array('name', 'sku', 'cost', 'price', 'description'), $rows))
        {
            echo "Mupltiple rows inserted successfully.";
        }
	}
}
