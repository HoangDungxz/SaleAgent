<?php

namespace AHT\SaleAgent\Block\Html;

class Header extends \Magento\Theme\Block\Html\Header
{
    /**
     * @param \Magento\Customer\Model\SessionFactory
     */
    private $_customerSession;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\SessionFactory $customerSession,
        array $data = []
    ) {
        $this->_customerSession = $customerSession;
        parent::__construct($context, $data);
    }

    /**
     * Current template name
     *
     * @var string
     */
    protected $_template = 'AHT_SaleAgent::html/header.phtml';

    /**
     * examine is sale agent
     *
     * @return true|false
     */
    public function isSaleAgent()
    {
        $customer = $this->_customerSession->create();
        if (!empty($customer->getCustomer()) &&  (intval($customer->getCustomer()->getIsSalesAgent()) == 1)) {
            return true;
        } else {
            return false;
        }
    }
}
