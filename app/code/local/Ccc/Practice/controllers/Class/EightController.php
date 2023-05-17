// Check all methods available in our resource class and find out how it works in Magento ?

<?php
/**
 * 
 */
class Ccc_Practice_Class_EightController extends Mage_Core_Controller_Front_Action
{

	public function indexAction()
	{
        $resource = Mage::getSingleton('core/resource');
        echo "<pre>";
        // print_r($adapter);
        print_r(get_class_methods($resource));
	}
}
