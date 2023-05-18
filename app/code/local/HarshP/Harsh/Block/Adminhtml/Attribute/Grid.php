<?php
class HarshP_Harsh_Block_Adminhtml_Attribute_Grid extends Mage_Eav_Block_Adminhtml_Attribute_Grid_Abstract
{

    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('harsh/attribute_collection');
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        parent::_prepareColumns();

        $this->addColumnAfter('is_visible', array(
            'header'=>Mage::helper('harsh')->__('Visible'),
            'sortable'=>true,
            'index'=>'is_visible_on_front',
            'type' => 'options',
            'options' => array(
                '1' => Mage::helper('harsh')->__('Yes'),
                '0' => Mage::helper('harsh')->__('No'),
            ),
            'align' => 'center',
        ), 'frontend_label');

        $this->addColumnAfter('is_global', array(
            'header'=>Mage::helper('harsh')->__('Scope'),
            'sortable'=>true,
            'index'=>'is_global',
            'type' => 'options',
            'options' => array(
                Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE =>Mage::helper('harsh')->__('Store View'),
                Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_WEBSITE =>Mage::helper('harsh')->__('Website'),
                Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL =>Mage::helper('harsh')->__('Global'),
            ),
            'align' => 'center',
        ), 'is_visible');

        $this->addColumn('is_searchable', array(
            'header'=>Mage::helper('harsh')->__('Searchable'),
            'sortable'=>true,
            'index'=>'is_searchable',
            'type' => 'options',
            'options' => array(
                '1' => Mage::helper('harsh')->__('Yes'),
                '0' => Mage::helper('harsh')->__('No'),
            ),
            'align' => 'center',
        ), 'is_user_defined');

        $this->addColumnAfter('is_filterable', array(
            'header'=>Mage::helper('harsh')->__('Use in Layered Navigation'),
            'sortable'=>true,
            'index'=>'is_filterable',
            'type' => 'options',
            'options' => array(
                '1' => Mage::helper('harsh')->__('Filterable (with results)'),
                '2' => Mage::helper('harsh')->__('Filterable (no results)'),
                '0' => Mage::helper('harsh')->__('No'),
            ),
            'align' => 'center',
        ), 'is_searchable');

        $this->addColumnAfter('is_comparable', array(
            'header'=>Mage::helper('harsh')->__('Comparable'),
            'sortable'=>true,
            'index'=>'is_comparable',
            'type' => 'options',
            'options' => array(
                '1' => Mage::helper('harsh')->__('Yes'),
                '0' => Mage::helper('harsh')->__('No'),
            ),
            'align' => 'center',
        ), 'is_filterable');

        return $this;
    }
}
