<?php

class Hp_ProductIdx_Block_Adminhtml_ProductIdx_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('form_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('productidx')->__('ProductIdx Information'));
    }
    
    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label' => Mage::helper('productidx')->__('ProductIdx'),
            'title' => Mage::helper('productidx')->__('ProductIdx Information'),
            'content' => $this->getLayout()->createBlock('productidx/adminhtml_productidx_edit_tab_form')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}





    