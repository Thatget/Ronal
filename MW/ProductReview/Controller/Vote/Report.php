<?php

namespace MW\ProductReview\Controller\Vote;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Data\Form\FormKey\Validator as FormKeyValidator;
use Magento\Framework\Exception\NoSuchEntityException;
use MW\ProductReview\Controller\Review;
use Magento\Framework\Controller\ResultFactory;

class Report extends Review
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;
    /**
     * Design package instance
     *
     * @var \Magento\Framework\View\DesignInterface
     */
    protected $_design = null;

    /**
     * @var FormKeyValidator
     */
    private $formKeyValidator;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    protected  $timezone;

    /**
     * @var \MW\ProductReview\Model\ReportFactory
     */
    protected $reportFactory;
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;


    public function __construct(
        Context $context,
        \Magento\Framework\View\DesignInterface $design,
        \Magento\Customer\Model\Session $customerSession,
        FormKeyValidator $formKeyValidator,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone,
        \MW\ProductReview\Model\ReportFactory $reportFactory,
        ProductRepositoryInterface $productRepository
    ) {
        $this->_design = $design;
        $this->customerSession = $customerSession;
        $this->formKeyValidator = $formKeyValidator;
        $this->timezone = $timezone;
        $this->reportFactory = $reportFactory;
        $this->productRepository = $productRepository;
        parent::__construct($context);
    }

    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        if (!$this->formKeyValidator->validate($this->getRequest())) {
            return $resultRedirect->setPath('*/');
        }

        $session = $this->customerSession;
        $referer = $this->_request->getServer('HTTP_REFERER');
        $resultRedirect->setUrl($referer);

        $requestParams = $this->getRequest()->getParams();
        $reviewId = isset($requestParams['review_id']) ? (int)$requestParams['review_id'] : null;
        $productId = isset($requestParams['product_id']) ? (int)$requestParams['product_id'] : null;
        if (!$productId || !$reviewId) {
            return $resultRedirect;
        }

        try {
            $product = $this->productRepository->getById($productId);
        } catch (NoSuchEntityException $e) {
            $product = null;
        }

        if (!$product || !$product->isVisibleInCatalog()) {
            $this->messageManager->addErrorMessage(__('We can\'t specify a product.'));
            return $resultRedirect;
        }
        $customerId = $session->getCustomer()->getId();
        if (!$customerId) {
            $this->messageManager->addErrorMessage(__('Please login to vote.'));
            return $resultRedirect;
        }

        $reportModel = $this->reportFactory->create();
        $reportCollection = $reportModel->getCollection()
            ->addFieldToFilter('review_id', ['eq' => $reviewId])
            ->addFieldToFilter('customer_id', ['eq' => $customerId]);

        if ($reportCollection->getSize()) {
            $this->messageManager->addErrorMessage(__('You can\'t report many times on a review.'));
            return $resultRedirect;
        }

        try {
            $vote = $this->reportFactory->create();
            $vote->setData('review_id', $reviewId);
            $vote->setData('product_id', $productId);
            $vote->setData('customer_id', $customerId);
            $vote->save();

            $this->messageManager->addSuccess(
                __('Thank you. Your report have been submitted.')
            );
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addErrorMessage(
                __('We can\'t report the item right now: %1.', $e->getMessage())
            );
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage(
                $e,
                __('We can\'t report the item right now.')
            );
        }

        return $resultRedirect;
    }
}
