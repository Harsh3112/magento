<?php  
/**
 * 
 */
class Ccc_Category_Model_Mysql4_Category_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	protected function _construct()
	{
		$this->_init('category/category');
	}
}

?>