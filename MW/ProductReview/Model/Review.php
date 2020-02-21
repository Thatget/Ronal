<?php
namespace MW\ProductReview\Model;

class Review extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\MW\ProductReview\Model\ResourceModel\Review::class);
    }
}
