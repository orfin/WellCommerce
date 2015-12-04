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

namespace WellCommerce\Bundle\ReportBundle\Context;

use WellCommerce\Bundle\ReportBundle\Configuration\ReportConfiguration;
use WellCommerce\Bundle\AppBundle\Data\ReportRow;
use WellCommerce\Bundle\AppBundle\Data\ReportRowCollection;

/**
 * Class LineChartContext
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LineChartContext implements ReportContextInterface
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
     * @var array
     */
    protected $items = [];

    /**
     * Constructor
     *
     * @param ReportRowCollection $collection
     * @param ReportConfiguration $configuration
     */
    public function __construct(ReportRowCollection $collection, ReportConfiguration $configuration)
    {
        $this->collection    = $collection;
        $this->configuration = $configuration;
        $this->prepareData();
    }

    protected function prepareData()
    {
        $this->items = $this->prepareValues();
        $this->collection->map(function (ReportRow $row) {
            $this->items[$row->getIdentifier()]['value'] += $row->getValue();
        });
    }

    /**
     * @return array
     */
    protected function prepareValues()
    {
        $periods = $this->configuration->getPeriods();
        $values  = [];

        foreach ($periods as $period) {
            $values[$period->format($this->configuration->getGroupByDateFormat())] = [
                'value' => 0,
                'meta'  => $period->format($this->configuration->getDatePresentationFormat())
            ];
        }

        return $values;
    }

    /**
     * {@inheritdoc}
     */
    public function getLabels()
    {
        return array_keys($this->items);
    }

    /**
     * {@inheritdoc}
     */
    public function getValues()
    {
        return array_values($this->items);
    }
}
