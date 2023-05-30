<?php

class Hp_ProductIdx_Block_Adminhtml_ProductIdx_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('productidx_form',array('legend'=>Mage::helper('productidx')->__('ProductIdx Information')));

        $fieldset->addField('sku', 'text', array(
            'label' => Mage::helper('productidx')->__('SKU'),
            'required' => true,
            'name' => 'productidx[sku]',
        ));

        $fieldset->addField('name', 'text', array(
            'label' => Mage::helper('productidx')->__('Name'),
            'required' => true,
            'name' => 'productidx[name]',
        ));

        $fieldset->addField('price', 'text', array(
            'label' => Mage::helper('productidx')->__('Price'),
            'required' => true,
            'name' => 'productidx[price]',
        ));

        $fieldset->addField('quantity', 'text', array(
            'label' => Mage::helper('productidx')->__('Quantity'),
            'required' => true,
            'name' => 'productidx[quantity]',
        ));

        $fieldset->addField('brand', 'text', array(
            'label' => Mage::helper('productidx')->__('Brand'),
            'required' => true,
            'name' => 'productidx[brand]',
        ));

        $fieldset->addField('collection', 'text', array(
            'label' => Mage::helper('productidx')->__('Collection'),
            'required' => true,
            'name' => 'productidx[collection]',
        ));

        $fieldset->addField('description','text', array(
            'label' => Mage::helper('productidx')->__('Description'),
            'required' => true,
            'name' => 'productidx[description]'
        ));

        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('productidx')->__('Status'),
            'required' => true,
            'name' => 'productidx[status]',
            'options' => array(
                1 => Mage::helper('productidx')->__('Active'),
                2 => Mage::helper('productidx')->__('Inactive'),
            ),
        ));

        if ( Mage::getSingleton('adminhtml/session')->getProductIdxData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getProductIdxData());
            Mage::getSingleton('adminhtml/session')->setProductIdxData(null);
        } 
        elseif ( Mage::registry('productidx_edit') ) {
            $form->setValues(Mage::registry('productidx_edit')->getData());
        }
        return parent::_prepareForm();


    }

}





    