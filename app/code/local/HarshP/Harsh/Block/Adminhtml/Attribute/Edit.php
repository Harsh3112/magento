<?php

class HarshP_Harsh_Block_Adminhtml_Attribute_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

    public function __construct()
    {
        $this->_objectId = 'attribute_id';
        $this->_controller = 'adminhtml_attribute';
        $this->_blockGroup = 'harsh';

        parent::__construct();

        if($this->getRequest()->getParam('popup')) {
            $this->_removeButton('back');
            $this->_addButton(
                'close',
                array(
                    'label'     => Mage::helper('harsh')->__('Close Window'),
                    'class'     => 'cancel',
                    'onclick'   => 'window.close()',
                    'level'     => -1
                )
            );
        } else {
            $this->_addButton(
                'save_and_edit_button',
                array(
                    'label'     => Mage::helper('harsh')->__('Save and Continue Edit'),
                    'onclick'   => 'saveAndContinueEdit()',
                    'class'     => 'save'
                ),
                100
            );
        }

        $this->_updateButton('save', 'label', Mage::helper('harsh')->__('Save Attribute'));
        $this->_updateButton('save', 'onclick', 'saveAttribute()');

        if (! Mage::registry('entity_attribute')->getIsUserDefined()) {
            $this->_removeButton('delete');
        } else {
            $this->_updateButton('delete', 'label', Mage::helper('harsh')->__('Delete Attribute'));
        }
    }

    public function getHeaderText()
    {
        // if (Mage::registry('entity_attribute')->getId()) {
        //     $frontendLabel = Mage::registry('entity_attribute')->getFrontendLabel();
        //     if (is_array($frontendLabel)) {
        //         $frontendLabel = $frontendLabel[0];
        //     }
        //     return Mage::helper('harsh')->__('Edit Attribute "%s"', $this->escapeHtml($frontendLabel));
        // }
        // else {
            return Mage::helper('harsh')->__('New Attribute');
        // }
    }

    public function getValidationUrl()
    {
        return $this->getUrl('*/*/validate', array('_current'=>true));
    }

    public function getSaveUrl()
    {
        return $this->getUrl('*/'.$this->_controller.'/save', array('_current'=>true, 'back'=>null));
    }
}
