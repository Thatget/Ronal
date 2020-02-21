<?php

namespace MW\ProductReviewAPI\Block\Product\View;

use Magento\Review\Model\ResourceModel\Review\Collection as ReviewCollection;

/**
 * Detailed Product Reviews
 *
 * @api
 * @since 100.0.2
 */
class ListView extends \Magento\Review\Block\Product\View\ListView
{
    /**
     * Unused class property
     * @var false
     */
    protected $_forceHasOptions = false;

    /**
     * Get product id
     *
     * @return int|null
     */
    public function getProductId()
    {
        $product = $this->_coreRegistry->registry('product');
        return $product ? $product->getId() : null;
    }

    /**
     * Prepare product review list toolbar
     *
     * @return $this
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $toolbar = $this->getLayout()->getBlock('product_review_list.toolbar');
        if ($toolbar) {
            $toolbar->setCollection($this->getReviewsCollection());
            $this->setChild('toolbar', $toolbar);
        }

        return $this;
    }



    /**
     * Add rate votes
     *
     * @return $this
     */
    protected function _beforeToHtml()
    {
        $this->getReviewsCollection()->load()->addRateVotes();
        return parent::_beforeToHtml();
    }

    /**
     * Get collection of reviews
     *
     * @return ReviewCollection
     */
    public function getReviewsCollection()
    {
        $reviewCollection = parent::getReviewsCollection();
        $keyword = $this->getSearchKeyword();
        if($keyword) {
            $reviewCollection->addFieldToFilter(
                'detail',
                [
                    'like' => '%' . $keyword. '%'
                ]
            );
        }
        return $reviewCollection;
    }

    public function xlog($message = 'null')
    {
        $log = print_r($message, true);
        $logger = new \Zend\Log\Logger;
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/product_review.log');
        $logger->addWriter($writer);
        $logger->info($log);
    }

    /**
     * Get collection of reviews
     * @param ReviewCollection $reviewsCollection
     *
     * @return ReviewCollection
     */
//    public function addReviewsTotalCount($reviewsCollection)
//    {
//        $reviewsCollection->getSelect()->joinLeft(
//            ['r' => $reviewsCollection->getReviewTable()],
//            'main_table.entity_pk_value = r.entity_pk_value',
//            ['total_reviews' => new \Zend_Db_Expr('COUNT(r.review_id)')]
//        )->group(
//            'main_table.review_id'
//        );
//
//        return $this;
//    }


    /**
     * Retrieve current product model from registry
     *
     * @return \Magento\Catalog\Model\Product
     */
    public function getSearchKeyword()
    {
        return $this->_coreRegistry->registry('search_keyword');
    }

    /**
     * Get URL for ajax call
     *
     * @return string
     */
//    public function getProductReviewSearchUrl()
//    {
//        return $this->getUrl(
//            'review-search/search/product',
//            [
//                '_secure' => $this->getRequest()->isSecure(),
//                'id' => $this->getProductId(),
//            ]
//        );
//    }


    /**
     * Return review url
     *
     * @param int $id
     * @return string
     */
    public function getReviewUrl($id)
    {
        return $this->getUrl('*/*/view', ['id' => $id]);
    }
}
