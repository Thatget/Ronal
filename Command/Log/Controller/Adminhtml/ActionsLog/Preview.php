<?php

namespace Command\Log\Controller\Adminhtml\ActionsLog;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\RawFactory;
use Magento\Framework\View\LayoutFactory;

class Preview extends Action{

    protected $_rawFactory;
    protected $_layoutFactory;

    public function __construct(
        Action\Context $context,
        RawFactory $rawFactory,
        LayoutFactory $layoutFactory
    )
    {
        $this->_rawFactory = $rawFactory;
        $this->_layoutFactory = $layoutFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $content = $this->_layoutFactory->create()
            ->createBlock(\Command\Log\Block\Adminhtml\Index::class);
        $result = $this->_rawFactory->create();
        return $result->setContents($content->toHtml());
    }
}
