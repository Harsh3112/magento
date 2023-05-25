<?php
class Ccc_HarshEav_Model_Resource_HarshEav_Collection extends Mage_Catalog_Model_Resource_Collection_Abstract
{
	public function __construct()
	{
		$this->setEntity('harsheav');
		parent::__construct();	
	}
}