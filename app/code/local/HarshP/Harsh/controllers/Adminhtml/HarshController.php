<?php

class HarshP_Harsh_Adminhtml_HarshController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        // echo "string";   
        $this->_title($this->__('details'))->_title($this->__('Manage'));
        $this->loadLayout();
        $this->_addContent(
            $this->getLayout()->createBlock('harsh/adminhtml_harsh', 'harsh')
        );
        $this->renderLayout();
    }

    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('harsh/harsh')
            ->_addBreadcrumb(Mage::helper('harsh')->__('HARSH'), Mage::helper('harsh')->__('HARSH'))
            ->_addBreadcrumb(Mage::helper('harsh')->__('Manage'), Mage::helper('harsh')->__('Manage'))
        ;
        return $this;
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('entity_id');
        $model = Mage::getModel('harsh/harsh')->load($id);
        if ($model->getId() || $id == 0)
        {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data))
            {
                $model->setData($data);
            }
            Mage::register('harsh_data', $model);

            $this->loadLayout();
            $this->_setActiveMenu('harsh/harsh');
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Manager'), Mage::helper('adminhtml')->__('Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('News'), Mage::helper('adminhtml')->__('News'));
             
            $this->_addContent($this->getLayout()->createBlock(' harsh/adminhtml_harsh_edit'))
                    ->_addLeft($this->getLayout()
                    ->createBlock('harsh/adminhtml_harsh_edit_tabs'));
            $this->renderLayout();
        }else{
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('harsh')->__('Does not exist.'));
            $this->_redirect('*/*/');
        }
    }

    public function saveAction()
    {
        try {
            $model = Mage::getModel('harsh/harsh');
            $data = $this->getRequest()->getPost('harsh');
            if (!$this->getRequest()->getParam('id'))
            {
                $model->setData($data)->setId($this->getRequest()->getParam('entity_id'));
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
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('harsh')->__('Successfully saved'));
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
            $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('harsh')));
            return;
        }

        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('harsh')->__('Unable to save'));
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if( $this->getRequest()->getParam('entity_id') > 0 ) {
            try {
                $model = Mage::getModel('harsh/harsh');
                 
                $model->setId($this->getRequest()->getParam('entity_id'))
                ->delete();
                 
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('entity_id')));
            }
        }
        $this->_redirect('*/*/');
    }

    public function massDeleteAction()
    {
        $harshIds = $this->getRequest()->getParam('harsh');
        if(!is_array($harshIds)) {
             Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select.'));
        } else {
            try {
                $harsh = Mage::getModel('harsh/harsh');
                foreach ($harshIds as $harshId) {
                    $harsh->reset()
                        ->load($harshId)
                        ->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Total of %d record(s) were deleted.', count($harshIds))
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');
    }

}
