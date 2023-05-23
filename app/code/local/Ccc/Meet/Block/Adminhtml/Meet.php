<?php 
class Ccc_Meet_Block_Adminhtml_Meet extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_blockGroup = 'meet';
		$this->_controller = 'adminhtml_meet';
		$this->_headerText = $this->__('Meet Grid');
		$this->_addButtonLabel = $this->__('Add Meet');
		parent::__construct();
	}
}