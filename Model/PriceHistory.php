<?php
namespace Mavenbird\ProductPriceHistory\Model;

use Magento\Framework\Model\AbstractModel;

class PriceHistory extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ResourceModel\PriceHistory::class);
    }
}