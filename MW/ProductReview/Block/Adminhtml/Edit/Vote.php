<?php

namespace MW\ProductReview\Block\Adminhtml\Edit;

class Vote extends \Magento\Backend\Block\Template
{
    /**
     * @var \MW\ProductReview\Model\VoteFactory
     */
    protected $_reviewVoteFactory;

    protected $voteCollection;

    /**
     * Media constructor
     *
     * \Magento\Backend\Block\Template\Context $context
     * @param \MW\ProductReview\Model\VoteFactory $reviewVoteFactory
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \MW\ProductReview\Model\VoteFactory $reviewVoteFactory,
        \MW\ProductReview\Model\Options\Age $valueOptions
    ) {
        $this->_reviewVoteFactory = $reviewVoteFactory;
        $this->valueOptions = $valueOptions;
        $this->setTemplate("vote.phtml");
        parent::__construct($context);
    }

    public function getFieldName()
    {
        return 'vote';
    }

    public function getFieldValue($value = 0)
    {
        $this->voteCollection = $this->_reviewVoteFactory->create()
            ->getCollection()
            ->addFieldToFilter('review_id', $this->getRequest()->getParam('id'))
            ->addFieldToFilter('vote_data', $value);
        return $this->voteCollection->getSize();
    }

    public function getCollection()
    {
        $this->voteCollection = $this->_reviewVoteFactory->create()
            ->getCollection()
            ->addFieldToFilter('review_id', $this->getRequest()->getParam('id'));
        return $this->voteCollection;
    }
}
