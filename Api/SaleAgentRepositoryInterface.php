<?php

/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace AHT\SaleAgent\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface SaleAgentRepositoryInterface
{

    /**
     * Save SaleAgent
     * @param \Magento\Framework\Model\AbstractModel $saleAgent
     * @return \Magento\Framework\Model\AbstractModel
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Magento\Framework\Model\AbstractModel $saleAgent
    );

    /**
     * Retrieve SaleAgent
     * @param string $saleagentId
     * @return \AHT\SaleAgent\Api\Data\SaleAgentInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($saleagentId);

    /**
     * Retrieve SaleAgent matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \AHT\SaleAgent\Api\Data\SaleAgentSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete SaleAgent
     * @param \AHT\SaleAgent\Api\Data\SaleAgentInterface $saleAgent
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \AHT\SaleAgent\Api\Data\SaleAgentInterface $saleAgent
    );

    /**
     * Delete SaleAgent by ID
     * @param string $saleagentId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($saleagentId);
}
