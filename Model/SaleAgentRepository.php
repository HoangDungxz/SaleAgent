<?php

/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace AHT\SaleAgent\Model;

use AHT\SaleAgent\Api\Data\SaleAgentInterfaceFactory;
use AHT\SaleAgent\Api\Data\SaleAgentSearchResultsInterfaceFactory;
use AHT\SaleAgent\Api\SaleAgentRepositoryInterface;
use AHT\SaleAgent\Model\ResourceModel\SaleAgent as ResourceSaleAgent;
use AHT\SaleAgent\Model\ResourceModel\SaleAgent\CollectionFactory as SaleAgentCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;

class SaleAgentRepository implements SaleAgentRepositoryInterface
{

    protected $dataObjectHelper;

    protected $extensibleDataObjectConverter;
    protected $dataSaleAgentFactory;

    private $collectionProcessor;

    protected $saleAgentFactory;

    private $storeManager;

    protected $searchResultsFactory;

    protected $resource;

    protected $extensionAttributesJoinProcessor;

    protected $dataObjectProcessor;

    protected $saleAgentCollectionFactory;


    /**
     * @param ResourceSaleAgent $resource
     * @param SaleAgentFactory $saleAgentFactory
     * @param SaleAgentInterfaceFactory $dataSaleAgentFactory
     * @param SaleAgentCollectionFactory $saleAgentCollectionFactory
     * @param SaleAgentSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceSaleAgent $resource,
        SaleAgentFactory $saleAgentFactory,
        SaleAgentInterfaceFactory $dataSaleAgentFactory,
        SaleAgentCollectionFactory $saleAgentCollectionFactory,
        SaleAgentSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->saleAgentFactory = $saleAgentFactory;
        $this->saleAgentCollectionFactory = $saleAgentCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataSaleAgentFactory = $dataSaleAgentFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \Magento\Framework\Model\AbstractModel $saleAgent
    ) {
        try {
            $this->resource->save($saleAgent);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the sale agent: %1',
                $exception->getMessage()
            ));
        }
        return $saleAgent;
    }

    /**
     * {@inheritdoc}
     */
    public function get($saleAgentId)
    {
        $saleAgent = $this->saleAgentFactory->create();
        $this->resource->load($saleAgent, $saleAgentId);
        if (!$saleAgent->getId()) {
            throw new NoSuchEntityException(__('SaleAgent with id "%1" does not exist.', $saleAgentId));
        }
        return $saleAgent->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->saleAgentCollectionFactory->create();

        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \AHT\SaleAgent\Api\Data\SaleAgentInterface::class
        );

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model->getDataModel();
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \AHT\SaleAgent\Api\Data\SaleAgentInterface $saleAgent
    ) {
        try {
            $saleAgentModel = $this->saleAgentFactory->create();
            $this->resource->load($saleAgentModel, $saleAgent->getSaleagentId());
            $this->resource->delete($saleAgentModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the SaleAgent: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($saleAgentId)
    {
        return $this->delete($this->get($saleAgentId));
    }
}
