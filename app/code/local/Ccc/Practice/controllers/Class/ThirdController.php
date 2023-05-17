// How to insert a single row into a table using a row object ?

<?php
/**
 * 
 */
class Ccc_Practice_Class_ThirdController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{

        $product = Mage::getModel('product/product');

        $data = array(
            'name' => 'test',
            'sku' => '6ty',
            'cost' => '1000',
            'price' => '1200'
        );
        $row = $product->setData($data);

        if ($row->save()) {
            echo "1 row inserted successfully.";
        }
	}
}
