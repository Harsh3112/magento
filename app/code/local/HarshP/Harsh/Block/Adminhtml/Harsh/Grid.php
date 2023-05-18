<?php

class HarshP_Harsh_Block_Adminhtml_Harsh_Grid extends Mage_Adminhtml_Block_Widget_Grid
{


    public function __construct()
    {
        parent::__construct();
        $this->setId('harshAdminhtmlHarshGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
    }

   protected function _prepareCollection()
    {
        $collection = Mage::getModel('harsh/harsh')->getCollection();
        /* @var $collection Mage_Cms_Model_Mysql4_Page_Collection */
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('entity_id', array(
            'header'    => Mage::helper('harsh')->__('Entity Id'),
            'align'     => 'left',
            'index'     => 'entity_id',
        ));

        $this->addColumn('first_name', array(
            'header'    => Mage::helper('harsh')->__('First Name'),
            'align'     => 'left',
            'index'     => 'first_name',
        ));

        $this->addColumn('last_name', array(
            'header'    => Mage::helper('harsh')->__('Last Name'),
            'align'     => 'left',
            'index'     => 'last_name',
        ));

        $this->addColumn('age', array(
            'header'    => Mage::helper('harsh')->__('Age'),
            'align'     => 'left',
            'index'     => 'age',
        ));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('harsh');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('harsh')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('harsh')->__('Are you sure?')
        ));
        return $this;
    }

    /**
     * Row click url
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('entity_id' => $row->getId()));
    }
   
}