<?php

namespace Mavenbird\ProductPriceHistory\Ui\DataProvider\PriceHistory;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Mavenbird\ProductPriceHistory\Model\ResourceModel\PriceHistory\CollectionFactory;
use Magento\Framework\App\RequestInterface;

class ViewDataProvider extends AbstractDataProvider
{
    private int $productId = 0;

    public function __construct(
        string             $name,
        string             $primaryFieldName,
        string             $requestFieldName,
        CollectionFactory  $collectionFactory,
        private RequestInterface $request,
        array              $meta = [],
        array              $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();

        $this->productId = (int)$this->request->getParam('product_id');
    }

    public function getData(): array
    {
        if ($this->productId) {
            $this->collection->addFieldToFilter('product_id', $this->productId);
        }

        $connection   = $this->collection->getResource()->getConnection();
        $productTable = $connection->getTableName('catalog_product_entity');
        $varcharTable = $connection->getTableName('catalog_product_entity_varchar');
        $eavTable     = $connection->getTableName('eav_attribute');

        $this->collection->getSelect()
            ->joinLeft(
                ['cpe' => $productTable],
                'main_table.product_id = cpe.entity_id',
                []
            )
            ->joinLeft(
                ['ea' => $eavTable],
                "ea.attribute_code = 'name' AND ea.entity_type_id = 4",
                []
            )
            ->joinLeft(
                ['cpev' => $varcharTable],
                'cpev.entity_id = cpe.entity_id AND cpev.attribute_id = ea.attribute_id AND cpev.store_id = 0',
                ['product_name' => 'cpev.value']
            );

        $this->collection->setOrder('changed_at', 'DESC');

        return $this->collection->toArray();
    }

    public function addFilter(\Magento\Framework\Api\Filter $filter): void
    {
        if ($filter->getField() === 'product_id') {
            return;
        }
        parent::addFilter($filter);
    }
}
