<?php
namespace Command\Test\Model\ResourceModel\Test;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'new_id';
    protected $_eventPrefix = 'command_test_collection';
    protected $_eventObject = 'test_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Command\Test\Model\Test', 'Command\Test\Model\ResourceModel\Test');
    }

}
