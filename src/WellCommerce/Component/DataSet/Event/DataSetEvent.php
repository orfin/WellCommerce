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

namespace WellCommerce\Component\DataSet\Event;

use Symfony\Component\EventDispatcher\Event;
use WellCommerce\Component\DataSet\DataSetInterface;

/**
 * Class DataSetEvent
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DataSetEvent extends Event
{
    /**
     * @var DataSetInterface
     */
    protected $dataset;

    /**
     * Constructor
     *
     * @param DataSetInterface $dataset
     */
    public function __construct(DataSetInterface $dataset)
    {
        $this->dataset = $dataset;
    }

    /**
     * Returns current dataset
     *
     * @return DataSetInterface
     */
    public function getDataSet()
    {
        return $this->dataset;
    }
}
