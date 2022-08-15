<?php

namespace AHT\SaleAgent\Controller\Adminhtml\Product;

class Delete extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'AHT_SaleAgent::delete';

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_pageFactory;

    /**
     * @param \Magento\Backend\Model\View\Result\RedirectFactory
     */
    private $_redirectFactory;

    /**
     * @param \AHT\SaleAgent\Model\SaleAgentRepository
     */
    private $_saleAgentRepository;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Magento\Backend\Model\View\Result\RedirectFactory $redirectFactory,
        \AHT\SaleAgent\Model\SaleAgentRepository $saleAgentRepository
    ) {
        $this->_pageFactory = $pageFactory;
        $this->_redirectFactory = $redirectFactory;
        $this->_saleAgentRepository = $saleAgentRepository;
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
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('saleagent_id');
        if ($id) {
            $this->_saleAgentRepository->deleteById($id);
            // display success message
            $this->messageManager->addSuccessMessage(__('You deleted the product agent.'));
            // go to grid
            return $resultRedirect->setPath('*/product/index/');
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a product agent to delete.'));
        // go to grid
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
