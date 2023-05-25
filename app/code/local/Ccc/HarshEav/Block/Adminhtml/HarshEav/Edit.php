<?php
class Ccc_HarshEav_Block_Adminhtml_HarshEav_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{	
	public function __construct()
	{		
		$this->_blockGroup = 'harsheav';
        $this->_controller = 'adminhtml_harsheav';
        $this->_headerText = 'Add HarshEav';
        parent::__construct();
        if(!$this->getRequest()->getParam('set') && !$this->getRequest()->getParam('id'))
		{
			$this->_removeButton('save');
		} 
	}
}