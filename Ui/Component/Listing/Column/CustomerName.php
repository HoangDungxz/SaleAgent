<?php

namespace AHT\SaleAgent\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;


class CustomerName extends \Magento\Ui\Component\Listing\Columns\Column
{

    protected $_storeManager;

    /**
     * @param \Magento\Customer\Model\CustomerRegistry
     */
    private $_customerRegistry;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Customer\Model\CustomerRegistry $customerRegistry,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->urlBuilder = $urlBuilder;
        $this->_storeManager = $storeManager;
        $this->_customerRegistry = $customerRegistry;
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $nameColumn = $this->getData('name');
            foreach ($dataSource['data']['items'] as &$item) {
                $saleAgent = new \Magento\Framework\DataObject($item);
                $customer = $this->_customerRegistry->retrieve($saleAgent['entity_id']);
                $item[$nameColumn] = $customer->getName();
            }
        }
        return $dataSource;
    }
}
