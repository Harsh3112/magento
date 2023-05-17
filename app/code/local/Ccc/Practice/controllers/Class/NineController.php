// Check all methods available in our row class and find out how it works in Magento ?

<?php
/**
 * 
 */
class Ccc_Practice_Class_NineController extends Mage_Core_Controller_Front_Action
{

	public function indexAction()
	{
        $row = Mage::getModel('product/resource_product');
        echo "<pre>";
        // print_r($row);die;
        print_r(get_class_methods($row));
	}
}
