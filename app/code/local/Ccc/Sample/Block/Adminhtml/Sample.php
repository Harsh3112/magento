<?php

class Ccc_Sample_Block_Adminhtml_Sample extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    /**
     * Block constructor
     */
    public function __construct()
    {
        $this->_blockGroup = 'sample';
        $this->_controller = 'adminhtml_sample';
        $this->_headerText = Mage::helper('sample')->__('Manage samples');

        parent::__construct();

        if ($this->_isAllowedAction('save')) {
            $this->_updateButton('add', 'label', Mage::helper('sample')->__('Add New Sample'));
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
        return Mage::getSingleton('admin/session')->isAllowed('sample/adminhtml_sample/' . $action);
    }

}