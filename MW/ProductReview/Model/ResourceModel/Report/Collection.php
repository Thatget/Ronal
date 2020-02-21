<?php
namespace MW\ProductReview\Model\ResourceModel\Report;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Define module
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\MW\ProductReview\Model\Report::class, \MW\ProductReview\Model\ResourceModel\Report::class);
    }
}
