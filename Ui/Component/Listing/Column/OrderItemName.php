<?php

namespace AHT\SaleAgent\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;


class OrderItemName extends \Magento\Ui\Component\Listing\Columns\Column
{


    protected $_storeManager;

    /**
     * @param \Magento\Catalog\Model\ProductRepository
     */
    private $_productRepository;

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
        \Magento\Catalog\Model\ProductRepository $productRepository,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->urlBuilder = $urlBuilder;
        $this->_storeManager = $storeManager;
        $this->_productRepository = $productRepository;
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
                $product = $this->_productRepository->getById($saleAgent['order_item_id']);
                $item[$nameColumn] = $product->getName();
            }
        }
        return $dataSource;
    }
}
