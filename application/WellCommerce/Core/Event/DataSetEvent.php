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
namespace WellCommerce\Core\Event;

use Symfony\Component\EventDispatcher\Event;
use WellCommerce\Core\DataGrid\DataGridInterface;
use WellCommerce\Core\DataSet\DataSetInterface;

/**
 * Class DataGridEvent
 *
 * @package WellCommerce\Core\Event
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DataSetEvent extends Event
{
    /**
     * @var \WellCommerce\Core\DataSet\DataSetInterface
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
     * Returns DataSet
     *
     * @return DataSetInterface
     */
    public function getDataSet()
    {
        return $this->dataset;
    }
}