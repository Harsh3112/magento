<?php
class Hp_Vendor_AccountController extends Mage_Core_Controller_Front_Action
{
	protected function _getSession()
    {
        return Mage::getSingleton('vendor/session');
    }

    protected function _getUrl($url, $params = array())
    {
        return Mage::getUrl($url, $params);
    }

    protected function _getFromRegistry($path)
    {
        return Mage::registry($path);
    }

    protected function _getVendor()
    {
        $vendor = $this->_getFromRegistry('vendor');
        if (!$vendor) {
            $vendor = Mage::getModel('vendor/vendor')->setId(null);
        }
        if ($this->getRequest()->getParam('is_subscribed', false)) {
            $vendor->setIsSubscribed(1);
        }
        /**
         * Initialize vendor group id
         */
        $vendor->getGroupId();

        return $vendor;
    }

    protected function _validateRegistrationData($data)
    {
        $errors = array();

        // Validate name
        if (empty($data['firstname'])) {
            $errors[] = 'Please enter your first name.';
        }

        // Validate email
        if (empty($data['email'])) {
            $errors[] = 'Please enter your email address.';
        } elseif (!Zend_Validate::is($data['email'], 'EmailAddress')) {
            $errors[] = 'Please enter a valid email address.';
        }


        // Validate telephone (mobile number)
        if (empty($data['mobile'])) {
            $errors[] = 'Please enter your mobile number.';
        } else {
            // Custom mobile number validation rule
            $mobileRegex = '/^[0-9]{10}$/'; // Assuming a 10-digit mobile number is required
            if (!preg_match($mobileRegex, $data['mobile'])) {
                $errors[] = 'Please enter a valid 10-digit mobile number.';
            }
        }

        // Validate password
        if (empty($data['password'])) {
            $errors[] = 'Please enter a password.';
        }

        // Validate password confirmation
        if ($data['password'] !== $data['confirmation']) {
            $errors[] = 'Password does not match.';
        }

        if (!empty($errors)) {
            return $errors;
        }

        return true;
    }

    public function createAction()
    {
        if ($this->_getSession()->isLoggedIn()) {
            $this->_redirect('*/*');
            return;
        }

        $this->loadLayout();
        $this->_initLayoutMessages('vendor/session');
        $this->renderLayout();
    }

    public function _prepareBodyContent($id)
        {
            $encryptionKey = 'cybercom'; // Replace with your encryption key
            $hashKey = base64_encode(openssl_encrypt($id, 'AES-256-CBC', $encryptionKey, 0, substr(md5($encryptionKey), 0, 16)));

            $mailUrl = Mage::getUrl('*/*/urlVerification');
            $finalUrl = $mailUrl .'key/'.$hashKey;

            $content = 'please verify the user via this url '.$finalUrl;
            return $content;
        }
       public function urlVerificationAction()
    {
        try {
            $hashKey = $this->getRequest()->getParam('key');
            if (!$hashKey) {
                Mage::throwException('Invalid URL. Please verify the mail URL.');
            }

            $encryptionKey = 'cybercom'; // Replace with your encryption key
            $vendorId = openssl_decrypt(base64_decode($hashKey), 'AES-256-CBC', $encryptionKey, 0, substr(md5($encryptionKey), 0, 16));
            $vendorModel = Mage::getModel('vendor/vendor')->load($vendorId);
            if (!$vendorModel->getId()) {
                Mage::throwException('Invalid records found. Please contact the admin.');
            }

            $vendorModel->setStatus(1);
            $vendorModel->save();

            Mage::getSingleton('core/session')->addSuccess('Vendor verification successful. Please login.');
            $this->_redirect('*/*/register');
        } catch (Exception $e) {
            Mage::getSingleton('core/session')->addError($e->getMessage());
            $this->_redirect('*/*/register');
        }
    }

    public function createpostAction()
    {
        if ($this->getRequest()->isPost()) {

            $postData = $this->getRequest()->getPost();

            if (!$postData) {
                $this->_redirect('*/*/create');
                return;
            }

            $errors = array();

            // Validate the posted data
            $validationResult = $this->_validateRegistrationData($postData);
            if ($validationResult !== true) 
            {
                $errors = $validationResult;
            } 
            else 
            {
                $vendor = Mage::getModel('vendor/vendor');
                $vendor->load($postData['email'], 'email'); // Check if the email is already registered as a vendor
                if ($vendor->getId()) {
                    $errors[] = 'Email address is already registered as a vendor.';
                } else {
                    // Create the vendor record
                    if ($postData['middlename']) {
                        $name =  $postData['firstname'].' '.$postData['middlename'].' '.$postData['lastname'];
                    }
                    else{
                        $name =  $postData['firstname'].' '.$postData['lastname'];
                    }
                    $vendor->setData('name', $name);
                    $vendor->setData('email', $postData['email']);
                    $vendor->setData('mobile', $postData['mobile']);
                    $vendor->setData('password', $postData['password']);
                    $vendor->setData('created_time', now());
                    $vendor->setData('status', 0);

                    $vendorId = $vendor->save();
                    $vendorId = $vendor->getId();
                    $vendor = Mage::getModel('vendor/vendor')->load($vendorId);

                    $content = $this->_prepareBodyContent($vendorId);
                    $this->_sendmail($vendor ,$content);
                    // Perform additional vendor registration tasks if needed

                    // Redirect to a success page or perform any other desired action
                    Mage::getSingleton('core/session')->addSuccess('Vendor registration successful.And verify the mail '.$postData['email']);
                    $this->_redirect('*/*/create');
                    return;
                }
            }

            // If there are errors, display them and redirect back to the registration form
            Mage::getSingleton('core/session')->setVendorFormData($postData);
            Mage::getSingleton('core/session')->addError(implode('<br>', $errors));
            $this->_redirect('*/*/create');
        } else {
            Mage::getSingleton('core/session')->addError("Error: Request is not allowed.");
            // Redirect the user to another page or display the error message as needed
            $this->_redirect('*/index/register');
        }
    }

    public function _sendmail($model, $content)
    {
        $vendor = $model;
        $email = $vendor->getEmail();
        $vars = array(
            'vendor' => $vendor,
            'message' => 'Hello vendor, hope you have a good day!',
        );

        $emailTemplate = Mage::getModel('core/email_template')->loadDefault('vendor_welcome_email_template');

        $processedTemplate = $emailTemplate->getProcessedTemplate($vars);

        $config = array(
            'ssl' => 'tls',
            'port' => 587,
            'auth' => 'login',
            'username' => 'mailto:harshparmarhp0@gmail.com', // Replace with your Gmail email address
            'password' => 'xxrekxzpilvdkujt', // Replace with your Gmail password or app password
        );

        $transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);

        $mail = new Zend_Mail('UTF-8');
        $mail->setBodyHtml($content);
        $mail->setfrom('harshparmarhp0@gmail.com', 'HarshP'); // Replace with your Gmail email address and name
        $mail->addTo($email, 'Vendor');
        $mail->setSubject('Welcome Vendor');
        $mail->setBodyText('Hello vendor, hope you have a good day!');

        $mail->send($transport);
        return true;
    }

    public function loginAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function loginPostAction()
    {
        echo "<pre>";
        // print_r($this->getRequest()->getPost());

        if (!$this->_validateFormKey()) {
            $this->_redirect('*/*/');
            return;
        }


        if ($this->_getSession()->isLoggedIn()) {
            $this->_redirect('*/*/');
            return;
        }
        $session = $this->_getSession();
        print_r($this->getRequest()->getPost('login'));die;

        if ($this->getRequest()->isPost()) {
            $login = $this->getRequest()->getPost('login');
            if (!empty($login['username']) && !empty($login['password'])) {
                try {
                    var_dump($session->login($login['username'], $login['password']));die;


                    if ($session->getCustomer()->getIsJustConfirmed()) {
                        $this->_welcomeCustomer($session->getCustomer(), true);
                    }
                } catch (Mage_Core_Exception $e) {
                    switch ($e->getCode()) {
                        case Mage_Customer_Model_Customer::EXCEPTION_EMAIL_NOT_CONFIRMED:
                            $value = $this->_getHelper('customer')->getEmailConfirmationUrl($login['username']);
                            $message = $this->_getHelper('customer')->__('This account is not confirmed. <a href="%s">Click here</a> to resend confirmation email.', $value);
                            break;
                        case Mage_Customer_Model_Customer::EXCEPTION_INVALID_EMAIL_OR_PASSWORD:
                            $message = $e->getMessage();
                            break;
                        default:
                            $message = $e->getMessage();
                    }
                    $session->addError($message);
                    $session->setUsername($login['username']);
                } catch (Exception $e) {
                    // Mage::logException($e); // PA DSS violation: this exception log can disclose customer password
                }
            } else {
                $session->addError($this->__('Login and password are required.'));
            }
        }

        $this->_loginPostRedirect();
    }
}