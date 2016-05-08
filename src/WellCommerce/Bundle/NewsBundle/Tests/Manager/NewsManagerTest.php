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

namespace WellCommerce\Bundle\NewsBundle\Tests\Manager;

use WellCommerce\Bundle\CoreBundle\Test\Manager\AbstractManagerTestCase;
use WellCommerce\Bundle\DoctrineBundle\Manager\Manager;
use WellCommerce\Bundle\DoctrineBundle\Manager\ManagerInterface;
use WellCommerce\Bundle\NewsBundle\Factory\NewsFactory;
use WellCommerce\Bundle\NewsBundle\Repository\NewsRepositoryInterface;

/**
 * Class NewsManagerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class NewsManagerTest extends AbstractManagerTestCase
{
    protected function get() : ManagerInterface
    {
        return $this->container->get('news.manager');
    }

    protected function getRepositoryInterfaceName()
    {
        return NewsRepositoryInterface::class;
    }

    protected function getFactoryInterfaceName() : string
    {
        return NewsFactory::class;
    }
}
