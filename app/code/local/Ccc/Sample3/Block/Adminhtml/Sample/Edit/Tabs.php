<?php

class Ccc_Sample_Block_Adminhtml_Sample_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('form_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('sample')->__('Sample Information'));
    }
    
    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label' => Mage::helper('sample')->__('Sample Information'),
            'title' => Mage::helper('sample')->__('Sample Information'),
            'content' => $this->getLayout()->createBlock('sample/adminhtml_sample_edit_tab_form')->toHtml(),
        ));

        $this->addTab('address_section', array(
            'label' => Mage::helper('sample')->__('Address Information'),
            'title' => Mage::helper('sample')->__('Address Information'),
            'content' => $this->getLayout()->createBlock('sample/adminhtml_sample_edit_tab_address')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}





    