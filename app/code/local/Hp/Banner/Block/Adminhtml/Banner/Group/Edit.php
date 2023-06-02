<?php

class Hp_Banner_Block_Adminhtml_Banner_Group_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

    public function __construct()
    {
        $this->_objectId   = 'banner_id';
        $this->_blockGroup = 'banner';
        $this->_controller = 'adminhtml_banner_group';
        $this->_headerText = Mage::helper('banner')->__('Manage Groups');

        parent::__construct();
        if ($this->_isAllowedAction('save')) {

            $this->_updateButton('save', 'label', Mage::helper('banner')->__('Save group'));
            $this->_addButton('saveandcontinue', array(
                'label'     => Mage::helper('adminhtml')->__('Save and Continue Edit'),
                'onclick'   => 'saveAndContinueEdit(\''.$this->_getSaveAndContinueUrl().'\')',
                'class'     => 'save',
            ), -100);
            $this->_updateButton('delete', 'label', Mage::helper('banner')->__('Delete banner'));
        } else {
            $this->_removeButton('save');
        }

        // if ($this->_isAllowedAction('delete')) {
        //     $this->_updateButton('delete', 'label', Mage::helper('banner')->__('Delete banner'));
        // } else {
        //     $this->_removeButton('delete');
        // }
    }

    /**
     * Retrieve text for header element depending on loaded page
     *
     * @return string
     */
    public function getHeaderText()
    {
        
            return Mage::helper('banner')->__('New banner Group');
    }

    /**
     * Check permission for passed action
     *
     * @param string $action
     * @return bool
     */
    protected function _isAllowedAction($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('banner/adminhtml_banner_group/' . $action);
    }

    /**
     * Getter of url for "Save and Continue" button
     * tab_id will be replaced by desired by JS later
     *
     * @return string
     */
    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl('*/*/save', array(
            '_current'   => true,
            'back'       => 'edit',
            'active_tab' => '{{tab_id}}'
        ));
    }
}
