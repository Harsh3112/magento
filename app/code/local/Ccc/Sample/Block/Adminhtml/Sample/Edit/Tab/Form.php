<?php

class Ccc_Salesman_Block_Adminhtml_Salesman_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('salesman_form',array('legend'=>Mage::helper('salesman')->__('Salesman information')));

        $fieldset->addField('first_name', 'text', array(
            'label' => Mage::helper('salesman')->__('First Name'),
            'required' => true,
            'name' => 'salesman[first_name]',
        ));

        $fieldset->addField('last_name', 'text', array(
            'label' => Mage::helper('salesman')->__('Last Name'),
            'required' => true,
            'name' => 'salesman[last_name]',
        ));

        $fieldset->addField('email', 'text', array(
            'label' => Mage::helper('salesman')->__('Email'),
            'required' => true,
            'name' => 'salesman[email]',
        ));

        $fieldset->addField('mobile', 'text', array(
            'label' => Mage::helper('salesman')->__('Mobile'),
            'required' => true,
            'name' => 'salesman[mobile]',
        ));

        $fieldset->addField('gender', 'radios', array(
            'label' => Mage::helper('salesman')->__('Gender'),
            'required' => true,
            'name' => 'salesman[gender]',
            'values' => array(
                array('value' => 1, 'label' => 'Male'),
                array('value' => 2, 'label' => 'Female')
            ),
        ));

        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('salesman')->__('Status'),
            'required' => true,
            'name' => 'salesman[status]',
            'options' => array(1 => 'Active', 2 => 'Inactive'),
        ));

        $fieldset->addField('company', 'text', array(
            'label' => Mage::helper('salesman')->__('Company'),
            'required' => true,
            'name' => 'salesman[company]',
        ));

        if ( Mage::getSingleton('adminhtml/session')->getVendorData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getVendorData());
            Mage::getSingleton('adminhtml/session')->setVendorData(null);
        } 
        elseif ( Mage::registry('salesman_data') ) {
            $form->setValues(Mage::registry('salesman_data')->getData());
        }
        return parent::_prepareForm();
    }

}





    