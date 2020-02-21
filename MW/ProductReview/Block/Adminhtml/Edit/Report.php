<?php

namespace MW\ProductReview\Block\Adminhtml\Edit;

class Report extends \Magento\Backend\Block\Template
{
    /**
     * @var \MW\ProductReview\Model\ReportFactory
     */
    protected $_reviewReportFactory;


    /**
     * Media constructor
     *
     * \Magento\Backend\Block\Template\Context $context
     * @param \MW\ProductReview\Model\ReviewFactory $reviewReportFactory
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \MW\ProductReview\Model\ReportFactory $reviewReportFactory
    ) {
        $this->_reviewReportFactory = $reviewReportFactory;
        $this->setTemplate("vote.phtml");
        parent::__construct($context);
    }

    public function getFieldName()
    {
        return 'report';
    }

    public function getFieldValue($value = 0)
    {
        $reviewCollection = $this->_reviewReportFactory->create()
            ->getCollection()
            ->addFieldToFilter('review_id', $this->getRequest()->getParam('id'));

        return $reviewCollection->getSize();
    }


}
