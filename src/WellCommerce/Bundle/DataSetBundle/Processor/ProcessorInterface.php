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

namespace WellCommerce\Bundle\DataSetBundle\Processor;

use WellCommerce\Bundle\DataSetBundle\DataSetInterface;
use WellCommerce\Bundle\DataSetBundle\Request\DataSetRequestInterface;

/**
 * Interface ProcessorInterface
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
interface ProcessorInterface
{
    /**
     * Processes dataset results returned from query builder
     *
     * @param DataSetInterface        $dataset
     * @param array                   $result
     * @param int                     $total
     * @param DataSetRequestInterface $request
     *
     * @return array
     */
    public function processResult(DataSetInterface $dataset, $result, $total, DataSetRequestInterface $request);
}
