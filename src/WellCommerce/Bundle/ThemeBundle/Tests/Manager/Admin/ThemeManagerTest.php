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

namespace WellCommerce\Bundle\ThemeBundle\Tests\Manager\Admin;

use WellCommerce\Bundle\CoreBundle\Test\Manager\Admin\AbstractAdminManagerTestCase;

/**
 * Class ThemeManagerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ThemeManagerTest extends AbstractAdminManagerTestCase
{
    protected function get()
    {
        return $this->container->get('theme.manager.admin');
    }

    protected function getServiceClassName()
    {
        return \WellCommerce\Bundle\ThemeBundle\Manager\Admin\ThemeManager::class;
    }

    protected function getFormBuilderClassName()
    {
        return \WellCommerce\Bundle\ThemeBundle\Form\Admin\ThemeFormBuilder::class;
    }

    protected function getDataGridClassName()
    {
        return \WellCommerce\Bundle\ThemeBundle\DataGrid\ThemeDataGrid::class;
    }

    protected function getRepositoryInterfaceName()
    {
        return \WellCommerce\Bundle\ThemeBundle\Repository\ThemeRepositoryInterface::class;
    }
}
