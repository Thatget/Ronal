<?php
namespace MW\Indeep\Controller\Index;



class Index extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;
    protected $_product;
    protected $_productFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Catalog\Model\ProductFactory $productFactory ,

        \Magento\Framework\View\Result\PageFactory $pageFactory)
    {
        $this->_pageFactory = $pageFactory;
        $this->_product = $productRepository;
        $this->_productFactory = $productFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        try {
            $product = $this->_product->getById('11');
            $quantity = $product->setExtensionAttributes();
            var_dump($quantity);
        }catch (\Exception $e){
            echo $e;
        }
        die('Quyet');
//        if ($pro->load('12')){
//            echo "DC";
//        }
//        else echo 'KO';
        die('AA');
        return $this->_pageFactory->create();
    }
}