<?php

namespace Mavenbird\ProductPriceHistory\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Mavenbird\ProductPriceHistory\Model\ResourceModel\PriceHistory\Collection;
use Magento\Framework\Controller\ResultFactory;


class MassDelete extends Action
{

    const ADMIN_RESOURCE = 'Mavenbird_ProductPriceHistory::delete';

    /**
     * @param Context    $context    
     * @param Filter     $filter     
     *                               
     * @param Collection $collection 
     *                               
     */
    public function __construct(
        Context $context,
        private Filter $filter,
        private Collection $collection
    ) {
        parent::__construct($context);
    }


    public function execute()
    {
        $collection = $this->filter->getCollection($this->collection);

        $deletedCount = 0;

        foreach ($collection as $record) {
            $record->delete();
            $deletedCount++;
        }

        $this->messageManager->addSuccessMessage(
            __('A total of %1 record(s) have been deleted.', $deletedCount)
        );

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
