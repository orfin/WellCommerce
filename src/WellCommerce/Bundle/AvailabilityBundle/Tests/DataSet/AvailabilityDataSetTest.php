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

namespace WellCommerce\Bundle\AvailabilityBundle\Tests\DataSet;

use WellCommerce\Bundle\CoreBundle\Tests\DataSet\AbstractDataSetTestCase;

/**
 * Class AvailabilityDataSetTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AvailabilityDataSetTest extends AbstractDataSetTestCase
{
    protected function getService()
    {
        return $this->container->get('availability.dataset');
    }

    protected function getColumns()
    {
        return [
            'id'   => 'availability.id',
            'name' => 'availability_translation.name',
        ];
    }
}
