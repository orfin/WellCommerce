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

namespace WellCommerce\AppBundle\Tests\Manager\Front;

use WellCommerce\AppBundle\Test\Manager\Front\AbstractFrontManagerTestCase;

/**
 * Class ProducerManagerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProducerManagerTest extends AbstractFrontManagerTestCase
{
    protected function get()
    {
        return $this->container->get('producer.manager.front');
    }

    protected function getServiceClassName()
    {
        return 'WellCommerce\AppBundle\Manager\Front\ProducerManager';
    }

    protected function getRepositoryInterfaceName()
    {
        return 'WellCommerce\AppBundle\Repository\ProducerRepositoryInterface';
    }
}
