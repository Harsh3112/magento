<?php

class Ccc_Sample_Adminhtml_SampleController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_title($this->__('Samples'))->_title($this->__('Manage Samples'));
        $this->loadLayout();
        $this->_addContent(
            $this->getLayout()->createBlock('sample/adminhtml_sample', 'sample')
        );
        $this->renderLayout();
    }

    // protected function _initAction()
    // {
    //     $this->loadLayout()
    //         ->_setActiveMenu('sample/sample')
    //         ->_addBreadcrumb(Mage::helper('sample')->__('SAMPLE'), Mage::helper('sample')->__('SAMPLE'))
    //         ->_addBreadcrumb(Mage::helper('sample')->__('Manage Samples'), Mage::helper('sample')->__('Manage Sample'));
    //     return $this;
    // }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('sample/sample')->load($id);
        if ($model->getId() || $id == 0)
        {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data))
            {
                $model->setData($data);
            }
            Mage::register('sample_data', $model);

            $this->loadLayout();
            $this->_setActiveMenu('sample/sample');
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Sample Manager'), Mage::helper('adminhtml')->__('Sample Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Sample News'), Mage::helper('adminhtml')->__('Sample News'));
             
            $this->_addContent($this->getLayout()->createBlock(' sample/adminhtml_sample_edit'))
                    ->_addLeft($this->getLayout()
                    ->createBlock('sample/adminhtml_sample_edit_tabs'));
            $this->renderLayout();
        }else{
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('sample')->__('Product does not exist'));
            $this->_redirect('*/*/');
        }
    }

    // public function saveAction()
    // {
    //     try {
    //         $model = Mage::getModel('product/product');
    //         $data = $this->getRequest()->getPost();
    //         $model->setData($data)->setId($this->getRequest()->getParam('id'));
    //         if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL)
    //         {
    //             $model->setCreatedTime(now())->setUpdateTime(now());
    //         } 
    //         else {
    //             $model->setUpdateTime(now());
    //         }
             
    //         $model->save();
    //         Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('product')->__('Product was successfully saved'));
    //         Mage::getSingleton('adminhtml/session')->setFormData(false);
             
    //         if ($this->getRequest()->getParam('back')) {
    //             $this->_redirect('*/*/edit', array('id' => $model->getId()));
    //             return;
    //         }
    //         $this->_redirect('*/*/');
    //         return;
    //     } catch (Exception $e) {
    //         Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
    //         Mage::getSingleton('adminhtml/session')->setFormData($data);
    //         $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
    //         return;
    //     }

    //     Mage::getSingleton('adminhtml/session')->addError(Mage::helper('product')->__('Unable to find product to save'));
    //     $this->_redirect('*/*/');
    // }

    // public function deleteAction()
    // {
    //     if( $this->getRequest()->getParam('id') > 0 ) {
    //         try {
    //             $model = Mage::getModel('product/product');
                 
    //             $model->setId($this->getRequest()->getParam('id'))
    //             ->delete();
                 
    //             Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Product was successfully deleted'));
    //             $this->_redirect('*/*/');
    //         } catch (Exception $e) {
    //             Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
    //             $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
    //         }
    //     }
    //     $this->_redirect('*/*/');
    // }

    public function massDeleteAction()
    {
        $sampleIds = $this->getRequest()->getParam('sample');
        if(!is_array($sampleIds)) {
             Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select sample(s).'));
        } else {
            try {
                $sample = Mage::getModel('sample/sample');
                foreach ($sampleIds as $sampleId) {
                    $sample->reset()
                        ->load($sampleId)
                        ->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Total of %d record(s) were deleted.', count($sampleIds))
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');
    }

}
