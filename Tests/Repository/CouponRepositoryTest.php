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

namespace WellCommerce\Bundle\CouponBundle\Tests\Repository;

use WellCommerce\Bundle\CoreBundle\Test\Repository\AbstractRepositoryTestCase;

/**
 * Class CouponRepositoryTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CouponRepositoryTest extends AbstractRepositoryTestCase
{
    protected function getAlias()
    {
        return 'coupon';
    }

    protected function get()
    {
        return $this->container->get('coupon.repository');
    }
}
