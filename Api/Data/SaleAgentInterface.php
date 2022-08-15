<?php

/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace AHT\SaleAgent\Api\Data;

interface SaleAgentInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const COMMISION_TYPE = 'commision_type';
    const ORDER_ID = 'order_id';
    const SALEAGENT_ID = 'saleagent_id';
    const COMMISSION_VALUE = 'commission_value';
    const ORDER_ITEM_ID = 'order_item_id';
    const ORDER_ITEM_SKU = 'order_item_sku';
    const ENTITY_ID = 'entity_id';
    const ORDER_ITEM_PRICE = 'order_item_price';

    /**
     * Get saleagent_id
     * @return string|null
     */
    public function getSaleagentId();

    /**
     * Set saleagent_id
     * @param string $saleagentId
     * @return \AHT\SaleAgent\SaleAgent\Api\Data\SaleAgentInterface
     */
    public function setSaleagentId($saleagentId);

    /**
     * Get entity_id
     * @return string|null
     */
    public function getEntityId();

    /**
     * Set entity_id
     * @param string $entityId
     * @return \AHT\SaleAgent\SaleAgent\Api\Data\SaleAgentInterface
     */
    public function setEntityId($entityId);

    /**
     * Get order_id
     * @return string|null
     */
    public function getOrderId();

    /**
     * Set order_id
     * @param string $orderId
     * @return \AHT\SaleAgent\SaleAgent\Api\Data\SaleAgentInterface
     */
    public function setOrderId($orderId);

    /**
     * Get order_item_id
     * @return string|null
     */
    public function getOrderItemId();

    /**
     * Set order_item_id
     * @param string $orderItemId
     * @return \AHT\SaleAgent\SaleAgent\Api\Data\SaleAgentInterface
     */
    public function setOrderItemId($orderItemId);

    /**
     * Get order_item_sku
     * @return string|null
     */
    public function getOrderItemSku();

    /**
     * Set order_item_sku
     * @param string $orderItemSku
     * @return \AHT\SaleAgent\SaleAgent\Api\Data\SaleAgentInterface
     */
    public function setOrderItemSku($orderItemSku);

    /**
     * Get order_item_price
     * @return string|null
     */
    public function getOrderItemPrice();

    /**
     * Set order_item_price
     * @param string $orderItemPrice
     * @return \AHT\SaleAgent\SaleAgent\Api\Data\SaleAgentInterface
     */
    public function setOrderItemPrice($orderItemPrice);

    /**
     * Get commision_type
     * @return string|null
     */
    public function getCommisionType();

    /**
     * Set commision_type
     * @param string $commisionType
     * @return \AHT\SaleAgent\SaleAgent\Api\Data\SaleAgentInterface
     */
    public function setCommisionType($commisionType);

    /**
     * Get commission_value
     * @return string|null
     */
    public function getCommissionValue();

    /**
     * Set commission_value
     * @param string $commissionValue
     * @return \AHT\SaleAgent\SaleAgent\Api\Data\SaleAgentInterface
     */
    public function setCommissionValue($commissionValue);
}
