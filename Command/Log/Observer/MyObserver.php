<?php
namespace Command\Log\Observer;

use Magento\Backend\Model\Session;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Stdlib\DateTime\DateTime;

class MyObserver implements ObserverInterface
{
    protected $_checkFactory;
    protected $_session;
    protected $_dataTime;

    public function __construct(
        \Command\Log\Model\CheckFactory $checkFactory,
        Session $session,
        DateTime $dateTime
    ){
        $this->_dataTime = $dateTime;
        $this->_session = $session;
        $this->_checkFactory = $checkFactory;
    }

    public function execute(\Magento\Framework\Event\Observer $observer){
        $myEventData01 = $observer->getData('condition');
        $myEventData02 = $observer->getData('value');
        $model = $this->_checkFactory->create();
        if ($myEventData01){
            $data = ['input'=> $myEventData02];
            $model->setData($data);
            $model->save();
            $this->_session->setId($model->getId());
        }else{
            $id = $this->_session->getId();
            $data = ['id'=>$id,'output'=>$myEventData02,'end_time'=>$this->_dataTime->gmtDate()];
            $model->setData($data);
            $model->save();
            $this->_session->unsetId();
        }
    }
}
