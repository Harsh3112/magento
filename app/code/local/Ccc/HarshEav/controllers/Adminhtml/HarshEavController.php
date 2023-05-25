<?php 

class Ccc_HarshEav_Adminhtml_HarshEavController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction(){
		$this->loadLayout();
		$this->_setActiveMenu('harsheav');
		$this->_title('HarshEav Grid');
		$this->_addContent($this->getLayout()->createBlock('harsheav/adminhtml_harsheav'));
		$this->renderLayout();
	}

	protected function _initHarshEav()
    {
        $this->_title($this->__('HarshEav'))
            ->_title($this->__('Manage HarshEavs'));

        $harsheavId = (int) $this->getRequest()->getParam('id');
        $harsheav   = Mage::getModel('harsheav/harsheav')
            ->setStoreId($this->getRequest()->getParam('store', 0))
            ->load($harsheavId);

        if (!$harsheavId) {
            if ($setId = (int) $this->getRequest()->getParam('set')) {
                $harsheav->setAttributeSetId($setId);
            }
        }

        Mage::register('current_harsheav', $harsheav);
        Mage::getSingleton('cms/wysiwyg_config')->setStoreId($this->getRequest()->getParam('store'));
        return $harsheav;
    }

	public function newAction(){
		$this->_forward('edit');
	}

	public function editAction(){ 
		$harsheavId = (int) $this->getRequest()->getParam('id');
        $harsheav   = $this->_initHarshEav();
        
        if ($harsheavId && !$harsheav->getId()) {
            $this->_getSession()->addError(Mage::helper('harsheav')->__('This harsheav no longer exists.'));
            $this->_redirect('*/*/');
            return;
        }

        $this->_title($harsheav->getName());

        $this->loadLayout();

        $this->_setActiveMenu('harsheav/harsheav');

        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

        $this->renderLayout();
	}

	public function saveAction()
    {
        try {
            $setId = (int) $this->getRequest()->getParam('set');
            $harsheavData = $this->getRequest()->getPost('account');            
            $harsheav = Mage::getSingleton('harsheav/harsheav');
            $harsheav->setAttributeSetId($setId);

            if ($harsheavId = $this->getRequest()->getParam('id')) {
                if (!$harsheav->load($harsheavId)) {
                    throw new Exception("No Row Found");
                }
                Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
            }
            
            $harsheav->addData($harsheavData);

            $harsheav->save();

            Mage::getSingleton('core/session')->addSuccess("harsheav data added.");
            $this->_redirect('*/*/');

        } catch (Exception $e) {
            Mage::getSingleton('core/session')->addError($e->getMessage());
            $this->_redirect('*/*/');
        }
    }

    public function deleteAction()
    {
        try {

            $harsheavModel = Mage::getModel('harsheav/harsheav');

            if (!($harsheavId = (int) $this->getRequest()->getParam('id')))
                throw new Exception('Id not found');

            if (!$harsheavModel->load($harsheavId)) {
                throw new Exception('harsheav does not exist');
            }

            if (!$harsheavModel->delete()) {
                throw new Exception('Error in delete record', 1);
            }

            Mage::getSingleton('core/session')->addSuccess($this->__('The harsheav has been deleted.'));

        } catch (Exception $e) {
            Mage::logException($e);
            $Mage::getSingleton('core/session')->addError($e->getMessage());
        }
        
        $this->_redirect('*/*/');
    }
}