<?php

namespace Command\Log\Controller\Adminhtml\ActionsLog;

use Magento\Backend\App\Action\Context;
use Magento\Backend\App\Action;

class Preview extends Action
{

    public $resultRawFactory;
    public $layoutFactory;

    public function __construct(
        Context $context,
        \Magento\Framework\Controller\Result\RawFactory $resultRawFactory,
        \Magento\Framework\View\LayoutFactory $layoutFactory
    ) {
        $this->resultRawFactory = $resultRawFactory;
        $this->layoutFactory = $layoutFactory;

        parent::__construct($context);
    }

    public function execute()
    {
        $content = $this->layoutFactory->create()
            ->createBlock(
                \Command\Log\Block\Adminhtml\ActionsLog\Preview::class
            );

        $resultRaw = $this->resultRawFactory->create();
        return $resultRaw->setContents($content->toHtml());
    }
}