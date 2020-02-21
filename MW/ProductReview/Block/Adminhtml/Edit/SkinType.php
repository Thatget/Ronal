<?php

namespace MW\ProductReview\Block\Adminhtml\Edit;

class SkinType extends \Magento\Backend\Block\Template
{
    /**
     * @var \MW\ProductReview\Model\ReviewFactory
     */
    protected $_reviewModelFactory;

    /**
     * @var \MW\ProductReview\Model\Options\SkinType
     */
    protected $valueOptions;

    /**
     * Media constructor
     *
     * \Magento\Backend\Block\Template\Context $context
     * @param \MW\ProductReview\Model\ReviewFactory $reviewModelFactory
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \MW\ProductReview\Model\ReviewFactory $reviewModelFactory,
        \MW\ProductReview\Model\Options\SkinType $valueOptions
    ) {
        $this->_reviewModelFactory = $reviewModelFactory;
        $this->valueOptions = $valueOptions;
        $this->setTemplate("select.phtml");
        parent::__construct($context);
    }

    public function getFieldName()
    {
        return 'skin_type';
    }


    public function getFieldValue($value = 0)
    {
        $options = $this->valueOptions->toOptionArray();
        return $options[$value];
    }

    /**
     * function
     * get media collection for a review
     *
     * @return \MW\ProductReview\Model\ResourceModel\Review\Collection
     */
    public function getMediaCollection()
    {
        $reviewCollection = $this->_reviewModelFactory->create()
            ->getCollection()
            ->addFieldToFilter('review_id', $this->getRequest()->getParam('id'));

        return $reviewCollection;
    }

}