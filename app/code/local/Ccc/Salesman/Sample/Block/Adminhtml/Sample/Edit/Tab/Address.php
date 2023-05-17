<?php

class Ccc_Sample_Block_Adminhtml_Sample_Edit_Tab_Address extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('address_form',array('legend'=>Mage::helper('sample')->__('Address information')));

        $fieldset->addField('name', 'text', array(
            'label' => Mage::helper('sample')->__('Name'),
            'required' => true,
            'name' => 'name',
        ));

        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('sample')->__('Status'),
            'required' => false,
            'name' => 'status',
            'options' => array(1=>'Active', 2=>'Inactive'),
        ));

        if ( Mage::getSingleton('adminhtml/session')->getVendorData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getSampleData());
            Mage::getSingleton('adminhtml/session')->setSampleData(null);
        } elseif ( Mage::registry('address_data') ) {
            $form->setValues(Mage::registry('address_data')->getData());
        }
        return parent::_prepareForm();
    }

}





    