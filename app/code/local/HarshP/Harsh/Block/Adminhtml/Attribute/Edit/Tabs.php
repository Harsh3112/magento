<?php

class HarshP_Harsh_Block_Adminhtml_Attribute_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('harsh_attribute_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('harsh')->__('Attribute Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('main', array(
            'label'     => Mage::helper('harsh')->__('Properties'),
            'title'     => Mage::helper('harsh')->__('Properties'),
            'content'   => $this->getLayout()->createBlock('harsh/adminhtml_attribute_edit_tab_Main')->toHtml(),
            'active'    => true
        ));

        $model = Mage::registry('entity_attribute');

        $this->addTab('labels', array(
            'label'     => Mage::helper('harsh')->__('Manage Label / Options'),
            'title'     => Mage::helper('harsh')->__('Manage Label / Options'),
            'content'   => $this->getLayout()->createBlock('harsh/adminhtml_attribute_edit_tab_options')->toHtml(),
        ));
        
        /*if ('select' == $model->getFrontendInput()) {
            $this->addTab('options_section', array(
                'label'     => Mage::helper('catalog')->__('Options Control'),
                'title'     => Mage::helper('catalog')->__('Options Control'),
                'content'   => $this->getLayout()->createBlock('adminhtml/catalog_product_attribute_edit_tab_options')->toHtml(),
            ));
        }*/

        return parent::_beforeToHtml();
    }
}
