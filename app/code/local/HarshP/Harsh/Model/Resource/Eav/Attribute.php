<?php
class HarshP_Harsh_Model_Resource_Eav_Attribute extends Mage_Eav_Model_Entity_Attribute
{
    const SCOPE_STORE                           = 0;
    const SCOPE_GLOBAL                          = 1;
    const SCOPE_WEBSITE                         = 2;

    const MODULE_NAME                           = 'HarshP_Harsh';
    const ENTITY                                = 'harsh_eav_attribute';

    protected $_eventPrefix                     = 'harsh_entity_attribute';

    protected $_eventObject                     = 'attribute';

    static protected $_labels                   = null;

    protected function _construct()
    {
        $this->_init('harsh/attribute');
    }
}
