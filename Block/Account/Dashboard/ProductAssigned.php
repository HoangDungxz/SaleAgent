<?php

namespace AHT\SaleAgent\Block\Account\Dashboard;

class ProductAssigned extends \Magento\Framework\View\Element\Template
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
        $this->pageConfig->getTitle()->set(__('My Product Sale Agent'));
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
        )->setOrder(
            'created_at',
            'desc'
        );
        $this->setProAgent($productAgents);
    }

    /**
     * @inheritDoc
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if ($this->getProAgent()) {
            $pager = $this->getLayout()->createBlock(
                \Magento\Theme\Block\Html\Pager::class,
                'saleagent.product.index.pager'
            )->setCollection(
                $this->getProAgent()
            );
            $this->setChild('pager', $pager);
            $this->getProAgent()->load();
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
