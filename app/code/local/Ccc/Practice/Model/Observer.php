<?php  
/**
 * 
 */
class Ccc_Practice_Model_Observer extends Varien_Event_Observer
{
   public function __construct()
   {
   }
   
   public function customObserver($observer)
   {
        // echo "111";die;

        $event = $observer->getEvent();    
        echo "<pre>";
        // print_r($event);die;
        $model = $event->getPage();
        print_r($model->getData());
        die('test');
   }
}

