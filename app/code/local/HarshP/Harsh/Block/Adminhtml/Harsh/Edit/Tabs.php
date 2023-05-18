<?php

class HarshP_Harsh_Block_Adminhtml_Harsh_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('form_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('harsh')->__('Information'));
    }
    
    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label' => Mage::helper('harsh')->__('Information'),
            'title' => Mage::helper('harsh')->__('Information'),
            'content' => $this->getLayout()->createBlock('harsh/adminhtml_harsh_edit_tab_form')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}
