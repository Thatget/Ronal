<?php
namespace MW\ProductCustomTabs\Model\Plugin\Sales\Order;

class Grid
{

    public static $table = 'sales_order_grid';
    public static $leftJoinTable = 'sales_order_item';

    public function afterSearch($intercepter, $collection)
    {
        if ($collection->getMainTable() === $collection->getConnection()->getTableName(self::$table)) {
            $leftJoinTableName = $collection->getConnection()->getTableName(self::$leftJoinTable);

            $collection
                ->getSelect()
                ->joinLeft(
                    ['co' => $leftJoinTableName],
                    "co.order_id = main_table.entity_id",
                    [
                        'sku' => 'GROUP_CONCAT(co.sku)',
                        'product_name' => 'GROUP_CONCAT(co.name)'
                    ]
                )->group('main_table.entity_id')
            ;

            $where = $collection->getSelect()->getPart(\Magento\Framework\DB\Select::WHERE);

            $collection->getSelect()->setPart(\Magento\Framework\DB\Select::WHERE, $where);

        }
        return $collection;
    }
}