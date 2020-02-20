<?php
namespace Command\Log\Model;
class Check extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'Command_check_post';

    protected $_cacheTag = 'command_check_post';

    protected $_eventPrefix = 'command_check_post';

    protected function _construct()
    {
        $this->_init('Command\Log\Model\ResourceModel\Check');
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
