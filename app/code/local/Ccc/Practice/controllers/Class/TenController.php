// Check all methods available in our row class and find out how it works in Magento ?

<?php
/**
 * 
 */
class Ccc_Practice_Class_TenController extends Mage_Core_Controller_Front_Action
{

	public function indexAction()
	{
        echo "<pre>";
        echo 'classes are';
        echo '
            Mage_Core_Block_Abstract
            Mage_Core_Block_Template
            Mage_Core_Block_Text
            Mage_Core_Model_Layout
            Mage_Core_Controller_Varien_Action'
        ;
	}
}
