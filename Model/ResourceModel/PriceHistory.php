<?php
namespace Mavenbird\ProductPriceHistory\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class PriceHistory extends AbstractDb
{
    protected function _construct()
    {

        $this->_init('mavenbird_product_price_history', 'id');
    }
}