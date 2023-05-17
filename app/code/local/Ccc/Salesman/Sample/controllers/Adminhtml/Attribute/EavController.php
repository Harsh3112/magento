<?php

class Ccc_Sample_Adminhtml_Attribute_EavController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_title($this->__('Samples'))->_title($this->__('Manage Attribute'));
        $this->loadLayout();
        $this->_addContent(
            $this->getLayout()->createBlock('sample/adminhtml_sample', 'sample')
        );
        $this->renderLayout();
    }
}
