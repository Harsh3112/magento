<?php

class Hp_Vendor_Helper_Data extends Mage_Core_Helper_Abstract
{

	public function __construct()
	{
	}

	public function getAccountUrl()
    {
        return $this->_getUrl('vendor/account');
    }

    public function getLoginUrl()
    {
        return $this->_getUrl('vendor/account/login');
    }

    public function getRegisterUrl()
    {
        return $this->_getUrl('vendor/account/create');
    }

    
}

