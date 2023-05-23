<?php

class Ccc_Product_Block_Adminhtml_Product_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('product_form',array('legend'=>Mage::helper('product')->__('Product information')));

        $fieldset->addField('name', 'text', array(
            'label' => Mage::helper('product')->__('Name'),
            'required' => true,
            'name' => 'name',
        ));

        $fieldset->addField('sku', 'text', array(
            'label' => Mage::helper('product')->__('SKU'),
            'required' => true,
            'name' => 'sku',
        ));

        $fieldset->addField('cost', 'text', array(
            'label' => Mage::helper('product')->__('Cost'),
            'required' => true,
            'name' => 'cost',
        ));
        $fieldset->addField('price', 'text', array(
            'label' => Mage::helper('product')->__('Price'),
            'required' => true,
            'name' => 'price',
        ));
        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('product')->__('Status'),
            'required' => true,
            'options' => array(
                    1 => Mage::helper('product')->__('Active'), 
                    2 => Mage::helper('product')->__('Inactive')
                ),
        ));

        if ( Mage::getSingleton('adminhtml/session')->getVendorData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getVendorData());
            Mage::getSingleton('adminhtml/session')->setVendorData(null);
        } elseif ( Mage::registry('product_data') ) {
            $form->setValues(Mage::registry('product_data')->getData());
        }
        return parent::_prepareForm();
    }

}





    