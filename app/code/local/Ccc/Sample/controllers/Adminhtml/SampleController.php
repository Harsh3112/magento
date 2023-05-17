<?php

class Ccc_Sample_Adminhtml_SampleController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_title($this->__('sample'))->_title($this->__('Manage sample'));
        $this->loadLayout();
        $this->_addContent(
            $this->getLayout()->createBlock('sample/adminhtml_sample', 'sample')
        );
        $this->renderLayout();
    }
}
