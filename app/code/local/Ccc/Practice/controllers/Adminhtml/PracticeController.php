<?php

class Ccc_Practice_Adminhtml_PracticeController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        // Mage::dispatchEvent('cms_page_prepare_save', array('page' => $model, 'request' => $this->getRequest()));

        echo "<pre>";
        $mage = new Mage;
        // print_r($mage->getVersion());
        // print_r($mage->getVersionInfo());
        // print_r($mage->getEdition());
        Mage::register('hello', 'hello');
        // print_r(Mage::registry('hello'));
        // print_r($mage->getEvents());
        // print_r($mage->objects());
        // print_r($mage->getBaseDir());
        // print_r($mage->getModuleDir('','product'));
        // print_r($mage->getStoreConfig('catalog'));
        // var_dump($mage->getStoreConfigFlag('catalog/frontend/list_mode'));
        // print_r($mage->getBaseUrl());
        // print_r($mage->getUrl('category/index/new',['c'=>23]));
        print_r(get_class_methods($mage));
        // print_r($mage->getDesign());
    }
}