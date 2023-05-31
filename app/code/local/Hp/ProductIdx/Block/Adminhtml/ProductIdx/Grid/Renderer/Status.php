<?php 

class Hp_ProductIdx_Block_Adminhtml_ProductIdx_Grid_Renderer_Status extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $status = $row->getStatus();
        $label = ($status == 1) ? 'Active' : 'Inactive';
        return $label;
    }
}
