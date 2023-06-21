<?php

class Ccc_Practice_Block_Adminhtml_Seven_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        
        $collection = Mage::getModel('sales/order')->getCollection()
            ->addAttributeToSelect('customer_id','entity_id');

        $collection->getSelect()
            ->joinRight(
                array('ce' => Mage::getSingleton('core/resource')->getTableName('customer_entity')),
                'ce.entity_id = main_table.customer_id',
                array('status'=>'main_table.status','order_status_count'=>'COUNT(main_table.entity_id)','email'=>'ce.email','customer_id'=>'ce.entity_id')
            )->joinRight(
                array('cev'=>Mage::getSingleton('core/resource')->getTableName('customer_entity_varchar')),
                'cev.entity_id = ce.entity_id',
                array('firstname'=>'cev.value')
            )->where('cev.attribute_id = 5');

        $collection->getSelect()->group('main_table.status');

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('customer_id', array( 
            'header'    => Mage::helper('practice')->__('Customer Id'),
            'align'     => 'left',
            'index'     => 'customer_id',
        ));

        $this->addColumn('firstname', array( 
            'header'    => Mage::helper('practice')->__('Name'),
            'align'     => 'left',
            'index'     => 'firstname',
        ));

        $this->addColumn('email', array( 
            'header'    => Mage::helper('practice')->__('Email'),
            'align'     => 'left',
            'index'     => 'email',
        ));

        $this->addColumn('status', array( 
            'header'    => Mage::helper('practice')->__('Order Status'),
            'align'     => 'left',
            'index'     => 'status',
        ));

        $this->addColumn('order_status_count', array( 
            'header'    => Mage::helper('practice')->__('Order Count'),
            'align'     => 'left',
            'index'     => 'order_status_count',
        ));

        return parent::_prepareColumns();
    }
}