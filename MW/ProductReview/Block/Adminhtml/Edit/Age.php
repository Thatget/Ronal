<?php

namespace MW\ProductReview\Block\Adminhtml\Edit;

class Age extends \Magento\Backend\Block\Template
{
    /**
     * @var \MW\ProductReview\Model\ReviewFactory
     */
    protected $_reviewModelFactory;

    /**
     * @var \MW\ProductReview\Model\Options\Age
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
        \MW\ProductReview\Model\Options\Age $valueOptions
    ) {
        $this->_reviewModelFactory = $reviewModelFactory;
        $this->valueOptions = $valueOptions;
        $this->setTemplate("select.phtml");
        parent::__construct($context);
    }

    public function getFieldName()
    {
        return 'age';
    }

    public function getFieldValue($value = 0)
    {
        $options = $this->valueOptions->toOptionArray();
        return $options[$value];
    }

    public function getMediaCollection()
    {
        $reviewCollection = $this->_reviewModelFactory->create()
            ->getCollection()
            ->addFieldToFilter('review_id', $this->getRequest()->getParam('id'));

        return $reviewCollection;
    }
}
