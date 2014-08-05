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
namespace WellCommerce\Bundle\CoreBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use WellCommerce\Bundle\CoreBundle\DataGrid\DataGridInterface;
use WellCommerce\Bundle\CoreBundle\DataSet\DataSetInterface;

/**
 * Class DataGridEvent
 *
 * @package WellCommerce\Bundle\CoreBundle\Event
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DataSetEvent extends Event
{
    /**
     * @var \WellCommerce\Bundle\CoreBundle\DataSet\DataSetInterface
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