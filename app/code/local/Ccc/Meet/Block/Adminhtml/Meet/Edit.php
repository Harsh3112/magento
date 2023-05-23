<?php
class Ccc_Meet_Block_Adminhtml_Meet_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{	
	public function __construct()
	{		
		$this->_blockGroup = 'meet';
        $this->_controller = 'adminhtml_meet';
        $this->_headerText = 'Add Meet';
        parent::__construct();
        if(!$this->getRequest()->getParam('set') && !$this->getRequest()->getParam('id'))
		{
			$this->_removeButton('save');
		} 
	}
}