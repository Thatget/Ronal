<?php
namespace MW\ProductReview\Model;

class ReviewMedia extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\MW\ProductReview\Model\ResourceModel\ReviewMedia::class);
    }
}
