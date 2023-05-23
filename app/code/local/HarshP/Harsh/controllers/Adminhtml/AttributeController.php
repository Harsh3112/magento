<?php

class HarshP_Harsh_Adminhtml_AttributeController extends Mage_Adminhtml_Controller_Action
{
    protected $_entityTypeId;

    public function preDispatch()
    {
        $this->_setForcedFormKeyActions('delete');
        parent::preDispatch();
        $this->_entityTypeId = Mage::getModel('eav/entity')->setType(HarshP_Harsh_Model_Harsh::ENTITY)->getTypeId();
    }

    protected function _initAction()
    {
        $this->_title($this->__('Harsh'))
             ->_title($this->__('Attributes'))
             ->_title($this->__('Manage Attributes'));

        if($this->getRequest()->getParam('popup')) {
            $this->loadLayout('popup');
        } else {
            $this->loadLayout()
                ->_setActiveMenu('harsh/attributes')
                ->_addBreadcrumb(Mage::helper('harsh')->__('Harsh'), Mage::helper('harsh')->__('Harsh'))
                ->_addBreadcrumb(
                    Mage::helper('harsh')->__('Manage Attributes'),
                    Mage::helper('harsh')->__('Manage Attributes'))
            ;
        }
        return $this;
    }

    public function indexAction()
    {
        $this->_initAction()
            ->_addContent($this->getLayout()->createBlock('harsh/adminhtml_attribute', 'harsh'))
            ->renderLayout();

        // $this->_title($this->__('Manage Attributes'));
        // $this->loadLayout();
        // $this->_addContent($this->getLayout()->createBlock('harsh/adminhtml_attribute'));
        // $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        // echo "this is edit action";
        $id = $this->getRequest()->getParam('attribute_id');
        $model = Mage::getModel('harsh/resource_eav_attribute')
            ->setEntityTypeId($this->_entityTypeId);
        if ($id) {
            $model->load($id);

            if (! $model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('harsh')->__('This attribute no longer exists'));
                $this->_redirect('*/*/');
                return;
            }

            // entity type check
            if ($model->getEntityTypeId() != $this->_entityTypeId) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('harsh')->__('This attribute cannot be edited.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        // set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getAttributeData(true);
        if (! empty($data)) {
            $model->addData($data);
        }

        Mage::register('entity_attribute', $model);

        $this->_initAction();

        $this->_title($id ? $model->getName() : $this->__('New Attribute'));

        $item = $id ? Mage::helper('harsh')->__('Edit Attribute')
                    : Mage::helper('harsh')->__('New Attribute');

        $this->_addBreadcrumb($item, $item);

        // $this->getLayout()->getBlock('harsh_attribute_edit_tabs');
            // ->setIsPopup((bool)$this->getRequest()->getParam('popup'));
        
        $this->_addContent($this->getLayout()->createBlock('harsh/adminhtml_attribute_edit'))->_addLeft($this->getLayout()->createBlock('harsh/adminhtml_attribute_edit_tabs'))->_addJs($this->getLayout()->createBlock('harsh/adminhtml_attribute_edit_js'));

        $this->renderLayout();
    }
}
