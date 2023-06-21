<?php

class Ccc_Practice_Block_Adminhtml_Four_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('practiceAdminhtmlPracticeGrid');
        $this->setDefaultSort('name');
        $this->setDefaultDir('ASC');
    }

    protected function _prepareCollection()
    {
        $productCollection = Mage::getModel('catalog/product')->getCollection();
        $productCollection->addAttributeToSelect(array('sku', 'image', 'thumbnail', 'small_image'));

        $productData = array();

        foreach ($productCollection as $product) {
            $productId = $product->getId();
            $sku = $product->getSku();
            $baseImage = $product->getImage();
            $thumbImage = $product->getThumbnail();
            $smallImage = $product->getSmallImage();

            $productData[] = array(
                'product_id' => $productId,
                'sku' => $sku,
                'base_image' => $baseImage,
                'thumb_image' => $thumbImage,
                'small_image' => $smallImage
            );
        }
        $collection = new Varien_Data_Collection();

        foreach ($productData as $data) {
            $row = new Varien_Object();
            $row->setData($data);
            $collection->addItem($row);
        }

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('product_id', array(
            'header'    => Mage::helper('practice')->__('Product ID'),
            'align'     => 'left',
            'index'     => 'product_id'
        ));

        $this->addColumn('sku', array(
            'header'    => Mage::helper('practice')->__('SKU'),
            'align'     => 'left',
            'index'     => 'sku'
        ));

        $this->addColumn('base_image', array(
            'header'    => Mage::helper('practice')->__('Base Image'),
            'align'     => 'left',
            'index'     => 'base_image',
            'renderer'  => 'Ccc_Practice_Block_Adminhtml_Four_Grid_Renderer_Image'
        ));

        $this->addColumn('thumb_image', array(
            'header'    => Mage::helper('practice')->__('Thumb Image'),
            'align'     => 'left',
            'index'     => 'thumb_image',
            'renderer'  => 'Ccc_Practice_Block_Adminhtml_Four_Grid_Renderer_Image'

        ));

        $this->addColumn('small_image', array(
            'header'    => Mage::helper('practice')->__('Small Image'),
            'align'     => 'left',
            'index'     => 'small_image',
            'renderer'  => 'Ccc_Practice_Block_Adminhtml_Four_Grid_Renderer_Image'

        ));

        return parent::_prepareColumns();
    }
}