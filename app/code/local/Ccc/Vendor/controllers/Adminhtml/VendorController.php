<?php

/**
 * 
 */
class Ccc_Vendor_Adminhtml_VendorController extends Mage_Adminhtml_Controller_Action
{
	
	function indexAction()
	{
        // $model = Mage::getModel('vendor/vendor')->load(2);
        // $model->name = "xyz";
        // $model->email = "abc";
        // $model->save();


        // print_r($model->getCollection()->toArray());
        // echo "<pre>";
        // print_r($this->getLayout()->createBlock('vendor/adminhtml_vendor'));
        // die;

	  	$this->_title($this->__('Vendor'))
             ->_title($this->__('Manage Vendors'));
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('vendor/adminhtml_vendor'));
        $this->renderLayout();
	}


}