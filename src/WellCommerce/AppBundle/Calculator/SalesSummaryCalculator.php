<?php
/*
 * WellCommerce Open-Source E-Commerce Platform
 * 
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 * 
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace WellCommerce\ReportBundle\Calculator;

use DateTime;
use Doctrine\Common\Collections\Collection;
use WellCommerce\ReportBundle\Configuration\ReportConfiguration;
use WellCommerce\ReportBundle\Data\ReportRow;
use WellCommerce\ReportBundle\Data\ReportRowCollection;

/**
 * Class SalesSummaryCalculator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class SalesSummaryCalculator
{
    /**
     * @var ReportRowCollection
     */
    protected $collection;

    /**
     * @var ReportConfiguration
     */
    protected $configuration;

    /**
     * Constructor
     *
     * @param ReportRowCollection $collection
     * @param ReportConfiguration $configuration
     */
    public function __construct(
        ReportRowCollection $collection,
        ReportConfiguration $configuration
    ) {
        $this->collection    = $collection;
        $this->configuration = $configuration;
    }

    public function getSummary()
    {
        $totalValue        = $this->getCollectionValue($this->collection);
        $totalCount        = $this->collection->count();
        $currentCollection = $this->filterCurrentItems($this->collection);
        $currentCount      = $currentCollection->count();
        $currentValue      = $this->getCollectionValue($currentCollection);

        return [
            'totalValue'   => $totalValue,
            'currentValue' => $currentValue,
            'totalCount'   => $totalCount,
            'currentCount' => $currentCount
        ];
    }

    protected function getCollectionValue(Collection $collection)
    {
        $value = 0;
        $collection->map(function (ReportRow $row) use (&$value) {
            $value += $row->getValue();
        });

        return $value;
    }

    /**
     * Filters a collection to get only current items
     *
     * @param Collection $collection
     *
     * @return Collection
     */
    protected function filterCurrentItems(Collection $collection)
    {
        $endDate    = new DateTime();
        $format     = $this->configuration->getGroupByDateFormat();
        $identifier = $endDate->format($format);

        return $collection->filter(function (ReportRow $row) use ($identifier) {
            return $row->getIdentifier() === $identifier;
        });
    }
}
