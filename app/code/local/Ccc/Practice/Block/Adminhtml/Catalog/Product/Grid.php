<?php

class Ccc_Practice_Block_Adminhtml_Catalog_Product_Grid extends Mage_Adminhtml_Block_Catalog_Product_Grid
{
    protected function _prepareColumns()
    {
        $columns = parent::_prepareColumns();

        $this->removeColumn('name');
        $this->addColumn('hello',
            array(
                'header'=> Mage::helper('catalog')->__('Hello'),
                'width' => '80px',
        ));

        return $columns;
    }
}
