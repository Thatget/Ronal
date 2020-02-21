<?php
namespace MW\ProductReview\Model;

class Report extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\MW\ProductReview\Model\ResourceModel\Report::class);
    }
}
