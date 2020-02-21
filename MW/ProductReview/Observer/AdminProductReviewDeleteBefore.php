<?php

namespace MW\ProductReview\Observer;

use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;

class AdminProductReviewDeleteBefore implements \Magento\Framework\Event\ObserverInterface
{
    const AREA_BACKEND = \Magento\Framework\App\Area::AREA_ADMINHTML;
    const AREA_FRONTEND = \Magento\Framework\App\Area::AREA_FRONTEND;

    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $_request;

    /**
     * @var \MW\ProductReview\Model\ReviewFactory
     */
    protected $_reviewModelFactory;
    /**
     * @var \MW\ProductReview\Model\ReviewMediaFactory
     */
    protected $_reviewMediaFactory;

    /**
     * @var \Magento\Framework\App\Filesystem\DirectoryList::MEDIA
     */
    protected $_mediaDirectory;

    /**
     * @var \Magento\Framework\Filesystem\Driver\File
     */
    protected $_fileHandler;

    /**
     * @var MessageManagerInterface
     */
    protected $messageManager;

    protected $_state;

    /**
     * AdminProductReviewDeleteBefore constructor.
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\Framework\Filesystem $filesystem
     * @param \Magento\Framework\Filesystem\Driver\File $fileHandler
     * @param \MW\ProductReview\Model\ReviewFactory $reviewModelFactory
     * @param \MW\ProductReview\Model\ReviewMediaFactory $reviewMediaFactory
     * @param MessageManagerInterface $messageManager
     */
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Framework\Filesystem\Driver\File $fileHandler,
        \MW\ProductReview\Model\ReviewFactory $reviewModelFactory,
        \MW\ProductReview\Model\ReviewMediaFactory $reviewMediaFactory,
        \Magento\Framework\App\State $state,
        MessageManagerInterface $messageManager
    )
    {
        $this->_request = $request;
        $this->_fileHandler = $fileHandler;
        $this->_mediaDirectory = $filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
        $this->_reviewModelFactory = $reviewModelFactory;
        $this->_reviewMediaFactory = $reviewMediaFactory;
        $this->_state = $state;
        $this->messageManager = $messageManager;
    }

    /**
     * function
     * executes before a review is deleted
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $areaCode = $this->getArea();
        if ($areaCode == self::AREA_BACKEND) {
            // single record deletion
            $reviewId = $this->_request->getParam('id', false);
            if ($reviewId) {
                $this->deleteReviewMedia($reviewId);
                return $this;
            }
            // mass deletion
            $reviewIds = $this->_request->getParam('reviews', false);
            if ($reviewIds) {
                foreach ($reviewIds as $id) {
                    $this->deleteReviewMedia($id);
                }
                return $this;
            }
        }
    }

    /**
     * function
     * delete media against a review
     *
     * @param $reviewId
     * @return void
     */
    private function deleteReviewMedia($reviewId)
    {
        $target = $this->_mediaDirectory->getAbsolutePath('mw_product_review');
        try {
            $thisReviewMediaCollection = $this->_reviewMediaFactory->create()
                ->getCollection()
                ->addFieldToFilter('review_id', $reviewId);
            foreach ($thisReviewMediaCollection as $m) {
                $path = $target . $m->getMediaUrl();
                if ($this->_fileHandler->isExists($path)) {
                    $this->_fileHandler->deleteFile($path);
                }
            }
        } catch (\Exception $e) {
            $this->messageManager->addException($e, __('Something went wrong while deleting review(s) attachment(s).'));
        }
    }

    public function getArea()
    {
        return $this->_state->getAreaCode();
    }
}
