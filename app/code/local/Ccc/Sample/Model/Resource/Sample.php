<?php  
/**
 * 
 */
class Ccc_Sample_Model_Resource_Sample extends Mage_Eav_Model_Entity_Abstract
{
	protected function _construct()
	{
		// $this->_init('sample/sample', 'sample_id');
		$resource = Mage::getSingleton('core/resource');
        // $this->setType('Ccc_sample_sample');
        $this->setConnection(
            $resource->getConnection('blog_read'),
            $resource->getConnection('blog_write')
        );
	}

	protected function _getDefaultAttributes()
    {
        return array(
            'entity_type_id',
            'attribute_set_id',
            'created_at',
            'updated_at',
            'increment_id',
            'store_id',
            'website_id'
        );
    }
}

?>