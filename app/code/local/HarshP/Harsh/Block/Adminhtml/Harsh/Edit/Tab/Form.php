<?php

class HarshP_Harsh_Block_Adminhtml_Harsh_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('harsh_form',array('legend'=>Mage::helper('harsh')->__('information')));

        $fieldset->addField('first_name', 'text', array(
            'label' => Mage::helper('harsh')->__('First Name'),
            'required' => true,
            'name' => 'harsh[first_name]',
        ));

        $fieldset->addField('last_name', 'text', array(
            'label' => Mage::helper('harsh')->__('Last Name'),
            'required' => true,
            'name' => 'harsh[last_name]',
        ));

        $fieldset->addField('age', 'text', array(
            'label' => Mage::helper('harsh')->__('Age'),
            'required' => true,
            'name' => 'harsh[age]',
        ));

        if ( Mage::getSingleton('adminhtml/session')->getSampleData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getSampleData());
            Mage::getSingleton('adminhtml/session')->setVendorData(null);
        } 
        elseif ( Mage::registry('harsh_data') ) {
            $form->setValues(Mage::registry('harsh_data')->getData());
        }
        return parent::_prepareForm();
    }

}





    