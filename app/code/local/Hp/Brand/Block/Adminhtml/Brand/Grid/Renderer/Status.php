<?php 

class Hp_Brand_Block_Adminhtml_Brand_Grid_Renderer_Status extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $status = $row->getStatus();
        $label = ($status == 1) ? 'Active' : 'Inactive';
        return $label;
    }
}
