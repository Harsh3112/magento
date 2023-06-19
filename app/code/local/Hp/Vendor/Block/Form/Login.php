<?php
class Hp_Vendor_Block_Form_Login extends Mage_Core_Block_Template
{
    function __construct()
    {
        parent::__construct();
    }

    public function getCreateAccountUrl()
    {
        $url = $this->helper('vendor')->getRegisterUrl();
        return $url;
    }
}
