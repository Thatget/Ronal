<?php

namespace MW\ProductReviewAPI\Model;

use MW\ProductReviewAPI\Api\Data\PageInterface;

class Page extends \Magento\Cms\Model\Page implements PageInterface
{
    /**
     * @inheritdoc
     */
    public function getStoreId()
    {
        return $this->_getData(self::STORE_ID);
    }

    /**
     * @inheritdoc
     */
    public function setStoreId(array $storeIds)
    {
        $this->setData(self::STORE_ID, $storeIds);

        return $this;
    }
}
