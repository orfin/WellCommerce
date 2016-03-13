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

namespace WellCommerce\Bundle\LocaleBundle\Tests\Manager\Admin;

use WellCommerce\Bundle\CoreBundle\Test\Manager\Admin\AbstractAdminManagerTestCase;
use WellCommerce\Bundle\LocaleBundle\DataGrid\LocaleDataGrid;
use WellCommerce\Bundle\LocaleBundle\Form\Admin\LocaleFormBuilder;
use WellCommerce\Bundle\LocaleBundle\Manager\Admin\LocaleManager;
use WellCommerce\Bundle\LocaleBundle\Repository\LocaleRepositoryInterface;

/**
 * Class LocaleManagerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LocaleManagerTest extends AbstractAdminManagerTestCase
{
    protected function get()
    {
        return $this->container->get('locale.manager.admin');
    }

    protected function getServiceClassName()
    {
        return LocaleManager::class;
    }

    protected function getFormBuilderClassName()
    {
        return LocaleFormBuilder::class;
    }

    protected function getDataGridClassName()
    {
        return LocaleDataGrid::class;
    }

    protected function getRepositoryInterfaceName()
    {
        return LocaleRepositoryInterface::class;
    }
}
