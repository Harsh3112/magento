<?php
class Ccc_Sample_Block_Adminhtml_Sample_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('sample_id');
        $this->setDefaultSort('sample_id');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('sample/sample')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('sample_id', array(
            'header'    => Mage::helper('sample')->__('Sample Id'),
            'width'     => '50px',
            'index'     => 'sample_id',
            'type'  => 'number',
        ));

        $this->addColumn('name', array(
            'header'    => Mage::helper('sample')->__('Name'),
            'index'     => 'name'
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('sample')->__('Status'),
            'index'     => 'status'
        ));

        $this->addColumn('created_time', array(
            'header'    => Mage::helper('sample')->__('Created Time'),
            'index'     => 'created_time'
        ));

        $this->addColumn('update_time', array(
            'header'    => Mage::helper('sample')->__('Update Time'),
            'index'     => 'update_time'
        ));
        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id'=>$row->getId()));
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('sample_id');
        $this->getMassactionBlock()->setFormFieldName('sample');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('sample')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('sample')->__('Are you sure?')
        ));
        return $this;
    }
}
