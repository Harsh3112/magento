<?php

class Ccc_Sample_Block_Adminhtml_Sample_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('sample_form',array('legend'=>Mage::helper('sample')->__('Sample information')));

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
        } elseif ( Mage::registry('sample_data') ) {
            $form->setValues(Mage::registry('sample_data')->getData());
        }
        return parent::_prepareForm();
    }

}





    