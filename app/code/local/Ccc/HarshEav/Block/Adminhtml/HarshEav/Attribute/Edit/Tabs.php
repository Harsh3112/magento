<?php

class Ccc_HarshEav_Block_Adminhtml_HarshEav_Attribute_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('harsheav_attribute_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('harsheav')->__('Attribute Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('main', array(
            'label'     => Mage::helper('harsheav')->__('Properties'),
            'title'     => Mage::helper('harsheav')->__('Properties'),
            'content'   => $this->getLayout()->createBlock('harsheav/adminhtml_harsheav_attribute_edit_tab_main')->toHtml(),
            'active'    => true
        ));

        $model = Mage::registry('entity_attribute');

        $this->addTab('labels', array(
            'label'     => Mage::helper('harsheav')->__('Manage Label / Options'),
            'title'     => Mage::helper('harsheav')->__('Manage Label / Options'),
            'content'   => $this->getLayout()->createBlock('harsheav/adminhtml_harsheav_attribute_edit_tab_options')->toHtml(),
        ));
        
        return parent::_beforeToHtml();
    }
}