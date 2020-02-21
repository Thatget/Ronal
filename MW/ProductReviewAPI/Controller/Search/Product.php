<?php

namespace MW\ProductReviewAPI\Controller\Search;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Data\Form\FormKey\Validator as FormKeyValidator;
use Magento\Framework\Exception\NoSuchEntityException;
use MW\ProductReviewAPI\Controller\Product as ProductController;;
use Magento\Framework\Controller\ResultFactory;

class Product extends ProductController
{
    public function execute()
    {
        if (!$this->initProduct()) {
            /** @var \Magento\Framework\Controller\Result\Forward $resultForward */
            $resultForward = $this->resultFactory->create(ResultFactory::TYPE_FORWARD);
            return $resultForward->forward('noroute');
        }

        $keyword = (string)$this->getRequest()->getParam('key');
        if($keyword) {
            $this->coreRegistry->register('search_keyword', $keyword);
        }

//        $sortBy = (string)$this->getRequest()->getParam('sort_by');
//        if($sortBy) {
//            $this->coreRegistry->register('sort_by', $sortBy);
//        }

        $filter = (string)$this->getRequest()->getParam('filter');
        if($filter) {
            $this->coreRegistry->register('filter', $filter);
        }

        return $this->resultFactory->create(ResultFactory::TYPE_LAYOUT);
    }
}
