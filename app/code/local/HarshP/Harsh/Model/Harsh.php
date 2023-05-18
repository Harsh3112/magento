<?php  
/**
 * 
 */
class HarshP_Harsh_Model_Harsh extends Mage_Core_Model_Abstract
{
    protected $_attributes;
    const ENTITY = 'harsh';

	protected function _construct()
	{
		$this->_init('harsh/harsh');
	}

	public function reset()
    {
        $this->setData(array());
        $this->setOrigData();
        $this->_attributes = null;
        return $this;
    }
}

?>