<?php

class Hp_Vendor_Block_Adminhtml_Vendor_Edit_Tab_Addresses extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('vendor_form',array('legend'=>Mage::helper('vendor')->__('Vendor Addresses')));

        $fieldset->addField('address', 'text', array(
            'label' => Mage::helper('vendor')->__('Address'),
            'required' => false,
            'name' => 'address[address]',
        ));

        $fieldset->addField('city','text', array(
            'label' => Mage::helper('vendor')->__('City'),
            'required' => false,
            'name' => 'address[city]'
        ));

        $fieldset->addField('country', 'select', array(
            'name'      => 'address[country]',
            'label'     => Mage::helper('vendor')->__('Country'),
            'required'  => true,
            'values'    => Mage::getModel('directory/country')->getResourceCollection()
                            ->loadByStore()
                            ->toOptionArray(),
            'onchange'  => 'updateStateOptions(this.value)',
        ));

        $fieldset->addField('state', 'select', array(
            'name'      => 'address[state]',
            'label'     => Mage::helper('vendor')->__('State'),
            'required'  => true,
            'values'    => Mage::getModel('directory/region')->getResourceCollection()
                            ->addCountryFilter($countryId)
                            ->load()
                            ->toOptionArray()
        ));

        
        $script = '
            <script>
            function updateStateOptions(countryId) {
                var url = "' . $this->getUrl('*/*/updateStateOptions') . '"; // Replace with your controller action URL
                new Ajax.Request(url, {
                    method: "post",
                    parameters: { country_id: countryId },
                    onSuccess: function(transport) {
                        var response = transport.responseText.evalJSON();
                        var stateField = $("state");
                        stateField.update("");
                        response.each(function(option) {
                            stateField.insert(new Element("option", { value: option.value }).update(option.label));
                        });
                    }
                });
            }
            </script>';
        $fieldset->addField('ajax_script', 'note', array(
            'text'     => $script,
            'after_element_html' => '',
        ));

        $fieldset->addField('zipcode','text', array(
            'label' => Mage::helper('vendor')->__('Zipcode'),
            'required' => false,
            'name' => 'address[zipcode]'
        ));

        if ( Mage::getSingleton('adminhtml/session')->getVendorData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getVendorData());
            Mage::getSingleton('adminhtml/session')->setVendorData(null);
        } 
        elseif ( Mage::registry('address_edit') ) {
            $form->setValues(Mage::registry('address_edit')->getData());
        }
        return parent::_prepareForm();

    }

}





    