<?php

class Ccc_Meet_Block_Adminhtml_Meet_Attribute_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('meet_attribute_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('meet')->__('Attribute Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('main', array(
            'label'     => Mage::helper('meet')->__('Properties'),
            'title'     => Mage::helper('meet')->__('Properties'),
            'content'   => $this->getLayout()->createBlock('meet/adminhtml_meet_attribute_edit_tab_main')->toHtml(),
            'active'    => true
        ));

        $model = Mage::registry('entity_attribute');

        $this->addTab('labels', array(
            'label'     => Mage::helper('meet')->__('Manage Label / Options'),
            'title'     => Mage::helper('meet')->__('Manage Label / Options'),
            'content'   => $this->getLayout()->createBlock('meet/adminhtml_meet_attribute_edit_tab_options')->toHtml(),
        ));
        
        return parent::_beforeToHtml();
    }
}