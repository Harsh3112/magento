<?php
class HarshP_Harsh_Model_Resource_Attribute_Collection
    extends Mage_Eav_Model_Resource_Entity_Attribute_Collection
{
   
    protected function _construct()
    {
        $this->_init('eav/entity_attribute');
    }

    protected function _initSelect()
    {
        $entityTypeId = (int)Mage::getModel('eav/entity')->setType(HarshP_Harsh_Model_Harsh::ENTITY)->getTypeId();
        $columns = $this->getConnection()->describeTable($this->getResource()->getMainTable());
        unset($columns['attribute_id']);
        $retColumns = array();
        foreach ($columns as $labelColumn => $columnData) {
            $retColumns[$labelColumn] = $labelColumn;
            if ($columnData['DATA_TYPE'] == Varien_Db_Ddl_Table::TYPE_TEXT) {
                $retColumns[$labelColumn] = Mage::getResourceHelper('core')->castField('main_table.'.$labelColumn);
            }
        }
        $this->getSelect()
            ->from(array('main_table' => $this->getResource()->getMainTable()), $retColumns)
            // ->join(
            //     array('additional_table' => $this->getTable('catalog/eav_attribute')),
            //     'additional_table.attribute_id = main_table.attribute_id'
            //     )
            ->where('main_table.entity_type_id = ?', $entityTypeId);
        return $this;
    }

    public function setEntityTypeFilter($typeId)
    {
        return $this;
    }

    // protected function _getLoadDataFields()
    // {
    //     $fields = array_merge(
    //         parent::_getLoadDataFields(),
    //         array(
    //             'additional_table.is_global',
    //             'additional_table.is_html_allowed_on_front',
    //             'additional_table.is_wysiwyg_enabled'
    //         )
    //     );

    //     return $fields;
    // }

    // public function removePriceFilter()
    // {
    //     return $this->addFieldToFilter('main_table.attribute_code', array('neq' => 'price'));
    // }

    // public function addDisplayInAdvancedSearchFilter()
    // {
    //     return $this->addFieldToFilter('additional_table.is_visible_in_advanced_search', 1);
    // }

    // public function addIsFilterableFilter()
    // {
    //     return $this->addFieldToFilter('additional_table.is_filterable', array('gt' => 0));
    // }

    // public function addIsFilterableInSearchFilter()
    // {
    //     return $this->addFieldToFilter('additional_table.is_filterable_in_search', array('gt' => 0));
    // }

    // public function addVisibleFilter()
    // {
    //     return $this->addFieldToFilter('additional_table.is_visible', 1);
    // }

    // public function addIsSearchableFilter()
    // {
    //     return $this->addFieldToFilter('additional_table.is_searchable', 1);
    // }

    // public function addToIndexFilter($addRequiredCodes = false)
    // {
    //     $conditions = array(
    //         'additional_table.is_searchable = 1',
    //         'additional_table.is_visible_in_advanced_search = 1',
    //         'additional_table.is_filterable > 0',
    //         'additional_table.is_filterable_in_search = 1',
    //         'additional_table.used_for_sort_by = 1'
    //     );

    //     if ($addRequiredCodes) {
    //         $conditions[] = $this->getConnection()->quoteInto('main_table.attribute_code IN (?)',
    //             array('status', 'visibility'));
    //     }

    //     $this->getSelect()->where(sprintf('(%s)', implode(' OR ', $conditions)));

    //     return $this;
    // }

    // public function addSearchableAttributeFilter()
    // {
    //     $this->getSelect()->where(
    //         'additional_table.is_searchable = 1 OR '.
    //         $this->getConnection()->quoteInto('main_table.attribute_code IN (?)', array('status', 'visibility'))
    //     );

    //     return $this;
    // }
}
