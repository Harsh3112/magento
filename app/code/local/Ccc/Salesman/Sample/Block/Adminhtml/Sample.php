<?php
class Ccc_Sample_Block_Adminhtml_Sample extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_controller = 'adminhtml_sample';
        $this->_blockGroup = 'sample';
        $this->_headerText = Mage::helper('sample')->__('Manage Samples');
        $this->_addButtonLabel = Mage::helper('sample')->__('Add New Sample');
        parent::__construct();
    }
}
