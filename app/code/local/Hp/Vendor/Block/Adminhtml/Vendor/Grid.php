<?php

class Hp_Vendor_Block_Adminhtml_Vendor_Grid extends Mage_Adminhtml_Block_Widget_Grid
{


    public function __construct()
    {
        parent::__construct();
        $this->setId('vendorAdminhtmlVendorGrid');
        $this->setDefaultSort('vendor_id');
        $this->setDefaultDir('ASC');
    }

   protected function _prepareCollection()
    {
        $collection = Mage::getModel('vendor/vendor')->getCollection();
        /* @var $collection Mage_Cms_Model_Mysql4_Page_Collection */
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('name', array(
            'header'    => Mage::helper('vendor')->__('Name'),
            'align'     => 'left',
            'index'     => 'name',
        ));

        $this->addColumn('mobile', array(
            'header'    => Mage::helper('vendor')->__('mobile'),
            'align'     => 'left',
            'index'     => 'mobile'
        ));

        $this->addColumn('email', array(
            'header'    => Mage::helper('vendor')->__('Email'),
            'align'     => 'left',
            'index'     => 'email'
        ));

        $this->addColumn('gender', array(
            'header'    => Mage::helper('vendor')->__('Gender'),
            'align'     => 'left',
            'index'     => 'gender',
            'renderer' => 'Hp_Vendor_Block_Adminhtml_Vendor_Grid_Renderer_Gender',

        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('vendor')->__('Status'),
            'align'     => 'left',
            'index'     => 'status',
            'renderer' => 'Hp_Vendor_Block_Adminhtml_Vendor_Grid_Renderer_Status',
        ));

        $this->addColumn('created_time', array(
            'header'    => Mage::helper('vendor')->__('Created At'),
            'align'     => 'left',
            'index'     => 'created_time',
            'type'      => 'datetime',
        ));

        $this->addColumn('update_time', array(
            'header'    => Mage::helper('vendor')->__('Update Time'),
            'align'     => 'left',
            'index'     => 'update_time',
            'type'      => 'datetime',
        ));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('vendor_id');
        $this->getMassactionBlock()->setFormFieldName('vendor');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('vendor')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('vendor')->__('Are you sure?')
        ));

        $statuses = [1=>'Active',2=>'Inactive'];

        $this->getMassactionBlock()->addItem('status', array(
             'label'    => Mage::helper('vendor')->__('Status'),
             'url'      => $this->getUrl('*/*/massStatus'),
             // 'confirm'  => Mage::helper('vendor')->__('Are you sure?'),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('catalog')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));

        return $this;
    }

    
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('vendor_id' => $row->getId()));
    }
   
}