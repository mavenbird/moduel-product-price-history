<?php
namespace Mavenbird\ProductPriceHistory\Model\ResourceModel\PriceHistory;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

// AbstractCollection se automatically milta hai:
// - addFieldToFilter() - WHERE clause
// - setOrder() - ORDER BY
// - setPageSize() - LIMIT
// - load() - Execute query
class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id'; // Primary key

    protected function _construct()
    {
        // Parameter 1: Model class — ek record kaisa dikhega
        // Parameter 2: ResourceModel class — kahan se data aayega
        $this->_init(
            \Mavenbird\ProductPriceHistory\Model\PriceHistory::class,
            \Mavenbird\ProductPriceHistory\Model\ResourceModel\PriceHistory::class
        );
    }
}

// Collection ka use:
// $collection->addFieldToFilter('product_id', 5);  → WHERE product_id = 5
// $collection->setOrder('changed_at', 'DESC');      → Latest pehle
// foreach ($collection as $record) { ... }          → Loop karo