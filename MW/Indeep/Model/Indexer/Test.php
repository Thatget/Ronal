<?php
namespace MW\Indeep\Model\Indexer;
class Test implements \Magento\Framework\Indexer\ActionInterface, \Magento\Framework\Mview\ActionInterface
{
    public function execute($ids){
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/lot_debug.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info("Test Cron Job in DailyDeal module");

        return $this;
    }

    /*
     * Will take all of the data and reindex
     * Will run when reindex via command line
     */
    public function executeFull(){
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/right_debug.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info("Test Cron Job in DailyDeal module executefull");

        return $this;
    }


    /*
     * Works with a set of entity changed (may be massaction)
     */
    public function executeList(array $ids){
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/for_debug.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info("Test Cron Job in DailyDeal module execute list");

        return $this;
    }


    /*
     * Works in runtime for a single entity using plugins
     */
    public function executeRow($id){
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/be_debug.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info("Test Cron Job in DailyDeal module executeRow");

        return $this;
    }
}
