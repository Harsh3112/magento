<?php 

class Ccc_Practice_Block_Adminhtml_Four_Grid_Renderer_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $imagePath = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . 'catalog/product' . $row->getData($this->getColumn()->getIndex());
        
        $html = '';
        if ($imagePath) {
            $html = '<img src="' . $imagePath . '" width="100" height="100" />';
        }
        
        return $html;

    }
}
