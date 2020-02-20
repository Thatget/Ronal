<?php
namespace Command\Test\Model;
class Test extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'Command_test_post';

    protected $_cacheTag = 'command_test_post';

    protected $_eventPrefix = 'command_test_post';

    protected function _construct()
    {
        $this->_init('Command\Test\Model\ResourceModel\Test');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }
}