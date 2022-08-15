<?php

/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace AHT\SaleAgent\Model\ResourceModel\SaleAgent\Grid;

class Collection extends \Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult
{

    /**
     * @var string
     */
    protected $_idFieldName = 'saleagent_id';

    protected function _initSelect()
    {
        $this->getSelect()
            ->from(['main_table' => 'aht_saleagent_saleagent'])
            ->columns(['qty' => new \Zend_Db_Expr('SUM(sales_order_item.qty_ordered)')])
            ->columns(['total' => new \Zend_Db_Expr("
                SUM(
                    IF(main_table.commision_type = 'fixed',
                        main_table.commission_value,
                        (main_table.order_item_price * main_table.commission_value / 100)
                    )
                ) * SUM(sales_order_item.qty_ordered)
            ")])
            ->join(
                'sales_order_item',
                'main_table.order_item_id = sales_order_item.item_id',
                [
                    'sales_order_item.name',
                    'sales_order_item.sku'
                ]
            )
            ->group('main_table.order_item_sku');
        return $this;
    }
}
