<?php


class Hp_Brand_Model_Observer
{
    public function generateBrandRewriteUrl($observer)
    {
        $brand = $observer->getBrand();
        $urlKey = $brand->getUrlKey();
        echo $brand->getId();
        $rewrite = Mage::getModel('core/url_rewrite');
        $rewrite->setStoreId($brand->getStoreId())
                ->setIdPath('brand/' . $brand->getId())
                ->setRequestPath('brand/' . $urlKey)
                ->setTargetPath('brand/view/index/brand_id/'. $brand->getId())
                ->setIsSystem(0)
                ->setOptions('')
                ->setDescription('')
                ->save();
    }
}