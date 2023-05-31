<?php

class Hp_ProductIdx_Block_Adminhtml_ProductIdx extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        
        $this->_blockGroup = 'productidx';
        $this->_controller = 'adminhtml_productidx';
        $this->_headerText = Mage::helper('productidx')->__('Manage ProductIdxs');

        parent::__construct();

        if ($this->_isAllowedAction('save')) {
            // $this->_updateButton('add', 'label', Mage::helper('productidx')->__('Add New ProductIdx'));
            $this->_updateButton('add', 'label', Mage::helper('productidx')->__('Import ProductIdx'));

            $this->_addButton('brand', array(
                'label'   => 'Brand',
                'onclick' => 'setLocation(\'' . $this->getUrl('*/*/brand') . '\')',
            ));

            $this->_addButton('collection', array(
                'label'     => 'Collection',
                'onclick'   => 'setLocation("")'
            ));
            $this->_addButton('product', array(
                'label'     => 'Product',
                'onclick'   => 'setLocation("")'
            ));
        } else {
            $this->_removeButton('add');
        }

    }

    protected function _isAllowedAction($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('productidx/adminhtml_productidx/' . $action);
    }

}