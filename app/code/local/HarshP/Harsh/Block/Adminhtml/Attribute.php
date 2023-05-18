<?php
class HarshP_Harsh_Block_Adminhtml_Attribute extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_controller = 'adminhtml_attribute';
        $this->_blockGroup = 'harsh';
        $this->_headerText = Mage::helper('harsh')->__('Manage Attributes');
        $this->_addButtonLabel = Mage::helper('harsh')->__('Add New Attribute');
        parent::__construct();
    }

}
