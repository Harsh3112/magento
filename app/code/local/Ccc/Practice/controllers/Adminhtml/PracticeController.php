<?php

class Ccc_Practice_Adminhtml_PracticeController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        Mage::dispatchEvent('cms_page_prepare_save', array('page' => $model, 'request' => $this->getRequest()));

        echo "string";
    }
}