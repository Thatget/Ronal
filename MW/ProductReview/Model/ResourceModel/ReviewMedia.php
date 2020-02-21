<?php
namespace MW\ProductReview\Model\ResourceModel;

class ReviewMedia extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Define main table. Define other tables name
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('mw_product_review_media', 'id');
    }
}
