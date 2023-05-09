<?php  
/**
 * 
 */
class Ccc_Vendor_Model_Resource_Address extends Mage_Core_Model_Resource_Db_Abstract
{
	protected function _construct()
	{
		$this->_init('vendor/address', 'address_id');
	}
}

?>