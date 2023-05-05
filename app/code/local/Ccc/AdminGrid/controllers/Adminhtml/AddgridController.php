<?php  
/**
 * 
 */
class Ccc_AdminGrid_Adminhtml_AddgridController extends Mage_Adminhtml_Controller_Action
{
	protected function _isAllowed()
	{	
		return Mage::getSingleton('admin/session')->isAllowed('admingrid/addgrid');
	}

	public function indexAction()
	{
		$this->loadLayout();
		$this->_title($this->__('Admin Grid'));
		$this->renderLayout();
	}
}

?>