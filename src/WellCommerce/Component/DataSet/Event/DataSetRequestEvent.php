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
use WellCommerce\Component\DataSet\Request\DataSetRequestInterface;

/**
 * Class DataSetEvent
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class DataSetRequestEvent extends Event
{
    const EVENT_SUFFIX = 'request';
    
    /**
     * @var DataSetInterface
     */
    private $dataset;

    /**
     * @var DataSetRequestInterface
     */
    private $request;

    /**
     * DataSetRequestEvent constructor.
     *
     * @param DataSetInterface        $dataset
     * @param DataSetRequestInterface $request
     */
    public function __construct(DataSetInterface $dataset, DataSetRequestInterface $request)
    {
        $this->dataset = $dataset;
        $this->request = $request;
    }

    public function getDataSet() : DataSetInterface
    {
        return $this->dataset;
    }

    public function getRequest() : DataSetRequestInterface
    {
        return $this->request;
    }
}
