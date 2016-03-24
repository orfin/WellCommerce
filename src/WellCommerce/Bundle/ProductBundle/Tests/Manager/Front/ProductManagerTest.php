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

namespace WellCommerce\Bundle\ProductBundle\Tests\Manager\Front;

use WellCommerce\Bundle\CoreBundle\Test\Manager\Front\AbstractFrontManagerTestCase;

/**
 * Class ProductManagerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductManagerTest extends AbstractFrontManagerTestCase
{
    protected function get()
    {
        return $this->container->get('product.manager.front');
    }

    protected function getServiceClassName()
    {
        return \WellCommerce\Bundle\ProductBundle\Manager\Front\ProductManager::class;
    }

    protected function getRepositoryInterfaceName()
    {
        return \WellCommerce\Bundle\ProductBundle\Repository\ProductRepositoryInterface::class;
    }
}
