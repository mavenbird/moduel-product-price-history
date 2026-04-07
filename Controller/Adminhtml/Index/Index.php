<?php
namespace Mavenbird\ProductPriceHistory\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

// URL: domain.com/admin/pricehistory/index/index
//                        ↑frontName   ↑Controller ↑Action(method)
// Controller folder: Index → Action file: Index.php → execute() method
class Index extends Action
{
    // ACL resource — sirf wahi admin dekh sake jiske paas yeh permission ho
    const ADMIN_RESOURCE = 'Mavenbird_ProductPriceHistory::menu';

    public function __construct(
        Context     $context,
        // PageFactory: result page object banane ke liye
        private PageFactory $resultPageFactory
    ) {
        parent::__construct($context); // Parent ka constructor zarur chalao
    }

    public function execute() // Yeh method automatically call hoti hai
    {
        // Naya admin page banao
        $resultPage = $this->resultPageFactory->create();

        // Browser tab aur admin header mein title set karo
        $resultPage->getConfig()->getTitle()->prepend(__('Product Price History'));

        return $resultPage; // Page return karo — Magento render karega
    }
}