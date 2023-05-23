<?php 

class Ccc_Meet_Adminhtml_MeetController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction(){
		$this->loadLayout();
		$this->_setActiveMenu('meet');
		$this->_title('Meet Grid');
		$this->_addContent($this->getLayout()->createBlock('meet/adminhtml_meet'));
		$this->renderLayout();
	}

	protected function _initMeet()
    {
        $this->_title($this->__('Meet'))
            ->_title($this->__('Manage Meets'));

        $meetId = (int) $this->getRequest()->getParam('id');
        $meet   = Mage::getModel('meet/meet')
            ->setStoreId($this->getRequest()->getParam('store', 0))
            ->load($meetId);

        if (!$meetId) {
            if ($setId = (int) $this->getRequest()->getParam('set')) {
                $meet->setAttributeSetId($setId);
            }
        }

        Mage::register('current_meet', $meet);
        Mage::getSingleton('cms/wysiwyg_config')->setStoreId($this->getRequest()->getParam('store'));
        return $meet;
    }

	public function newAction(){
		$this->_forward('edit');
	}

	public function editAction(){ 
		$meetId = (int) $this->getRequest()->getParam('id');
        $meet   = $this->_initMeet();
        
        if ($meetId && !$meet->getId()) {
            $this->_getSession()->addError(Mage::helper('meet')->__('This meet no longer exists.'));
            $this->_redirect('*/*/');
            return;
        }

        $this->_title($meet->getName());

        $this->loadLayout();

        $this->_setActiveMenu('meet/meet');

        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

        $this->renderLayout();
	}

	public function saveAction()
    {
        try {
            $setId = (int) $this->getRequest()->getParam('set');
            $meetData = $this->getRequest()->getPost('account');            
            $meet = Mage::getSingleton('meet/meet');
            $meet->setAttributeSetId($setId);

            if ($meetId = $this->getRequest()->getParam('id')) {
                if (!$meet->load($meetId)) {
                    throw new Exception("No Row Found");
                }
                Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
            }
            
            $meet->addData($meetData);

            $meet->save();

            Mage::getSingleton('core/session')->addSuccess("meet data added.");
            $this->_redirect('*/*/');

        } catch (Exception $e) {
            Mage::getSingleton('core/session')->addError($e->getMessage());
            $this->_redirect('*/*/');
        }
    }

    public function deleteAction()
    {
        try {

            $meetModel = Mage::getModel('meet/meet');

            if (!($meetId = (int) $this->getRequest()->getParam('id')))
                throw new Exception('Id not found');

            if (!$meetModel->load($meetId)) {
                throw new Exception('meet does not exist');
            }

            if (!$meetModel->delete()) {
                throw new Exception('Error in delete record', 1);
            }

            Mage::getSingleton('core/session')->addSuccess($this->__('The meet has been deleted.'));

        } catch (Exception $e) {
            Mage::logException($e);
            $Mage::getSingleton('core/session')->addError($e->getMessage());
        }
        
        $this->_redirect('*/*/');
    }
}