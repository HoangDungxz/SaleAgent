<?php

/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace AHT\SaleAgent\Model\Attribute\Source;

class SaleAgentId extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{

    /**
     * @param \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory
     */
    private $_collectionFactory;

    /**
     * Constructor
     *
     * @param 
     * @param 
     */
    public function __construct(
        \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $collectionFactory
    ) {
        $this->_collectionFactory = $collectionFactory;
    }

    /**
     * getAllOptions
     *
     * @return array
     */
    public function getAllOptions()
    {
        $customerCollection = $this->_collectionFactory->create();
        $customerCollection->addAttributeToFilter('is_sales_agent', 1);
        $this->_options = [
            ['value' => '', 'label' => '-- No select Sale Agent --']
        ];
        foreach ($customerCollection as $customer) {
            array_push($this->_options, ['value' => $customer->getId(), 'label' => $customer->getName()]);
        }
        return $this->_options;
    }
}
