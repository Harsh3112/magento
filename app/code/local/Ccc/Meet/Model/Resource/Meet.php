<?php 
class Ccc_Meet_Model_Resource_Meet extends Mage_Eav_Model_Entity_Abstract
{
	const ENTITY = 'meet';
	public function __construct()
	{
		$this->setType(self::ENTITY)
			 ->setConnection('core_read', 'core_write');
	   parent::__construct();
    }
}