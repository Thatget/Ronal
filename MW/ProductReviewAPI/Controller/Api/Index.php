<?php

namespace MW\ProductReviewAPI\Controller\Api;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Data\Form\FormKey\Validator as FormKeyValidator;
use Magento\Framework\Exception\NoSuchEntityException;
use MW\ProductReviewAPI\Controller\Api;
use Magento\Framework\Controller\ResultFactory;

class Index extends Api
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
     * @var \MW\ProductReview\Model\VoteFactory
     */
    protected $voteFactory;
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
        \MW\ProductReview\Model\VoteFactory $voteFactory,
        ProductRepositoryInterface $productRepository
    ) {
        $this->_design = $design;
        $this->customerSession = $customerSession;
        $this->formKeyValidator = $formKeyValidator;
        $this->timezone = $timezone;
        $this->voteFactory = $voteFactory;
        $this->productRepository = $productRepository;
        parent::__construct($context);
    }

    public function execute()
    {
        echo 123; die;
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
        $voteValue = isset($requestParams['vote']) ? (int)$requestParams['vote'] : null;
        $productId = isset($requestParams['product_id']) ? (int)$requestParams['product_id'] : null;
        if (!$productId || !$reviewId || !$voteValue) {
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

        $voteModel = $this->voteFactory->create();
        $voteCollection = $voteModel->getCollection()
            ->addFieldToFilter('review_id', ['eq' => $reviewId])
            ->addFieldToFilter('customer_id', ['eq' => $customerId]);

        if ($voteCollection->getSize()) {
            $this->messageManager->addErrorMessage(__('You can\'t vote many times on a review.'));
            return $resultRedirect;
        }

        try {
            $vote = $this->voteFactory->create();
            $vote->setData('review_id', $reviewId);
            $vote->setData('vote_data', $voteValue);
            $vote->setData('product_id', $productId);
            $vote->setData('customer_id', $customerId);
            $vote->save();

            $this->messageManager->addSuccess(
                __('Thank you. Your vote have been submitted.')
            );
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addErrorMessage(
                __('We can\'t vote the item right now: %1.', $e->getMessage())
            );
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage(
                $e,
                __('We can\'t vote the item right now.')
            );
        }

        return $resultRedirect;
    }
}
