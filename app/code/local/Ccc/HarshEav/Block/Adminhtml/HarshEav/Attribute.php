<?php

class Ccc_HarshEav_Block_Adminhtml_HarshEav_Attribute extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_blockGroup = 'harsheav';
		$this->_controller = 'adminhtml_harsheav_attribute';
		$this->_headerText = Mage::helper('brand')->__('Manage Attributes');
        $this->_addButtonLabel = Mage::helper('brand')->__('Add New Attribute');
		parent::__construct();
	}
}