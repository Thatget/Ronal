<?php
namespace Command\Log\Observer;

use Magento\Framework\Event\ObserverInterface;

class MyObserver implements ObserverInterface
{
    public function __construct(){

    }

    public function execute(\Magento\Framework\Event\Observer $observer){
    $myEventData = $observer->getData('myEventData');
    die('Aasdf');

    }
}
