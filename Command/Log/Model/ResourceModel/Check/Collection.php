<?php
namespace Command\Log\Model\ResourceModel\Check;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'new_command_id';
    protected $_eventPrefix = 'command_log_collection';
    protected $_eventObject = 'check_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Command\Log\Model\Check', 'Command\Log\Model\ResourceModel\Check');
    }

}
