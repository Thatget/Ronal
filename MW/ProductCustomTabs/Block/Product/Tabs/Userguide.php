<?php
namespace MW\ProductCustomTabs\Block\Product\Tabs;

use Magento\Framework\View\Element\Template;

class Userguide extends Template {

    protected $_registry = null;

    public function __construct(
        Template\Context $context,
        array $data = [],
        \Magento\Framework\Registry $registry
    )
    {
        $this->_registry = $registry;
        parent::__construct($context, $data);
    }
    public function getProduct(){
        return $this->_registry->registry('product');
    }
    public function getCustomText(){
        return __('This is user guid Tabs');
    }

}