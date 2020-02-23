<?php
namespace Command\Log\Block\Adminhtml;

use Magento\Backend\Block\Template;
use Command\Log\Model\CheckFactory;

class Index extends Template{

    public $_template = 'Command_Log::Index.phtml';
    protected $_checkFactory;

    public function __construct(
        Template\Context $context,
        array $data = [],
        CheckFactory $checkFactory

    )
    {
        $this->_checkFactory = $checkFactory;
        parent::__construct($context, $data);
    }
    public function getcheckValue(){
        $a = $this->_checkFactory->create();
        $b = $a->load($this->getRequest()->getParam('id'));
        return $b->getData();
    }
}
