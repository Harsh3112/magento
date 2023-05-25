<?php 
class Ccc_HarshEav_Model_Resource_HarshEav extends Mage_Eav_Model_Entity_Abstract
{
	const ENTITY = 'harsheav';
	public function __construct()
	{
		$this->setType(self::ENTITY)
			 ->setConnection('core_read', 'core_write');
	   parent::__construct();
    }
}