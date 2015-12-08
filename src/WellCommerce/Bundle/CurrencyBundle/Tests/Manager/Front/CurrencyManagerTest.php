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

namespace WellCommerce\Bundle\CurrencyBundle\Front\Manager\Admin;

use WellCommerce\Bundle\CoreBundle\Test\Manager\Admin\AbstractAdminManagerTestCase;
use WellCommerce\Bundle\CoreBundle\Test\Manager\Front\AbstractFrontManagerTestCase;

/**
 * Class CurrencyManagerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CurrencyManagerTest extends AbstractFrontManagerTestCase
{
    protected function get()
    {
        return $this->container->get('currency.manager.front');
    }

    protected function getServiceClassName()
    {
        return \WellCommerce\Bundle\CurrencyBundle\Manager\Front\CurrencyManager::class;
    }

    protected function getRepositoryInterfaceName()
    {
        return \WellCommerce\Bundle\CurrencyBundle\Repository\CurrencyRepositoryInterface::class;
    }
}
