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

namespace WellCommerce\Bundle\CoreBundle\DataSet\Processor;

/**
 * Interface ProcessorInterface
 *
 * @package WellCommerce\Bundle\CoreBundle\DataSet\Processor
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ProcessorInterface
{
    /**
     * Processes and returns new set of data
     *
     * @return mixed
     */
    public function process();
}
