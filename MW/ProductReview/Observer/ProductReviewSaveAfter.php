<?php
namespace MW\ProductReview\Observer;

use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;

class ProductReviewSaveAfter implements \Magento\Framework\Event\ObserverInterface
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
     * @var \Magento\MediaStorage\Model\File\UploaderFactory
     */
    protected $_fileUploaderFactory;

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
     * ProductReviewSaveAfter constructor.
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\Framework\Filesystem $filesystem
     * @param \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory
     * @param \MW\ProductReview\Model\ReviewFactory $reviewModelFactory
     * @param \MW\ProductReview\Model\ReviewMediaFactory $reviewMediaFactory
     * @param MessageManagerInterface $messageManager
     */
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory,
        \Magento\Framework\Filesystem\Driver\File $fileHandler,
        \MW\ProductReview\Model\ReviewFactory $reviewModelFactory,
        \MW\ProductReview\Model\ReviewMediaFactory $reviewMediaFactory,
        \Magento\Framework\App\State $state,
        MessageManagerInterface $messageManager
    ) {
        $this->_request = $request;
        $this->_fileUploaderFactory = $fileUploaderFactory;
        $this->_mediaDirectory = $filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
        $this->_fileHandler = $fileHandler;
        $this->_reviewModelFactory = $reviewModelFactory;
        $this->_reviewMediaFactory = $reviewMediaFactory;
        $this->_state = $state;
        $this->messageManager = $messageManager;
    }

    /**
     * function
     * executed after a product review is saved
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $reviewId = $observer->getEvent()->getObject()->getReviewId();
        $media = $this->_request->getFiles('review_media');
        $age = $this->_request->getParam('age_select');
        $skin_type = $this->_request->getParam('skin_type_select');
        $skin_concern = $this->_request->getParam('skin_concern_select');

        $target = $this->_mediaDirectory->getAbsolutePath('mw_product_review');
        $areaCode = $this->getArea();

        if ($areaCode == self::AREA_FRONTEND) {

            try {
                $reviewModel = $this->_reviewModelFactory->create();
                $reviewModel->setData('age', $age);
                $reviewModel->setData('skin_type', $skin_type);
                $reviewModel->setData('skin_concern', $skin_concern);
                $reviewModel->setData('review_id', $reviewId);
                $reviewModel->save();
            } catch (\Exception $e) {
                if ($e->getCode() == 0) {
                    $this->messageManager->addError("Something went wrong while saving review attachment(s).");
                }
            }

            if ($media) {
                try {
                    for ($i = 0; $i < count($media); $i++) {
                        $uploader = $this->_fileUploaderFactory->create(['fileId' => 'review_media[' . $i . ']']);
                        $uploader->setAllowedExtensions(['jpg', 'jpeg', 'png']);
                        $uploader->setAllowRenameFiles(true);
                        $uploader->setFilesDispersion(true);
                        $uploader->setAllowCreateFolders(true);

                        $result = $uploader->save($target);

                        $reviewMedia = $this->_reviewMediaFactory->create();
                        $reviewMedia->setData('media_url', $result['file']);
                        $reviewMedia->setData('review_id', $reviewId);
                        $reviewMedia->save();
                    }
                } catch (\Exception $e) {
                    if ($e->getCode() == 0) {
                        $this->messageManager->addError("Something went wrong while saving review attachment(s).");
                    }
                }
            }

        }

        if ($areaCode == self::AREA_BACKEND) {
            $deletedMediaString = $this->_request->getParam('deleted_media');
            if ($deletedMediaString) {
                try {
                    $ids = explode(",", trim($deletedMediaString, ","));
                    foreach ($ids as $id) {
                        $reviewMedia = $this->_reviewMediaFactory->create()->load($id);
                        $path = $target . $reviewMedia->getMediaUrl();
                        if ($this->_fileHandler->isExists($path)) {
                            $this->_fileHandler->deleteFile($path);
                        }
                        $reviewMedia->delete();
                    }
                } catch (\Exception $e) {
                    $this->messageManager->addError($e, __('Something went wrong while updating review attachment(s).'));
                }
            }

        }

        return $this;
    }

    public function getArea()
    {
        return $this->_state->getAreaCode();
    }
}