<?php

namespace MW\ProductReviewAPI\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface BlockSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return \MW\ProductReviewAPI\Api\Data\BlockInterface[]
     */
    public function getItems();

    /**
     * @param \MW\ProductReviewAPI\Api\Data\BlockInterface[] $items
     * @return BlockSearchResultsInterface
     */
    public function setItems(array $items);
}
