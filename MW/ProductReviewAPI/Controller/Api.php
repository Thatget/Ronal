<?php

namespace MW\ProductReviewAPI\Controller;

use \Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

abstract class Api extends Action
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