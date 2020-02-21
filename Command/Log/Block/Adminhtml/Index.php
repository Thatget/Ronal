<?php
namespace Command\Log\Block\Adminhtml;

use Magento\Backend\Block\Template;

class Index extends  Template{

    public $_template = 'Command_Log::index.phtml';


    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Test\PreviewPopup\Model\ActionsLogFactory $actionlogFactory,
        \Test\PreviewPopup\Model\ResourceModel\ActionsLogChanges\CollectionFactory $actionsLogChangesFactory,
        array $data = []
    ) {
        $this->authSession = $authSession;
        $this->actionlogFactory = $actionlogFactory;
        $this->actionsLogChangesFactory = $actionsLogChangesFactory;
        parent::__construct($context, $data);
    }

    public function getModificationDetails()
    {
        $id = $this->getActionsId();
        $actionsLogChangescollections = $this->actionsLogChangesFactory
            ->create()
            ->addFieldToFilter(
                'actions_id',
                array('eq' => $id)
            )
            ->load();
        return $actionsLogChangescollections;
    }

    public function getActionsId()
    {
        return $this->getRequest()->getParam('id');
    }
}