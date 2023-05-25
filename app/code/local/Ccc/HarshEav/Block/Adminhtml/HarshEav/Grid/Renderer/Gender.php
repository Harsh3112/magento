<?php

/**
 * 
 */
class Ccc_HarshEav_Block_Adminhtml_HarshEav_Grid_Renderer_Gender extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
	public function render(Varien_Object $row)
	{
		$attributeCodes = Mage::getResourceModel('harsheav/harsheav_attribute_collection')->getOptions();
		echo "<pre>";
        print_r($attributeCodes);die;
        foreach ($attributeCodes as $attributeCode) {
            $label = $attributeCode->attribute_code;
        }
        // $gender = $row->getGender();
		// if($gender = 7){
		// 	$label = 'Male';
		// }
		return $label;
	}
	
}