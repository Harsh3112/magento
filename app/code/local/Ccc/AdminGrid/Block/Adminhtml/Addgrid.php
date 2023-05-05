<?php  
/**
 * 
 */
class Ccc_AdminGrid_Block_Adminhtml_Addgrid extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_blockGroup = 'admingrid';
		$this->_controller = 'adminhtml_addgrid';
		$this->_headerText = $this->__('grid');

		parent::__construct();
	}
}

?>