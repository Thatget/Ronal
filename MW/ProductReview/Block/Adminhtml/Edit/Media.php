<?php

namespace MW\ProductReview\Block\Adminhtml\Edit;

class Media extends \Magento\Backend\Block\Template
{
    /**
     * @var \MW\ProductReview\Model\ReviewMediaFactory
     */
    protected $_reviewMediaFactory;

    /**
     * Media constructor
     *
     * \Magento\Backend\Block\Template\Context $context
     * @param \MW\ProductReview\Model\ReviewMediaFactory $reviewMediaFactory
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \MW\ProductReview\Model\ReviewMediaFactory $reviewMediaFactory
    ) {
        $this->_reviewMediaFactory = $reviewMediaFactory;
        $this->setTemplate("media.phtml");
        parent::__construct($context);
    }

    /**
     * function
     * get media collection for a review
     *
     * @return \MW\ProductReview\Model\ResourceModel\Review\Collection
     */
    public function getMediaCollection()
    {
        $reviewCollection = $this->_reviewMediaFactory->create()
            ->getCollection()
            ->addFieldToFilter('review_id', $this->getRequest()->getParam('id'));

        return $reviewCollection;
    }

    public function getReviewMediaUrl()
    {
        $reviewMediaDirectoryPath = $this->_storeManager->getStore()
                ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'mw_product_review';

        return $reviewMediaDirectoryPath;
    }

}