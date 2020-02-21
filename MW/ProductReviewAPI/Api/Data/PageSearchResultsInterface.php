<?php

namespace MW\ProductReviewAPI\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface PageSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return \MW\ProductReviewAPI\Api\Data\PageInterface[]
     */
    public function getItems();

    /**
     * @param \MW\ProductReviewAPI\Api\Data\PageInterface[] $items
     * @return PageSearchResultsInterface
     */
    public function setItems(array $items);
}
