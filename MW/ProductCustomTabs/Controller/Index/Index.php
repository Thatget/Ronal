<?php
namespace MW\ProductCustomTabs\Controller\Index;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Sales\Api\OrderRepositoryInterface;

class Index extends Action {

    protected $_productFactory;
    protected $_order;

    public function __construct(
        Context $context,
        ProductFactory $productFactory,
        OrderRepositoryInterface $orderRepository
    )
    {
        $this->_order = $orderRepository;
        $this->_productFactory = $productFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $display = $this->_productFactory->create()->load(25);
        $out = $this->_order->
        var_dump($display->getSku());
        die('!1');
    }
}