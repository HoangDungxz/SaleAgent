<?php

/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace AHT\SaleAgent\Model;

use AHT\SaleAgent\Api\Data\SaleAgentInterface;
use AHT\SaleAgent\Api\Data\SaleAgentInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;

class SaleAgent extends \Magento\Framework\Model\AbstractModel implements SaleAgentInterface
{

    protected $dataObjectHelper;

    protected $saleagentDataFactory;

    protected $_eventPrefix = 'aht_saleagent_saleagent';

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param SaleAgentInterfaceFactory $saleagentDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \AHT\SaleAgent\Model\ResourceModel\SaleAgent $resource
     * @param \AHT\SaleAgent\Model\ResourceModel\SaleAgent\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        SaleAgentInterfaceFactory $saleagentDataFactory,
        DataObjectHelper $dataObjectHelper,
        \AHT\SaleAgent\Model\ResourceModel\SaleAgent $resource,
        \AHT\SaleAgent\Model\ResourceModel\SaleAgent\Collection $resourceCollection,
        array $data = []
    ) {
        $this->saleagentDataFactory = $saleagentDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve saleagent model with saleagent data
     * @return SaleAgentInterface
     */
    public function getDataModel()
    {
        $saleagentData = $this->getData();

        $saleagentDataObject = $this->saleagentDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $saleagentDataObject,
            $saleagentData,
            SaleAgentInterface::class
        );

        return $saleagentDataObject;
    }

    /**
     * @inheritDoc
     */
    public function getSaleagentId()
    {
        return $this->getData(self::SALEAGENT_ID);
    }

    /**
     * @inheritDoc
     */
    public function setSaleagentId($saleagentId)
    {
        return $this->setData(self::SALEAGENT_ID, $saleagentId);
    }

    /**
     * @inheritDoc
     */
    public function getEntityId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * @inheritDoc
     */
    public function setEntityId($entityId)
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }

    /**
     * @inheritDoc
     */
    public function getOrderId()
    {
        return $this->getData(self::ORDER_ID);
    }

    /**
     * @inheritDoc
     */
    public function setOrderId($orderId)
    {
        return $this->setData(self::ORDER_ID, $orderId);
    }

    /**
     * @inheritDoc
     */
    public function getOrderItemId()
    {
        return $this->getData(self::ORDER_ITEM_ID);
    }

    /**
     * @inheritDoc
     */
    public function setOrderItemId($orderItemId)
    {
        return $this->setData(self::ORDER_ITEM_ID, $orderItemId);
    }

    /**
     * @inheritDoc
     */
    public function getOrderItemSku()
    {
        return $this->getData(self::ORDER_ITEM_SKU);
    }

    /**
     * @inheritDoc
     */
    public function setOrderItemSku($orderItemSku)
    {
        return $this->setData(self::ORDER_ITEM_SKU, $orderItemSku);
    }

    /**
     * @inheritDoc
     */
    public function getOrderItemPrice()
    {
        return $this->getData(self::ORDER_ITEM_PRICE);
    }

    /**
     * @inheritDoc
     */
    public function setOrderItemPrice($orderItemPrice)
    {
        return $this->setData(self::ORDER_ITEM_PRICE, $orderItemPrice);
    }

    /**
     * @inheritDoc
     */
    public function getCommisionType()
    {
        return $this->getData(self::COMMISION_TYPE);
    }

    /**
     * @inheritDoc
     */
    public function setCommisionType($commisionType)
    {
        return $this->setData(self::COMMISION_TYPE, $commisionType);
    }

    /**
     * @inheritDoc
     */
    public function getCommissionValue()
    {
        return $this->getData(self::COMMISSION_VALUE);
    }

    /**
     * @inheritDoc
     */
    public function setCommissionValue($commissionValue)
    {
        return $this->setData(self::COMMISSION_VALUE, $commissionValue);
    }
}
