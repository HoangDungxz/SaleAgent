<?php

namespace AHT\SaleAgent\Block\Account\Dashboard;

class SaleAgentCommission extends \Magento\Framework\View\Element\Template
{
    /**
     * Limit of orders
     */
    const PRODUCT_LIMIT = 5;

    /**
     * @param \Magento\Customer\Model\Session
     */
    private $_customerSession;

    /**
     * @param \Magento\Framework\Pricing\PriceCurrencyInterface
     */
    private $_priceCurrency;

    /**
     * @var \AHT\SaleAgent\Model\ResourceModel\SaleAgent\CollectionFactory
     */
    private $_saleAgentCollection;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        \AHT\SaleAgent\Model\ResourceModel\SaleAgent\CollectionFactory $collection,
        array $data = []
    ) {
        $this->_customerSession = $customerSession;
        $this->_priceCurrency = $priceCurrency;
        $this->_saleAgentCollection = $collection;
        parent::__construct($context, $data);
        $this->getSaleAgent();
    }

    /**
     * Get recently placed product agent. By default they will be limited by 5.
     */
    private function getSaleAgent()
    {
        $productAgents = $this->_saleAgentCollection->create()
            ->addFieldToFilter(
                'entity_id',
                $this->_customerSession->getCustomerId()
            )->setOrder(
                'order_id',
                'desc'
            )->setPageSize(
                self::PRODUCT_LIMIT
            )->load();

        $this->setAgent($productAgents);
    }

    /**
     * Function getFormatedPrice
     *
     * @param float $price
     *
     * @return string
     */
    public function getFormatedPrice($price)
    {
        return $this->_priceCurrency->convertAndFormat($price);
    }

    /**
     * Function convertQty
     *
     * @param float $qty
     *
     * @return int|null
     */
    function convertQty($qty)
    {
        return intval($qty);
    }
}
