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

namespace WellCommerce\Bundle\AvailabilityBundle\Tests\Factory;

use WellCommerce\Bundle\CoreBundle\Test\Factory\AbstractEntityFactoryTestCase;

/**
 * Class AvailabilityFactoryTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AvailabilityFactoryTest extends AbstractEntityFactoryTestCase
{
    protected function getFactoryService()
    {
        return $this->container->get('availability.factory');
    }

    protected function getExpectedInterface()
    {
        return 'WellCommerce\Bundle\AvailabilityBundle\Entity\AvailabilityInterface';
    }
}
