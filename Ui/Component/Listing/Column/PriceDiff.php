<?php
namespace Mavenbird\ProductPriceHistory\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;

class PriceDiff extends Column
{
    public function prepare(): void
    {
        parent::prepare();
        // BUG FIX #2: HTML render karne ke liye bodyTmpl set karo
        // Bina iske raw HTML string show hoti hai
        $this->setData('config', array_merge(
            (array)$this->getData('config'),
            ['bodyTmpl' => 'ui/grid/cells/html']
        ));
    }

    public function prepareDataSource(array $dataSource): array
    {
        if (!isset($dataSource['data']['items'])) {
            return $dataSource;
        }

        foreach ($dataSource['data']['items'] as &$item) {
            $old  = (float)($item['old_price'] ?? 0);
            $new  = (float)($item['new_price'] ?? 0);
            $diff = $new - $old;

            $color = $diff >= 0 ? 'green' : 'red';
            $sign  = $diff >= 0 ? '+' : '';

            $item['price_diff'] = sprintf(
                '<span style="color:%s; font-weight:bold;">%s%.4f</span>',
                $color,
                $sign,
                $diff
            );
        }

        return $dataSource;
    }
}