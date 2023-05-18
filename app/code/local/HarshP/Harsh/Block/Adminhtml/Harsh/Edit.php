<?php
class HarshP_Harsh_Block_Adminhtml_Harsh_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId = 'entity_id';
        $this->_controller = 'adminhtml_harsh';
        $this->_blockGroup = 'harsh';
        $this->_headerText = Mage::helper('harsh')->__('New');
        parent::__construct();

        $this->_updateButton('save', 'label', Mage::helper('harsh')->__('Save'));
        $this->_updateButton('delete', 'label', Mage::helper('harsh')->__('Delete'));

        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save and Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);
    }
}

