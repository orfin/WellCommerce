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

namespace WellCommerce\CatalogBundle\Tests\Factory;

use WellCommerce\AppBundle\Test\Factory\AbstractFactoryTestCase;

/**
 * Class ProductFactoryTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductFactoryTest extends AbstractFactoryTestCase
{
    protected function getFactoryService()
    {
        return $this->container->get('product.factory');
    }

    protected function getExpectedInterface()
    {
        return 'WellCommerce\CatalogBundle\Entity\ProductInterface';
    }
}
