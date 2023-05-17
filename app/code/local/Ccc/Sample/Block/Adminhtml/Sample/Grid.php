<?php

class Ccc_Sample_Block_Adminhtml_Sample_Grid extends Mage_Adminhtml_Block_Widget_Grid
{


    public function __construct()
    {
        parent::__construct();
        $this->setId('sampleAdminhtmlSampleGrid');
        $this->setDefaultSort('sample_id');
        $this->setDefaultDir('ASC');
    }

   protected function _prepareCollection()
    {
        $collection = Mage::getModel('sample/sample')->getCollection();
        // echo "<pre>";print_r($collection);
        /* @var $collection Mage_Cms_Model_Mysql4_Page_Collection */
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('sample_id', array(
            'header'    => Mage::helper('sample')->__('Sample Id'),
            'align'     => 'left',
            'index'     => 'sample_id',
        ));

        $this->addColumn('name', array(
            'header'    => Mage::helper('sample')->__('Name'),
            'align'     => 'left',
            'index'     => 'name',
        ));

        return parent::_prepareColumns();
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

        // $this->getMassactionBlock()->addItem('newsletter_subscribe', array(
        //      'label'    => Mage::helper('customer')->__('Subscribe to Newsletter'),
        //      'url'      => $this->getUrl('*/*/massSubscribe')
        // ));

        // $this->getMassactionBlock()->addItem('newsletter_unsubscribe', array(
        //      'label'    => Mage::helper('customer')->__('Unsubscribe from Newsletter'),
        //      'url'      => $this->getUrl('*/*/massUnsubscribe')
        // ));

        // $groups = $this->helper('salesman')->getGroups()->toOptionArray();

        // array_unshift($groups, array('label'=> '', 'value'=> ''));
        // $this->getMassactionBlock()->addItem('assign_group', array(
        //      'label'        => Mage::helper('salesman')->__('Assign a Salesman Group'),
        //      'url'          => $this->getUrl('*/*/massAssignGroup'),
        //      'additional'   => array(
        //         'visibility'    => array(
        //              'name'     => 'group',
        //              'type'     => 'select',
        //              'class'    => 'required-entry',
        //              'label'    => Mage::helper('salesman')->__('Group'),
        //              'values'   => $groups
        //          )
        //     )
        // ));

        return $this;
    }

    /**
     * Row click url
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('sample_id' => $row->getId()));
    }
   
}