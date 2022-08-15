<?php

namespace AHT\SaleAgent\Block\Account\Dashboard;

class OrderSaleAgent extends \Magento\Framework\View\Element\Template
{

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
     * @param \AHT\SaleAgent\Model\ResourceModel\SaleAgent\Collection
     */
    private $dataCollection;

    /**
     * @param \Magento\Catalog\Model\ProductRepository
     */
    private $_productRepository;

    /**
     * @param \Magento\Customer\Model\CustomerRegistry
     */
    private $_customerRegistry;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        \AHT\SaleAgent\Model\ResourceModel\SaleAgent\CollectionFactory $saleAgentCollection,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Customer\Model\CustomerRegistry $customerRegistry,
        array $data = []
    ) {
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_customerSession = $customerSession;
        $this->_priceCurrency = $priceCurrency;
        $this->dataCollection = $saleAgentCollection;
        $this->_productRepository = $productRepository;
        $this->_customerRegistry = $customerRegistry;
        parent::__construct($context, $data);
        $this->getProductAgent();
        $this->getSaleAgent();
    }

    /**
     * Get recently placed product agent.
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
        )->load();
        $this->setProAgent($productAgents);
    }

    /**
     * Get recently placed sale agent.
     */
    private function getSaleAgent()
    {
        $saleAgentCollection = $this->dataCollection->create()
            ->addFieldToFilter(
                'entity_id',
                $this->_customerSession->getCustomerId()
            )->load();
        $this->setAgent($saleAgentCollection);
    }

    /**
     * @inheritDoc
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if ($this->getAgent()) {
            $pager = $this->getLayout()->createBlock(
                \Magento\Theme\Block\Html\Pager::class,
                'saleagent.product.index.pager'
            )->setCollection(
                $this->getAgent()
            );
            $this->setChild('pager', $pager);
        }
        return $this;
    }

    /**
     * Get Pager child block output
     *
     * @return string
     */
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    /**
     * Function getProduct
     *
     * @param string $sku
     *
     * @return object
     */
    public function getProduct($sku)
    {
        return $this->_productRepository->get($sku);
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
    function getFormatedPercent($commissionValue, $productPrice)
    {
        $price = $productPrice * $commissionValue / 100;
        $priceFormat = number_format($commissionValue, 1) . '% => ' . $this->getFormatedPrice($price);
        return $priceFormat;
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
