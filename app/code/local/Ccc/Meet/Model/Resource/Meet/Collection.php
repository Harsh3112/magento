<?php
class Ccc_Meet_Model_Resource_Meet_Collection extends Mage_Catalog_Model_Resource_Collection_Abstract
{
	public function __construct()
	{
		$this->setEntity('meet');
		parent::__construct();	
	}
}