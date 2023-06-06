<?php

class Hp_Banner_Block_Adminhtml_Banner_Group_Edit_Tab_Image extends Mage_Adminhtml_Block_Widget_Form
{
    public function _construct()
    {
        $this->setTemplate('banner/image.phtml');
    }

    public function getBannerCollection()
    {
        $collection = Mage::getModel('banner/banner')->getCollection();
        $collection->addFieldToFilter('group_id',$this->getRequest()->getParam('group_id'));
        return $collection;
    }
}





    