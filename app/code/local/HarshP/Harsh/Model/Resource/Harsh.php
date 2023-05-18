<?php  
/**
 * 
 */
class HarshP_Harsh_Model_Resource_Harsh extends Mage_Core_Model_Resource_Db_Abstract
{
	protected function _construct()
	{
		$this->_init('harsh/harsh', 'entity_id');
	}
}

?>