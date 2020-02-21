<?php

namespace MW\ProductReview\Setup;

// CASCADE refer: http://www.mysqltutorial.org/mysql-on-delete-cascade/

use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{
    /**
     * @var \Magento\Framework\Filesystem\Io\File
     */
    protected $_file;
    /**
     * @var \Magento\Framework\App\Filesystem\DirectoryList
     */
    protected $_directoryList;
    /**
     * @param \Magento\Framework\Filesystem\Io\File $io
     * @param \Magento\Framework\App\Filesystem\DirectoryList $directoryList
     */
    public function __construct(
        \Magento\Framework\Filesystem\Io\File $file,
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList
    ) {
        $this->_file = $file;
        $this->_directoryList = $directoryList;
    }

    public function install(
        \Magento\Framework\Setup\SchemaSetupInterface $setup,
        \Magento\Framework\Setup\ModuleContextInterface $context)
    {
        $this->createReviewImagesDirectory();
        $installer = $setup;
        $installer->startSetup();
        $table = $installer->getConnection()->newTable(
            $installer->getTable('mw_product_review')
        )->addColumn(
            'id',Table::TYPE_BIGINT,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true],
            'id'
        )->addColumn(
            'review_id',Table::TYPE_BIGINT,
            null,
            ['nullable' => false, 'unsigned' => true],
            'review id'
        )->addColumn(
            'age',Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'age'
        )->addColumn(
            'skin_type',Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'skin_type'
        )->addColumn(
            'skin_concern', Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'skin_concern'
        )->addColumn(
            'created_at', Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
            'Created At'
        )->addColumn(
            'updated_at', Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_UPDATE],
            'Updated At'
        )->addForeignKey(
            $installer->getFkName(
                'mw_product_review',
                'review_id', 'review',
                'review_id'
            ), 'review_id',
            $installer->getTable('review'),
            'review_id',
            Table::ACTION_CASCADE
        );
        $installer->getConnection()->createTable($table);


        $table = $installer->getConnection()->newTable(
            $installer->getTable('mw_product_review_media')
        )->addColumn(
            'id', Table::TYPE_BIGINT,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true],
            'id'
        )->addColumn(
            'review_id', Table::TYPE_BIGINT,
            null,
            ['nullable' => false, 'unsigned' => true],
            'review id'
        )->addColumn(
            'media_url',Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'media_url'
        )->addColumn(
            'created_at', Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
            'Created At'
        )->addColumn(
            'updated_at', Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_UPDATE],
            'Updated At'
        )->addForeignKey(
            $installer->getFkName(
                'mw_product_review_media',
                'review_id', 'review',
                'review_id'
            ), 'review_id',
            $installer->getTable('review'),
            'review_id',
            Table::ACTION_CASCADE
        );
        $installer->getConnection()->createTable($table);


        $table = $installer->getConnection()->newTable(
            $installer->getTable('mw_product_review_vote')
        )->addColumn(
            'id', Table::TYPE_BIGINT,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true],
            'id'
        )->addColumn(
            'review_id', Table::TYPE_BIGINT,
            null,
            ['nullable' => false, 'unsigned' => true],
            'review id'
        )->addColumn(
            'product_id', Table::TYPE_BIGINT,
            null,
            ['nullable' => false, 'unsigned' => true],
            'product_id'
        )->addColumn(
            'customer_id', Table::TYPE_BIGINT,
            null,
            ['nullable' => false, 'unsigned' => true],
            'customer_id'
        )->addColumn(
            'vote_data', Table::TYPE_SMALLINT,
            2,
            ['nullable' => false],
            'vote_data'
        )->addColumn(
            'created_at', Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
            'Created At'
        )->addColumn(
            'updated_at', Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_UPDATE],
            'Updated At'
        )->addForeignKey(
            $installer->getFkName(
                'mw_product_review_vote',
                'review_id', 'review',
                'review_id'
            ), 'review_id',
            $installer->getTable('review'),
            'review_id',
            Table::ACTION_CASCADE
        );
        $installer->getConnection()->createTable($table);


        $table = $installer->getConnection()->newTable(
            $installer->getTable('mw_product_review_report')
        )->addColumn(
            'id', Table::TYPE_BIGINT,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true],
            'id'
        )->addColumn(
            'review_id', Table::TYPE_BIGINT,
            null,
            ['nullable' => false, 'unsigned' => true],
            'review id'
        )->addColumn(
            'product_id', Table::TYPE_BIGINT,
            null,
            ['nullable' => false, 'unsigned' => true],
            'product_id'
        )->addColumn(
            'customer_id', Table::TYPE_BIGINT,
            null,
            ['nullable' => false, 'unsigned' => true],
            'customer_id'
        )->addColumn(
            'created_at', Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
            'Created At'
        )->addColumn(
            'updated_at', Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_UPDATE],
            'Updated At'
        )->addForeignKey(
            $installer->getFkName(
                'mw_product_review_report',
                'review_id', 'review',
                'review_id'
            ), 'review_id',
            $installer->getTable('review'),
            'review_id',
            Table::ACTION_CASCADE
        );
        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }

    private function createReviewImagesDirectory()
    {
        $this->_file->mkdir($this->_directoryList->getPath('media') . '/mw_product_review', 0755);
    }
}
