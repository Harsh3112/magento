<?php

class HarshP_Harsh_Block_Adminhtml_Attribute_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array('id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post'));

        $fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('harsh')->__('Frontend Properties')));
          $fieldset->addField('is_searchable', 'select', array(
            'name' => 'is_searchable',
            'label' => Mage::helper('harsh')->__('test_field'),
            'title' => Mage::helper('harsh')->__('Test Field'),
            'values' => $yesno,
        ));
          
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
