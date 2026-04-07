<?php
namespace Mavenbird\ProductPriceHistory\Model;

use Magento\Framework\Model\AbstractModel;

// AbstractModel extend karne se automatically yeh milta hai:
// - load(), save(), delete() methods
// - getData(), setData() methods
// - Magic getters/setters (getSku(), setNewPrice(), etc.)

class PriceHistory extends AbstractModel
{
    protected function _construct()
    {
        // Yeh model ResourceModel\PriceHistory use karega DB ke liye
        // Aur table ki primary key 'id' hai
        $this->_init(ResourceModel\PriceHistory::class);
    }
}