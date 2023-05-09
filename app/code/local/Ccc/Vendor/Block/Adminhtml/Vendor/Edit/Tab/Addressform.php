<?php

class Ccc_Vendor_Block_Adminhtml_Vendor_Edit_Tab_Addressform extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('vendor_addressform',array('legend'=>Mage::helper('address')->__('Address information')));

        $fieldset->addField('address', 'text', array(
            'label' => Mage::helper('address')->__('Address'),
            'required' => true,
            'name' => 'address',
        ));

        $fieldset->addField('city', 'text', array(
            'label' => Mage::helper('vendor')->__('City'),
            'required' => true,
            'name' => 'city',
        ));

        $fieldset->addField('state', 'text', array(
            'label' => Mage::helper('vendor')->__('State'),
            'required' => true,
            'name' => 'state',
        ));

        $fieldset->addField('country', 'text', array(
            'label' => Mage::helper('vendor')->__('Country'),
            'required' => true,
            'name' => 'country',
        ));

        $fieldset->addField('zipcode', 'text', array(
            'label' => Mage::helper('vendor')->__('Zipcode'),
            'required' => true,
            'name' => 'zipcode',
        ));

        if ( Mage::getSingleton('adminhtml/session')->getVendorData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getVendorData());
            Mage::getSingleton('adminhtml/session')->setVendorData(null);
        } elseif ( Mage::registry('vendor_data') ) {
            $form->setValues(Mage::registry('vendor_data')->getData());
        }
        return parent::_prepareForm();
    }

}





    