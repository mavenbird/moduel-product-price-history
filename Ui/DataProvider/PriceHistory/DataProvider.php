<?php

namespace Mavenbird\ProductPriceHistory\Ui\DataProvider\PriceHistory;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Mavenbird\ProductPriceHistory\Model\ResourceModel\PriceHistory\CollectionFactory;

class DataProvider extends AbstractDataProvider
{
    public function __construct(
        string            $name,
        string            $primaryFieldName,
        string            $requestFieldName,
        CollectionFactory $collectionFactory,
        array             $meta = [],
        array             $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
    }

    public function getData(): array
    {
        /** @var \Mavenbird\ProductPriceHistory\Model\ResourceModel\PriceHistory\Collection $collection */
        $collection = $this->collection;

        $connection = $collection->getResource()->getConnection();
        $mainTable  = $collection->getMainTable();

        $subquery = $connection->select()
            ->from($mainTable, ['max_id' => new \Zend_Db_Expr('MAX(id)')])
            ->group('product_id');

        $collection->getSelect()->where('main_table.id IN (?)', $subquery);

        $productTable = $connection->getTableName('catalog_product_entity');
        $varcharTable = $connection->getTableName('catalog_product_entity_varchar');
        $eavTable     = $connection->getTableName('eav_attribute');

        $collection->getSelect()
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

        return $collection->toArray();
    }
}
