<?php
namespace Mavenbird\ProductPriceHistory\Model\ResourceModel\PriceHistory;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id'; 
    protected function _construct()
    {
        $this->_init(
            \Mavenbird\ProductPriceHistory\Model\PriceHistory::class,
            \Mavenbird\ProductPriceHistory\Model\ResourceModel\PriceHistory::class
        );
    }
}

