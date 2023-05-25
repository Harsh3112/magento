<?php 
class Ccc_HarshEav_Block_Adminhtml_HarshEav extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_blockGroup = 'harsheav';
		$this->_controller = 'adminhtml_harsheav';
		$this->_headerText = $this->__('HarshEav Grid');
		$this->_addButtonLabel = $this->__('Add HarshEav');
		parent::__construct();
	}
}