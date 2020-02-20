<?php
namespace Command\Log\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;


class InstallSchema implements InstallSchemaInterface
{

public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
{
    $installer = $setup;
    $installer->startSetup();

    $table = $installer->getConnection()
        ->newTable($installer->getTable('table_history_command'))
        ->addColumn(
            'id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Id'
        )->addColumn(
            'input',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            500,
            ['nullable'=>true],
            'Input Value'
        )->addColumn(
            'output',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            250,
            ['nullable'=>true],
            'Output Value'
        )->addColumn(
            'start_time',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['nullable'=>true],
            'Create At'
        )->addColumn(
            'end_time',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['nullable'=>true],
            'Done at'
        )->setComment('Follow executing time');
    $installer->getConnection()->createTable($table);
    $installer->endSetup();
    }
}