<?php
namespace Mavenbird\ProductPriceHistory\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    const ADMIN_RESOURCE = 'Mavenbird_ProductPriceHistory::menu';

    public function __construct(
        Context     $context,
        private PageFactory $resultPageFactory
    ) {
        parent::__construct($context); 
    }

    public function execute() 
    {
        $resultPage = $this->resultPageFactory->create();

        $resultPage->getConfig()->getTitle()->prepend(__('Product Price History'));

        return $resultPage; 
    }
}