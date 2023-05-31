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
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            Mage::logException($e);
        }
        $this->_redirect('*/*/index');
    }

    public function collectionAction()
    {
         try {
            $productidx = Mage::getModel('productidx/productidx');       
            $productidxCollection = $productidx->getCollection();
            $productidxCollectionArray = $productidx->getCollection()->getData();

            $productidxCollectionId = array_column($productidxCollectionArray,'idx_id');
            $productidxCollectionNames = array_column($productidxCollectionArray,'collection');
            $productidxCollectionNames = array_combine($productidxCollectionId,$productidxCollectionNames);

            $newCollections = $productidx->updateCollection(array_unique($productidxCollectionNames));
            
            $attributeCode = 'collection';

            $attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', $attributeCode);
            $attributeId = $attribute->getAttributeId();

            $optionValues = array();

            $optionCollection = Mage::getResourceModel('eav/entity_attribute_option_collection')
                ->setAttributeFilter($attributeId)
                ->setStoreFilter(Mage_Core_Model_App::ADMIN_STORE_ID, false)
                ->load();
                
            foreach ($optionCollection as $option) {
                $optionValues[$option->getValue()] = $option->getOptionId();
            }
            
            $write = Mage::getSingleton('core/resource')->getConnection('core_write');
            $sourceTable = Mage::getSingleton('core/resource')->getTableName('eav_attribute_option_value');
            $destinationTable = Mage::getSingleton('core/resource')->getTableName('import_product_idx');

            $query = "UPDATE {$destinationTable} AS dest
                      INNER JOIN {$sourceTable} AS src ON dest.collection = src.value
                      SET dest.collection_id = src.option_id";
            $write->query($query);

            Mage::getSingleton('adminhtml/session')->addSuccess('Collection is fine now');
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            Mage::logException($e);
        }
            $this->_redirect('*/*/index');
    }



    public function productAction()
    {
        echo "string";
    }

}