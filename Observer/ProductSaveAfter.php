<?php

namespace Mavenbird\ProductPriceHistory\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Mavenbird\ProductPriceHistory\Model\PriceHistoryFactory;
use Mavenbird\ProductPriceHistory\Model\ResourceModel\PriceHistory as PriceHistoryResource;
use Magento\Backend\Model\Auth\Session as AdminSession;

class ProductSaveAfter implements ObserverInterface
{
    public function __construct(
        private PriceHistoryFactory  $priceHistoryFactory,
        private PriceHistoryResource $priceHistoryResource,
        private AdminSession         $adminSession
    ) {}

    public function execute(Observer $observer): void
    {
        $product = $observer->getEvent()->getProduct();

        $oldPrice = $product->getOrigData('price');
        $newPrice = $product->getData('price');

        if ($oldPrice === null || (float)$oldPrice === (float)$newPrice) {
            return;
        }

        $adminUser = $this->adminSession->getUser();
        $userName  = $adminUser ? $adminUser->getUserName() : 'system';

        $history = $this->priceHistoryFactory->create();
        $history->setData([
            'product_id'       => $product->getId(),
            'sku'              => $product->getSku(),
            'old_price'        => $oldPrice,
            'new_price'        => $newPrice,
            'store_id'         => $product->getStoreId(),
            'changed_by_user'  => $userName,
        ]);

        $this->priceHistoryResource->save($history);
    }
}
