<?php  
/**
 * 
 */
class Ccc_AdminGrid_Block_Adminhtml_Addgrid_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setDefaultSort('id');
		$this->setId('admingrid_addgrid_grid');
		$this->setDefaultDir('asc');
		$this->setSaveParametersInSession(true);
	}

	protected function _getCollectionClass()
	{
		return 'admingrid/addgrid_collection';
	}

	protected function _prepareCollection()
	{
		$collection = Mage::getResourceModel($this->_getCollectionClass());
		$this->setCollection($collection);

		return parent::_prepareCollection();
	}

	protected function _prepareColumns()
	{
		$this->addColumn('id', 
			array(
				'header' => $this->__('ID'),
				'align' => 'right',
				'width' => '50px'
				'index' => 'id'
			)
		);

		$this->addColumn('item',
			array(
				'header' => $this->__('items'),
				'index' => 'item'
			)
		);
		return parent::_prepareColumns();
	}	
}

?>