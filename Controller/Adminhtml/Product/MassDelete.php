<?php

namespace AHT\SaleAgent\Controller\Adminhtml\Product;

class MassDelete extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'AHT_SaleAgent::massdelete';

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_pageFactory;

    /**
     * @param \AHT\SaleAgent\Model\ResourceModel\SaleAgent\CollectionFactory
     */
    private $_collectionFactory;

    /**
     * @param \AHT\SaleAgent\Model\SaleAgentRepository
     */
    private $_saleAgentRepository;

    /**
     * @param \Magento\Backend\Model\View\Result\RedirectFactory
     */
    private $_redirectFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \AHT\SaleAgent\Model\ResourceModel\SaleAgent\CollectionFactory $collectionFactory,
        \AHT\SaleAgent\Model\SaleAgentRepository $saleAgentRepository,
        \Magento\Backend\Model\View\Result\RedirectFactory $redirectFactory
    ) {
        $this->_pageFactory = $pageFactory;
        $this->_collectionFactory = $collectionFactory;
        $this->_saleAgentRepository = $saleAgentRepository;
        $this->_redirectFactory = $redirectFactory;
        return parent::__construct($context);
    }

    /**
     * Index action
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->_redirectFactory->create();

        /** @var \AHT\SaleAgent\Model\ResourceModel\SaleAgent\Collection $CustomData */
        $CustomData = $this->_collectionFactory->create();
        foreach ($CustomData as $value) {
            $templateId[] = $value['saleagent_id'];
        }

        // get id url
        $parameterData = $this->getRequest()->getParams('saleagent_id');
        $selectedAppsid = $this->getRequest()->getParams('saleagent_id');

        if (array_key_exists("selected", $parameterData)) {
            $selectedAppsid = $parameterData['selected'];
        }

        if (array_key_exists("excluded", $parameterData)) {
            if ($parameterData['excluded'] == 'false') {
                $selectedAppsid = $templateId;
            } else {
                $selectedAppsid = array_diff($templateId, $parameterData['excluded']);
            }
        }

        if (!is_array($selectedAppsid)) {
            $this->messageManager->addErrorMessage(__('Please select item(s).'));
        } else {
            try {
                // delete mass item
                foreach ($selectedAppsid as $id) {
                    $this->_saleAgentRepository->deleteById($id);
                }
                $this->messageManager->addSuccessMessage(__('Total of %1 record(s) were successfully deleted.', count($selectedAppsid)));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }
        return $resultRedirect->setPath('*/product/index/');
    }

    /**
     * Is the user allowed to view the page.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(static::ADMIN_RESOURCE);
    }
}
