<?php

/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace AHT\SaleAgent\Api\Data;

interface SaleAgentSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get SaleAgent list.
     * @return \AHT\SaleAgent\Api\Data\SaleAgentInterface[]
     */
    public function getItems();

    /**
     * Set entity_id list.
     * @param \AHT\SaleAgent\Api\Data\SaleAgentInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
