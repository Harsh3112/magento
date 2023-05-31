<?php

class Hp_ProductIdx_Block_Adminhtml_ProductIdx_Grid extends Mage_Adminhtml_Block_Widget_Grid
{


    public function __construct()
    {
        parent::__construct();
        $this->setId('productidxAdminhtmlProductIdxGrid');
        $this->setDefaultSort('idx_id');
        $this->setDefaultDir('ASC');
    }

   protected function _prepareCollection()
    {
        $collection = Mage::getModel('productidx/productidx')->getCollection();
        /* @var $collection Mage_Cms_Model_Mysql4_Page_Collection */
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('idx_id', array(
            'header'    => Mage::helper('productidx')->__('Index'),
            'align'     => 'left',
            'index'     => 'idx_id',
        ));

        $this->addColumn('product_id', array(
            'header'    => Mage::helper('productidx')->__('Product Id'),
            'align'     => 'left',
            'index'     => 'product_id',
        ));

        $this->addColumn('sku', array(
            'header'    => Mage::helper('productidx')->__('SKU'),
            'align'     => 'left',
            'index'     => 'sku',
        ));

        $this->addColumn('name', array(
            'header'    => Mage::helper('productidx')->__('Name'),
            'align'     => 'left',
            'index'     => 'name',
        ));

        $this->addColumn('price', array(
            'header'    => Mage::helper('productidx')->__('Price'),
            'align'     => 'left',
            'index'     => 'price',
        ));

        $this->addColumn('cost', array(
            'header'    => Mage::helper('productidx')->__('Cost'),
            'align'     => 'left',
            'index'     => 'cost',
        ));
        
        $this->addColumn('quantity', array(
            'header'    => Mage::helper('productidx')->__('Quantity'),
            'align'     => 'left',
            'index'     => 'quantity',
        ));

        $this->addColumn('brand', array(
            'header'    => Mage::helper('productidx')->__('Brand'),
            'align'     => 'left',
            'index'     => 'brand',
        ));


        $this->addColumn('brand_id', array(
            'header'    => Mage::helper('productidx')->__('Brand Id'),
            'align'     => 'left',
            'index'     => 'brand_id',
        ));

        $this->addColumn('collection', array(
            'header'    => Mage::helper('productidx')->__('Collection'),
            'align'     => 'left',
            'index'     => 'collection',
        ));        

        $this->addColumn('collection_id', array(
            'header'    => Mage::helper('productidx')->__('collection_id'),
            'align'     => 'left',
            'index'     => 'collection_id',
        ));

        $this->addColumn('description', array(
            'header'    => Mage::helper('productidx')->__('Description'),
            'align'     => 'left',
            'index'     => 'description'
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('productidx')->__('Status'),
            'align'     => 'left',
            'index'     => 'status',
            'renderer'  => 'Hp_ProductIdx_Block_Adminhtml_ProductIdx_Grid_Renderer_Status'
        ));

        return parent::_prepareColumns();
    }

    
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('idx_id' => $row->getId()));
    }
   
}