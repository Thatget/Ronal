<?php
namespace Command\Log\Controller\Adminhtml\Index;


use Magento\Backend\App\Action;
use Command\Log\Model\ResourceModel\Check\CollectionFactory;
use Magento\Ui\Component\MassAction\Filter;


class MassDelete extends \Magento\Backend\App\Action
{
    protected $_coreRegistry = null;
    protected $resultPageFactory;
    protected $moduleFactory;

    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry,
        Filter $filter,
        CollectionFactory $module
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->moduleFactory = $module;
        $this->filter = $filter;
        parent::__construct($context);
    }

    public function execute()
    {
        $collection = $this->filter->getCollection($this->moduleFactory->create());
        $collectionSize = $collection->getSize();
        foreach ($collection as $item){
            $item->delete();
        }
        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $collectionSize));
        $resultRedirect   =   $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        return $resultRedirect;
    }
}
