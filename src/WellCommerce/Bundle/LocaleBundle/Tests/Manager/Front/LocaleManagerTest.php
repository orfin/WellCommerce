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

namespace WellCommerce\Bundle\LocaleBundle\Front\Manager\Admin;

use WellCommerce\Bundle\CoreBundle\Test\Manager\Front\AbstractFrontManagerTestCase;
use WellCommerce\Bundle\LocaleBundle\Manager\Front\LocaleManager;
use WellCommerce\Bundle\LocaleBundle\Repository\LocaleRepositoryInterface;

/**
 * Class LocaleManagerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LocaleManagerTest extends AbstractFrontManagerTestCase
{
    protected function get()
    {
        return $this->container->get('locale.manager.front');
    }

    protected function getServiceClassName()
    {
        return LocaleManager::class;
    }

    protected function getRepositoryInterfaceName()
    {
        return LocaleRepositoryInterface::class;
    }
}
