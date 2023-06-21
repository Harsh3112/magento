<?php

class Hp_Vendor_Model_Session extends Mage_Core_Model_Session_Abstract
{
    /**
     * Vendor object
     *
     * @var Hp_Vendor_Model_Vendor
     */
    protected $_customer;

    /**
     * Flag with customer id validations result
     *
     * @var bool
     */
    protected $_isVendorIdChecked = null;

    /**
     * Persistent customer group id
     *
     * @var null|int
     */
    protected $_persistentVendorGroupId = null;

    /**
     * Retrieve customer sharing configuration model
     *
     * @return Hp_Vendor_Model_Config_Share
     */
    public function getVendorConfigShare()
    {
        return Mage::getSingleton('customer/config_share');
    }

    public function __construct()
    {
        $namespace = 'customer';
        if ($this->getVendorConfigShare()->isWebsiteScope()) {
            $namespace .= '_' . (Mage::app()->getStore()->getWebsite()->getCode());
        }

        $this->init($namespace);
        Mage::dispatchEvent('customer_session_init', array('customer_session'=>$this));
    }

    /**
     * Set customer object and setting customer id in session
     *
     * @param   Hp_Vendor_Model_Vendor $customer
     * @return  Hp_Vendor_Model_Session
     */
    public function setVendor(Hp_Vendor_Model_Vendor $customer)
    {
        // check if customer is not confirmed
        if ($customer->isConfirmationRequired()) {
            if ($customer->getConfirmation()) {
                return $this->_logout();
            }
        }
        $this->_customer = $customer;
        $this->setId($customer->getId());
        // save customer as confirmed, if it is not
        if ((!$customer->isConfirmationRequired()) && $customer->getConfirmation()) {
            $customer->setConfirmation(null)->save();
            $customer->setIsJustConfirmed(true);
        }
        return $this;
    }

    /**
     * Retrieve customer model object
     *
     * @return Hp_Vendor_Model_Vendor
     */
    public function getVendor()
    {
        if ($this->_customer instanceof Hp_Vendor_Model_Vendor) {
            return $this->_customer;
        }

        $customer = Mage::getModel('vendor/vendor')
            ->setWebsiteId(Mage::app()->getStore()->getWebsiteId());
        if ($this->getId()) {
            $customer->load($this->getId());
        }

        $this->setVendor($customer);
        return $this->_customer;
    }

    /**
     * Set customer id
     *
     * @param int|null $id
     * @return Hp_Vendor_Model_Session
     */
    public function setVendorId($id)
    {
        $this->setData('customer_id', $id);
        return $this;
    }

    /**
     * Retrieve customer id from current session
     *
     * @return int|null
     */
    public function getVendorId()
    {
        if ($this->getData('customer_id')) {
            return $this->getData('customer_id');
        }
        return ($this->isLoggedIn()) ? $this->getId() : null;
    }

    /**
     * Set customer group id
     *
     * @param int|null $id
     * @return Hp_Vendor_Model_Session
     */
    public function setVendorGroupId($id)
    {
        $this->setData('customer_group_id', $id);
        return $this;
    }

    /**
     * Get customer group id
     * If customer is not logged in system, 'not logged in' group id will be returned
     *
     * @return int
     */
    public function getVendorGroupId()
    {
        if ($this->getData('customer_group_id')) {
            return $this->getData('customer_group_id');
        }
        if ($this->isLoggedIn() && $this->getVendor()) {
            return $this->getVendor()->getGroupId();
        }
        return Hp_Vendor_Model_Group::NOT_LOGGED_IN_ID;
    }

    /**
     * Checking customer login status
     *
     * @return bool
     */
    public function isLoggedIn()
    {
        return (bool)$this->getId() && (bool)$this->checkVendorId($this->getId());
    }

    /**
     * Check exists customer (light check)
     *
     * @param int $customerId
     * @return bool
     */
    public function checkVendorId($customerId)
    {
        if ($this->_isVendorIdChecked === null) {
            $this->_isVendorIdChecked = Mage::getResourceSingleton('customer/customer')->checkVendorId($customerId);
        }
        return $this->_isVendorIdChecked;
    }

    /**
     * Vendor authorization
     *
     * @param   string $username
     * @param   string $password
     * @return  bool
     */
    public function login($email, $password)
    {
        /* @var $vendor Hp_Vendor_Model_Vendor */
        $vendor = Mage::getModel('vendor/vendor')
            ->setWebsiteId(Mage::app()->getStore()->getWebsiteId());

        if ($vendor->authenticate($email, $password)) {
            $this->setVendorAsLoggedIn($vendor);
            return true;
        }
        return false;
    }

    public function setVendorAsLoggedIn($customer)
    {
        $this->setVendor($customer);
        $this->renewSession();
        Mage::getSingleton('core/session')->renewFormKey();
        Mage::dispatchEvent('customer_login', array('customer'=>$customer));
        return $this;
    }

    /**
     * Authorization customer by identifier
     *
     * @param   int $customerId
     * @return  bool
     */
    public function loginById($customerId)
    {
        $customer = Mage::getModel('customer/customer')->load($customerId);
        if ($customer->getId()) {
            $this->setVendorAsLoggedIn($customer);
            return true;
        }
        return false;
    }

    /**
     * Logout customer
     *
     * @return Hp_Vendor_Model_Session
     */
    public function logout()
    {
        if ($this->isLoggedIn()) {
            Mage::dispatchEvent('customer_logout', array('customer' => $this->getVendor()) );
            $this->_logout();
        }
        return $this;
    }

    /**
     * Authenticate controller action by login customer
     *
     * @param   Mage_Core_Controller_Varien_Action $action
     * @param   bool $loginUrl
     * @return  bool
     */
    public function authenticate(Mage_Core_Controller_Varien_Action $action, $loginUrl = null)
    {
        if ($this->isLoggedIn()) {
            return true;
        }

        $this->setBeforeAuthUrl(Mage::getUrl('*/*/*', array('_current' => true)));
        if (isset($loginUrl)) {
            $action->getResponse()->setRedirect($loginUrl);
        } else {
            $action->setRedirectWithCookieCheck(Hp_Vendor_Helper_Data::ROUTE_ACCOUNT_LOGIN,
                Mage::helper('customer')->getLoginUrlParams()
            );
        }

        return false;
    }

    /**
     * Set auth url
     *
     * @param string $key
     * @param string $url
     * @return Hp_Vendor_Model_Session
     */
    protected function _setAuthUrl($key, $url)
    {
        $url = Mage::helper('core/url')
            ->removeRequestParam($url, Mage::getSingleton('core/session')->getSessionIdQueryParam());
        // Add correct session ID to URL if needed
        $url = Mage::getModel('core/url')->getRebuiltUrl($url);
        return $this->setData($key, $url);
    }

    /**
     * Logout without dispatching event
     *
     * @return Hp_Vendor_Model_Session
     */
    protected function _logout()
    {
        $this->setId(null);
        $this->setVendorGroupId(Hp_Vendor_Model_Group::NOT_LOGGED_IN_ID);
        $this->getCookie()->delete($this->getSessionName());
        Mage::getSingleton('core/session')->renewFormKey();
        return $this;
    }

    /**
     * Set Before auth url
     *
     * @param string $url
     * @return Hp_Vendor_Model_Session
     */
    public function setBeforeAuthUrl($url)
    {
        return $this->_setAuthUrl('before_auth_url', $url);
    }

    /**
     * Set After auth url
     *
     * @param string $url
     * @return Hp_Vendor_Model_Session
     */
    public function setAfterAuthUrl($url)
    {
        return $this->_setAuthUrl('after_auth_url', $url);
    }

    /**
     * Reset core session hosts after reseting session ID
     *
     * @return Hp_Vendor_Model_Session
     */
    public function renewSession()
    {
        parent::renewSession();
        Mage::getSingleton('core/session')->unsSessionHosts();

        return $this;
    }
}
