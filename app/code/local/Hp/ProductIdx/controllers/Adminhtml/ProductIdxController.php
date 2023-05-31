<?php
class Hp_ProductIdx_Adminhtml_ProductIdxController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
    {
    	$this->_title($this->__('ProductIdx'))
             ->_title($this->__('Manage ProductIdxs'));
       	$this->loadLayout();
       	$this->_addContent($this->getLayout()->createBlock('productidx/adminhtml_productidx'));
	   	$this->renderLayout();
    }

    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('productidx/productidx')
            ->_addBreadcrumb(Mage::helper('productidx')->__('ProductIdx Manager'), Mage::helper('productidx')->__('ProductIdx Manager'))
            ->_addBreadcrumb(Mage::helper('productidx')->__('Manage productidx'), Mage::helper('productidx')->__('Manage productidx'))
        ;
        return $this;
    }
    
    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $this->_title($this->__('ProductIdx'))
             ->_title($this->__('ProductIdxs'))
             ->_title($this->__('Edit ProductIdxs'));

        $id = $this->getRequest()->getParam('idx_id');
        $model = Mage::getModel('productidx/productidx');

        if ($id) {
            $model->load($id);
            if (! $model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('productidx')->__('This page no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }
        $this->_title($model->getId() ? $model->getTitle() : $this->__('New ProductIdx'));

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);

        if (!empty($data)) 
        {
            $model->setData($data);
        }

        Mage::register('productidx_edit',$model);

        $this->_initAction()
            ->_addBreadcrumb(
                $id ? Mage::helper('productidx')->__('Edit ProductIdx')
                    : Mage::helper('productidx')->__('New ProductIdx'),
                $id ? Mage::helper('productidx')->__('Edit ProductIdx')
                    : Mage::helper('productidx')->__('New ProductIdx'));

        $this->_addContent($this->getLayout()->createBlock('productidx/adminhtml_productidx_edit'))
                ->_addLeft($this->getLayout()->createBlock('productidx/adminhtml_productidx_edit_tabs'));

        $this->renderLayout();
    }

    // public function saveAction()
    // {
    //     try {
    //         echo "<pre>";
    //         print_r($_FILES);

    //         die;
    //         $model = Mage::getModel('productidx/productidx');
    //         $data = $this->getRequest()->getPost('productidx');

    //         $productidxId = $this->getRequest()->getParam('id');
    //         if (!$productidxId)
    //         {
    //             $productidxId = $this->getRequest()->getParam('idx_id');
    //         }

    //         $model->setData($data)->setId($productidxId);
    //         if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL)
    //         {
    //             $model->setCreatedTime(now())->setUpdateTime(now());
    //         } 
    //         else {
    //             $model->setUpdateTime(now());
    //         }
    //         $model->save();
            
    //         Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('productidx')->__('ProductIdx was successfully saved'));
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
    //         $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('idx_id')));
    //         return;
    //     }

    //     Mage::getSingleton('adminhtml/session')->addError(Mage::helper('productidx')->__('Unable to find productidx to save'));
    //     $this->_redirect('*/*/');
    // }

    public function saveAction()
    {
        try {


            if (isset($_FILES['file_uploaded']['tmp_name']) && !empty($_FILES['file_uploaded']['tmp_name'])) 
            {
                $tableName = 'import_product_idx';
                $resource = Mage::getSingleton('core/resource');
                $connection = $resource->getConnection('core_write');
                $table = $resource->getTableName($tableName);
                $connection->query("TRUNCATE TABLE `$table`");

                $csvFile = $_FILES['file_uploaded']['tmp_name'];
                $csvData = array_map('str_getcsv', file($csvFile));
                $columns = $csvData[0];
                unset($csvData[0]);
                $tableName = Mage::getSingleton('core/resource')->getTableName('import_product_idx');
                $connection = Mage::getSingleton('core/resource')->getConnection('core_write');
                $counter = 0;

                foreach ($csvData as $data) {
                    $counter ++;
                    $row['sku'] = $data[0];
                    $row[$columns[1]] =  $data[1];
                    $row[$columns[2]] =  $data[2];
                    $row[$columns[3]] =  $data[3];
                    $row[$columns[4]] =  $data[4];
                    $row[$columns[5]] =  $data[5];
                    $row[$columns[6]] =  $data[6];
                    $row[$columns[7]] =  $data[7];
                    $row[$columns[8]] =  $data[8];
                    // $dataToInsert[] = $row;
                    $query = $connection->insertOnDuplicate(
                        $tableName,
                        $row,
                        array_keys($row)                
                    );
                }

                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Total of %d record(s) were saved.', $counter)
                );
            } else {
            Mage::getSingleton('adminhtml/session')->addError('No CSV file uploaded.');
        }

        $this->_redirect('*/*/index');
    }catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            Mage::getSingleton('adminhtml/session')->setFormData($data);
            $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('idx_id')));
            return;
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('productidx')->__('Unable to find productIdx to save'));
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if( $this->getRequest()->getParam('idx_id') > 0 ) {
            try {
                $model = Mage::getModel('productidx/productidx');
                 
                $model->setId($this->getRequest()->getParam('idx_id'))
                ->delete();
                 
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('ProductIdx was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('idx_id')));
            }
        }
        $this->_redirect('*/*/');
    }

    public function brandAction()
    {
        try {
            $productidx = Mage::getModel('productidx/productidx');       
            $productidxCollection = $productidx->getCollection();
            $productidxCollectionArray = $productidx->getCollection()->getData();
            $productidxBrandId = array_column($productidxCollectionArray,'idx_id');
            $productidxBrandNames = array_column($productidxCollectionArray,'brand');
            $productidxBrandNames = array_combine($productidxBrandId,$productidxBrandNames);

            $brand = Mage::getModel('brand/brand');       
            $brandCollection = $brand->getCollection();
            $brandCollectionArray = $brand->getCollection()->getData();
            $brandBrandId = array_column($brandCollectionArray,'brand_id');
            $brandNames = array_column($brandCollectionArray,'name');
            $brandNames = array_combine($brandBrandId,$brandNames);


            $newBrands = $productidx->updateBrandTable(array_unique($productidxBrandNames));

            foreach ($productidxCollection as $productidx) 
            {
                $productidxBrandName = $productidx->getData('brand');
                $brandId = array_search($productidxBrandName,$newBrands);
                $resource = Mage::getSingleton('core/resource');
                $connection = $resource->getConnection('core_write');
                $tableName = $resource->getTableName('import_product_idx');
                $condition = '`idx_id` = '.$productidx->idx_id;
                $query = "UPDATE `{$tableName}` SET `brand_id` = {$brandId} WHERE {$condition}";
                $connection->query($query); 
            }
            Mage::getSingleton('adminhtml/session')->addSuccess('Brand is fine now');
        } catch (Exception $e) {
            Mage::logException($e);
        }
        $this->_redirect('*/*/index');
    }

    public function productAction()
    {
        echo "string";
    }

    public function collectionAction()
    {
        echo "string";
    }
}