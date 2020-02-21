<?php

namespace MW\ProductReview\Controller;

use \Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

abstract class Review extends Action
{
    /**
     * @param Context $context
     */
    public function __construct(
        Context $context
    ) {
        parent::__construct($context);
    }
}