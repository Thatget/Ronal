<?php


namespace MW\ProductReview\Helper;


use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Url\Helper\Data as UrlHelper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Framework\Data\Helper\PostHelper
     */
    protected $_postDataHelper;

    /**
     * @var UrlHelper
     */
    private $urlHelper;
    /**
     * @var \MW\ProductReview\Model\VoteFactory
     */
    private $voteFactory;

    /**
     * Constructs
     *
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\Data\Helper\PostHelper $postDataHelper
     * @param \MW\ProductReview\Model\VoteFactory $voteFactory,
     * @param array $data
     * @param UrlHelper $urlHelper
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Data\Helper\PostHelper $postDataHelper,
        \MW\ProductReview\Model\VoteFactory $voteFactory,
        array $data = [],
        UrlHelper $urlHelper = null
    ) {
        $this->_postDataHelper = $postDataHelper;
        $this->voteFactory = $voteFactory;
        parent::__construct($context);
        $this->urlHelper = $urlHelper ?: ObjectManager::getInstance()->get(UrlHelper::class);
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->_urlBuilder->getUrl($route, $params);
    }

    /**
     * Returns target store post data
     *
     * @param \Magento\Store\Model\Store $store
     * @param array $data
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getTargetVotePostData($data = [])
    {
        $url = $this->getUrl('mw_review/vote');
        $data[ActionInterface::PARAM_NAME_URL_ENCODED] = $this->urlHelper->getEncodedUrl($url);

        return $this->_postDataHelper->getPostData(
            $url,
            $data
        );
    }

    /**
     * Returns target store post data
     *
     * @param \Magento\Store\Model\Store $store
     * @param array $data
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getTargetReportPostData($data = [])
    {
        $url = $this->getUrl('mw_review/vote/report');
        $data[ActionInterface::PARAM_NAME_URL_ENCODED] = $this->urlHelper->getEncodedUrl($url);

        return $this->_postDataHelper->getPostData(
            $url,
            $data
        );
    }

    public function getVoteCounter($reviewId, $type) {
        $voteModel = $this->voteFactory->create();
        $voteCollection = $voteModel->getCollection()
            ->addFieldToFilter('review_id', ['eq' => $reviewId])
            ->addFieldToFilter('vote_data', ['eq' => $type]);
        return $voteCollection->getSize();
    }


    /**
     * Get URL for ajax call
     *
     * @return string
     */
    public function getProductReviewSearchUrl($productId)
    {
        if(!$productId){
            return "";
        }
        return $this->getUrl(
            'review-search/search/product',
            [
                '_secure' => true,
                'id' => $productId,
            ]
        );
    }
}