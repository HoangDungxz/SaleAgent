<?php

namespace AHT\SaleAgent\Block\Account\Dashboard;

class SaleAgent extends \Magento\Framework\View\Element\Template
{
    /**
     * Limit of orders
     */
    const PRODUCT_LIMIT = 5;

    /**
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    private $_productCollectionFactory;

    /**
     * @param \Magento\Customer\Model\Session
     */
    private $_customerSession;

    /**
     * @param \Magento\Framework\Pricing\PriceCurrencyInterface
     */
    private $_priceCurrency;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        array $data = []
    ) {
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_customerSession = $customerSession;
        $this->_priceCurrency = $priceCurrency;
        parent::__construct($context, $data);
        $this->getProductAgent();
    }

    /**
     * Get recently placed product agent. By default they will be limited by 5.
     */
    private function getProductAgent()
    {
        $productAgents = $this->_productCollectionFactory->create()->addAttributeToSelect(
            '*'
        )->addAttributeToFilter(
            'sale_agent_id',
            $this->_customerSession->getCustomerId()
        )->addAttributeToSort(
            'created_at',
            'desc'
        )->setPageSize(
            self::PRODUCT_LIMIT
        )->load();

        $this->setProAgent($productAgents);
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
     * Function getFormatedPercent
     *
     * @param float $price
     *
     * @return string
     */
    function getFormatedPercent($commissionValue)
    {
        $priceFormat = number_format($commissionValue, 1) . '%';
        return $priceFormat;
    }

    /**
     * Function getFormatedPercent
     *
     * @param float $price
     *
     * @return string
     */
    function checkTypeCommission($commissionType)
    {
        if ($commissionType == 'percent') {
            return true;
        } else {
            return false;
        }
    }
}
