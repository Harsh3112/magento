<?php

class HarshP_Harsh_Block_Adminhtml_Harsh extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'harsh';
        $this->_controller = 'adminhtml_harsh';
        $this->_headerText = Mage::helper('harsh')->__('Manage');

        parent::__construct();

        if ($this->_isAllowedAction('save')) {
            $this->_updateButton('add', 'label', Mage::helper('harsh')->__('Add New'));
        } else {
            $this->_removeButton('add');
        }

    }

    /**
     * Check permission for passed action
     *
     * @param string $action
     * @return bool
     */
    protected function _isAllowedAction($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('harsh/adminhtml_harsh/' . $action);
    }

}