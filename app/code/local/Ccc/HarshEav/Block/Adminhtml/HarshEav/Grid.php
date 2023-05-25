<?php 

class Ccc_HarshEav_Block_Adminhtml_HarshEav_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct(){
		parent::__construct();
		$this->setId('harsheavId');
		$this->setDefaultSort('entity_Id');
		$this->setDeafultDir('DESC');
		$this->setSaveParametersInSession(true);
		$this->setVarNameFilter('harsheav_filter');
	}

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('harsheav/harsheav')->getCollection()
            ->addAttributeToSelect('firstname')
            ->addAttributeToSelect('lastname')
            ->addAttributeToSelect('email')
            ->addAttributeToSelect('phoneNo')
            ->addAttributeToSelect('gender')
            ->addAttributeToSelect('new')
            ->addAttributeToSelect('price_attribute');

        // $attributeCodes = Mage::getResourceModel('harsheav/harsheav_attribute_collection')->getItems();
        // echo "<pre>";
        // print_r($attributeCodes);die;
        // foreach ($attributeCodes as $attributeCode) {
            // $collection->addAttributeToSelect($attributeCode->attribute_code);
        // }

        $adminStore = Mage_Core_Model_App::ADMIN_STORE_ID;
       
        $collection->joinAttribute(
            'id',
            'harsheav/entity_id',
            'entity_id',
            null,
            'inner',
            $adminStore
        );

        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }

	protected function _prepareColumns()
    {
        $this->addColumn('id',
            array(
                'header' => Mage::helper('harsheav')->__('id'),
                'width'  => '50px',
                'index'  => 'id',
            ));
        $this->addColumn('firstname',
            array(
                'header' => Mage::helper('harsheav')->__('First Name'),
                'width'  => '50px',
                'index'  => 'firstname',
            ));

        $this->addColumn('lastname',
            array(
                'header' => Mage::helper('harsheav')->__('Last Name'),
                'width'  => '50px',
                'index'  => 'lastname',
            ));

        $this->addColumn('email',
            array(
                'header' => Mage::helper('harsheav')->__('Email'),
                'width'  => '50px',
                'index'  => 'email',
            ));

        $this->addColumn('gender',
            array(
                'header' => Mage::helper('harsheav')->__('Gender'),
                'width'  => '50px',
                'index'  => 'gender',
                'renderer' => 'Ccc_HarshEav_Block_Adminhtml_HarshEav_Grid_Renderer_Gender'
            ));

        $this->addColumn('new',
            array(
                'header' => Mage::helper('harsheav')->__('New'),
                'width'  => '50px',
                'index'  => 'new',
            ));
        
        parent::_prepareColumns();
        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array(
            'id'    => $row->getId())
        );
    }
}