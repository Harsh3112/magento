<?php

class Ccc_Vendor_Adminhtml_VendorController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        
        $this->_title($this->__('Vendors'))->_title($this->__('Manage Vendors'));
        $this->loadLayout();
        $this->_addContent(
            $this->getLayout()->createBlock('vendor/adminhtml_vendor', 'vendor')
        );
        $this->renderLayout();
    }

    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('vendor/vendor')
            ->_addBreadcrumb(Mage::helper('vendor')->__('VENDOR'), Mage::helper('vendor')->__('VENDOR'))
            ->_addBreadcrumb(Mage::helper('vendor')->__('Manage Vendor'), Mage::helper('vendor')->__('Manage Vendor'))
        ;
        return $this;
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('vendor_id');
        $model = Mage::getModel('vendor/vendor')->load($id);
        if ($model->getId() || $id == 0)
        {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data))
            {
                $model->setData($data);
            }
            Mage::register('vendor_data', $model);

            $this->loadLayout();
            $this->_setActiveMenu('vendor/vendor');
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Vendor Manager'), Mage::helper('adminhtml')->__('Vendor Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Vendor News'), Mage::helper('adminhtml')->__('Vendor News'));
             
            $this->_addContent($this->getLayout()->createBlock(' vendor/adminhtml_vendor_edit'))
                    ->_addLeft($this->getLayout()
                    ->createBlock('vendor/adminhtml_vendor_edit_tabs'));
            $this->renderLayout();
        }else{
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vendor')->__('Vendor does not exist'));
            $this->_redirect('*/*/');
        }
    }

    public function saveAction()
    {
        try {
            $model = Mage::getModel('vendor/vendor');
            $data = $this->getRequest()->getPost();

            echo "<pre>";
            print_r($data);die;
            if (!$this->getRequest()->getParam('id'))
            {
                $model->setData($data)->setId($this->getRequest()->getParam('vendor_id'));
            }

            $model->setData($data)->setId($this->getRequest()->getParam('id'));
            if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL)
            {
                $model->setCreatedTime(now())->setUpdateTime(now());
            } 
            else {
                $model->setUpdateTime(now());
            }
             
            $model->save();
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('vendor')->__('Vendor was successfully saved'));
            Mage::getSingleton('adminhtml/session')->setFormData(false);
             
            if ($this->getRequest()->getParam('back')) {
                $this->_redirect('*/*/edit', array('id' => $model->getId()));
                return;
            }
            $this->_redirect('*/*/');
            return;
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            Mage::getSingleton('adminhtml/session')->setFormData($data);
            $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('vendor_id')));
            return;
        }

        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vendor')->__('Unable to find vendor to save'));
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if( $this->getRequest()->getParam('vendor_id') > 0 ) {
            try {
                $model = Mage::getModel('vendor/vendor');
                 
                $model->setId($this->getRequest()->getParam('vendor_id'))
                ->delete();
                 
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Vendor was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('vendor_id')));
            }
        }
        $this->_redirect('*/*/');
    }

}
