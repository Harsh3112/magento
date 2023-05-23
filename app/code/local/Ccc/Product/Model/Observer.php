<?php  
/**
 * 
 */
class Ccc_Product_Model_Observer extends Varien_Event_Observer
{
   public function __construct()
   {
        // ...
   }
   
   public function customObserver($observer)
   {
        echo 'Check Observer!';
   }
}

