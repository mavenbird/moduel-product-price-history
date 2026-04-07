<?php
namespace Mavenbird\ProductPriceHistory\Controller\Adminhtml\View;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    const ADMIN_RESOURCE = 'Mavenbird_ProductPriceHistory::menu';

    public function __construct(
        Context $context,
        private PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
    }

    public function execute()
    {
        $productId = $this->getRequest()->getParam('product_id');

        if (!$productId) {
            $this->messageManager->addErrorMessage(__('Product ID not found.'));
            return $this->resultRedirectFactory->create()
                ->setPath('pricehistory/index/index');
        }

        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()
            ->prepend(__('Price History for Product ID: %1', $productId));

        return $resultPage;
    }
}