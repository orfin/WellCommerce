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

namespace WellCommerce\AppBundle\Tests\Repository;

use WellCommerce\CoreBundle\Test\Repository\AbstractRepositoryTestCase;

/**
 * Class UnitRepositoryTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UnitRepositoryTest extends AbstractRepositoryTestCase
{
    protected function get()
    {
        return $this->container->get('unit.repository');
    }
}
